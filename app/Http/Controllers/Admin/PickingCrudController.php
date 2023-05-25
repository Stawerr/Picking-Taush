<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PickingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PickingsImport;

/**
 * Class PickingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PickingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Picking::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/picking');
        CRUD::setEntityNameStrings('picking', 'pickings');
    
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'id', 'type' => 'int', 'label' => 'id']);
        CRUD::addColumn(['name' => 'reference', 'type' => 'string', 'label' => 'Referência']);
        CRUD::addColumn(['name' => 'department', 'type' => 'string', 'label' => 'Departamento']);
        CRUD::addColumn(['name' => 'digitalized', 'type' => 'boolean', 'label' => 'Digitalizado']);
        CRUD::addColumn(['name' => 'scan_date', 'type' => 'date', 'label' => 'Data de scan']);
        CRUD::addColumn(['name' =>'last_scan_date', 'type' => 'date', 'label' => 'Última data de scan']);
        CRUD::addButtonFromView('top', 'import-csv-pickings', 'import-csv-pickings', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::addField(['name' => 'reference', 'type' => 'text', 'label' => 'Referência']);
        CRUD::addField(['name' => 'department', 'type' => 'text', 'label' => 'Departamento']);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
         CRUD::addColumn(['name' => 'reference', 'type' => 'string', 'label' => 'Referência']);
        CRUD::addColumn(['name' => 'department', 'type' => 'string', 'label' => 'Departamento']);
        CRUD::addColumn(['name' => 'scan_date', 'type' => 'date', 'label' => 'Data de scan']);
        CRUD::addColumn(['name' =>'last_scan_date', 'type' => 'date', 'label' => 'Última data de scan']);
    }

    public function import(PickingRequest $request) 
    {
        if($request->file){
            Excel::import(new PickingsImport, $request->file);
            
            return redirect('admin/picking')->with('success', 'Ficheiro importado com sucesso!');
        }
        else{
            return redirect('admin/picking')->with('success', 'Ficheiro inexistente!');
        }
    }
}
