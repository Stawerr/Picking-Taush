<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaushRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TaushesImport;

/**
 * Class TaushCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaushCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Taush::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/taush');
        CRUD::setEntityNameStrings('taush', 'taushes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'name', 'type' => 'string', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'reference', 'type' => 'string', 'label' => 'Referência']);

        CRUD::addButtonFromView('top', 'import-csv-taushes', 'import-csv-taushes', 'end');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'reference', 'type' => 'text', 'label' => 'Referência']);
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
        CRUD::addColumn(['name' => 'name', 'type' => 'string', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'reference', 'type' => 'string', 'label' => 'Referência']);
    }

    public function import(TaushRequest $request) 
    {
        if($request->file){
            Excel::import(new TaushesImport, $request->file);
            
            return redirect('admin/taush')->with('success', 'Ficheiro importado com sucesso!');
        }
        else{
            return redirect('admin/taush')->with('success', 'Ficheiro inexistente!');
        }
    }
}
