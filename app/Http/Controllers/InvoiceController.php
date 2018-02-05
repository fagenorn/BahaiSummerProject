<?php

namespace App\Http\Controllers;

use App\Group;
use Carbon\Carbon;
use ConsoleTVs\Invoices\Classes\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;

class InvoiceController extends Controller
{
    public function create($id)
    {
        Voyager::canOrFail('read_groups');

        $group = Group::findOrFail($id);


        $invoice = Invoice::make()
            ->number("EE/ZS/" . Carbon::now()->format('Y') . "-" . $group->id)
            ->tax(0)
            ->notes('Compte/Rekening ASN des Bahá\'ís de Belgiqu'."\n".'Rue H. Evenepoel, 52-54 , 1030 Bruxelle'."\n".'IBAN: BE71 2100 0642 3169 BIC: GEBABEBB')
            ->customer([
                'name' => $group->last_name,
                'phone' => $group->phone,
                'location' => $group->address,
                'id' => $group->id,
            ])
            ->business([
                'name' => 'Bahá\'i',
                'location' => 'Rue du Millénaire, 1',
                'phone' => 'phone number',
                'id' => '---',
            ]);

        foreach ($group->users as $user) {
            $invoice->addItem($user->last_name . " " . $user->first_name, 100, 1, $user->id);
        }
        $invoice->show();
    }
}
