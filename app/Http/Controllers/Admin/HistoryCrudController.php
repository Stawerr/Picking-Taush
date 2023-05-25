<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HistoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Picking;
use App\Models\Taush;
use App\Models\History;
use Carbon\Carbon;
use App\Exports\HistoriesExport;
use Maatwebsite\Excel\Facades\Excel;
/**
 * Class HistoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HistoryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\History::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/history');
        CRUD::setEntityNameStrings('history', 'histories');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    { 
        CRUD::addColumn(['name' => 'log_type', 'type' => 'enum', 'label' => 'Tipo de log']);
        CRUD::addColumn(['name' => 'reference', 'type' => 'string', 'label' => 'Referencia']);
        CRUD::addColumn(['name' => 'picking_id', 'type' => 'foreignId', 'label' => 'PickingId']);
        CRUD::addColumn(['name' => 'taush_id', 'type' => 'foreignId', 'label' => 'TaushId']);
        CRUD::addColumn(['name' => 'scan_date_time', 'type' => 'dateTime', 'label' => 'Data de scan']);
        CRUD::addColumn(['name' => 'log_message', 'type' => 'string', 'label' => 'Mensagem de log']);
        CRUD::addButtonFromView('top', 'moderate', 'create-history','create-history', 'end');
        CRUD::addButtonFromView('top', 'export-history','export-history', 'end');
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(HistoryRequest::class);

        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
    public function createHistory(HistoryRequest $request) 
    {

        $pickings= Picking::all();
        $taushs= Taush::all();
        $historys = History::all();
        $pickingMessage = 'Referencia '.$request->reference.' não encontrada em picking';
        $taushMessage = 'Referencia '.$request->reference.' não é peça taush';
        $digitalizedMessage= '';
        $history= new History();
        $history->log_type = 'error';
        $history->log_message= $pickingMessage;
        $history->reference = $request->reference;
        $history->scan_date_time=Carbon::now()->addhours(1)->ToDateTimeString();
        //Verificar se existe na picking
        foreach($pickings as $picking) {
            if($request->reference == $picking->reference) {
                $pickingMessage = 'Referencia ' .$request->reference.' encontrada em picking';
                $history->log_message= $pickingMessage;
                $history->log_type = 'success';
                $history->picking_id = $picking->id;
                //Verificar se já foi digitalizada
                if($picking->digitalized == 0){
                    $picking->digitalized=1;
                    $picking->scan_date= Carbon::now()->ToDateString();
                    $picking->last_scan_date= Carbon::now()->ToDateString();
                }else{
                    $digitalizedMessage='Referencia'.$request->reference.' já foi digitalizada';
                    $history->log_message= $digitalizedMessage;
                    $picking->last_scan_date= Carbon::now()->ToDateString();
                }
                $picking->save();                
                break;
            }
        }
        $history->save();

        $history= new History();
        $history->log_type = 'error';
        $history->log_message= $taushMessage;
        $history->reference = $request->reference;
        $history->scan_date_time=Carbon::now()->addhours(1)->ToDateTimeString();
        //Verificar se existe na taush
        foreach($taushs as $taush) {
            if($request->reference == $taush->reference) {
                $taushMessage = 'Referencia '.$request->reference. ' é peça taush';
                $history->log_message= $taushMessage;
                $history->log_type = 'success';
                $history->taush_id=$taush->id;
                //Verificar se já foi digitalizada
                if($taush->digitalized == 0){
                    $taush->digitalized=1;
                    $taush->scan_date= Carbon::now()->ToDateString();
                    $taush->last_scan_date= Carbon::now()->ToDateString();
                }else{
                    $digitalizedMessage='Referencia'.$request->reference.' já foi digitalizada';
                    $history->log_message= $digitalizedMessage;
                    $taush->last_scan_date= Carbon::now()->ToDateString();
                }
                $taush->save();
                break;
            }
        }
        $history->save();

        return redirect()->back()->with('taushMessage',$taushMessage)->with('pickingMessage',$pickingMessage)->with('digitalizedMessage',$digitalizedMessage);
    }
    public function exportHistory(){
        return Excel::download(new HistoriesExport, 'history.xlsx');
    }
}
