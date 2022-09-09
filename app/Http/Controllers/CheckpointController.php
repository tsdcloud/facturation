<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckpointController extends Controller
{
    public function index()
    {
        $breadcrumb = "Contrôle camion";
        return view('checkpoint.index', compact('breadcrumb'));
    }

    public function edit(Invoice $invoice)
    {

        $invoice = Invoice::where('id', $invoice->id)->first();

        if (is_null($invoice))
            throw new \Exception;

        $breadcrumb = "Détails";
        return view('checkpoint.detail', compact('breadcrumb', 'invoice'));
    }

    public function updateEntry(Invoice $invoice)
    {

        try {

            $invoice = Invoice::where('id', $invoice->id)->first();

            if (is_null($invoice))
                throw new \Exception('impossible de trouver la facture');

            $invoice->update([
                'seen_entry_control' => 'oui',
                'name_controleur_input' => auth()->user()->name,
                'date_entry' => Carbon::now(),
                'weighbridge_entry' => auth()->user()->currentBridge
            ]);

            session()->flash('success', 'contrôle en entrée ok');
            return redirect()->to('/checkpoint/index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'une erreur est survenu, veuillez réessayer si besoin rapproché vous d\'un IT en service');
            return redirect()->back();
        }
    }

    public function updateExit(Invoice $invoice)
    {

        try {
            $invoice = Invoice::where('id', $invoice->id)->first();

            if (is_null($invoice))
                throw new \Exception('impossible de retrouver cette facture... delail');

            $invoice->update([
                'seen_exit_control' => 'oui',
                'name_controleur_ouput' => auth()->user()->name,
                'date_exit' => Carbon::now(),
                'weighbridge_exit' => auth()->user()->currentBridge
            ]);
            session()->flash('success', 'contrôle en entrée ok');
            return redirect()->to('/checkpoint/index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', 'une erreur est survenu, veuillez réessayer si besoin rapproché vous d\'un IT en service');
            return redirect()->back();
        }
    }
}
