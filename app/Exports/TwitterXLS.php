<?php

namespace App\Exports;

use App\Models\TwitterStream;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TwitterXLS implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        return TwitterStream::select('id','screen_name','full_text')->get();
    }

    public function model(array $row)
    {
        return new TwitterStream([
            'id'  => $row['id'],
            'screen_name' => $row['screen_name'],
            'full_text'    => $row['full_text'],
        ]);
    }

    // public function headings(): array
    // {
    //     return [
    //         'id',
    //         'Screen_name',
    //         'full_text',
    //         'Class',
    //         'Ubah Class'
    //     ];
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}