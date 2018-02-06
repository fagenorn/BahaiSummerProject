<?php

namespace App\Http\Controllers;

use App\Group;
use Barryvdh\DomPDF\Facade as PDF;
use TCG\Voyager\Facades\Voyager;

class InvoiceController extends Controller
{
    public function create($id)
    {
        Voyager::canOrFail('read_groups');

        $group = Group::findOrFail($id);

        $pdf = PDF::loadView('invoice', array('group' => $group));
        return $pdf->stream();
    }
}
