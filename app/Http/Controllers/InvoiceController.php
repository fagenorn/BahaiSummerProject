<?php

namespace App\Http\Controllers;

use App\Group;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel as Excel;
use TCG\Voyager\Facades\Voyager;

class InvoiceController extends Controller
{
    public function create($id)
    {
        Voyager::canOrFail('read_groups');

        $group = Group::findOrFail($id);
//        return view('invoice', array('group' => $group));
        $pdf = PDF::loadView('invoice', array('group' => $group));
        return $pdf->stream('invoice.pdf');
    }

    public function download()
    {
        Voyager::canOrFail('read_groups');

        Excel::create('Filename', function ($excel) {

            // Set the title
            $excel->setTitle('Groups');
            $excel->sheet('Groups', function ($sheet) {
                $sheet->row(1, array(
                    'Last Name', 'Email', 'Phone'
                ));
                $sheet->cells('A1:C1', function($cells) {
                    $cells->setFontSize(14);
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });

                $groups = Group::all();
                for ($i = 1; $i <= count($groups); $i++) {
                    $group = $groups[$i-1];
                    $sheet->row($i+1, array(
                        $group -> last_name, $group -> email, $group -> phone
                    ));
                }
            });

        })->download('xlsx');
    }
}
