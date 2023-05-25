<?php

namespace App\Exports;
   
use App\Models\History;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoriesExport implements FromCollection, WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return History::all();
    }
    public function map($row): array{
        $fields = [
           $row->id,
           $row->reference,
           $row->picking_id,
           $row->taush_id,
           $row->scan_date_time,
      ];
     return $fields;
 }
    public function headings(): array
    {
        return [
            'id',
            'referencia',
            'picking_id',
            'taush_id',
            'scan_date_time',
        ];
    }
}
