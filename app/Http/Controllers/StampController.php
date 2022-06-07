<?php

namespace App\Http\Controllers;

use App\Models\Stamp;
use App\Models\Weighbridge;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StampController extends Controller
{
    public function index(){

        $breadcrumb = "cachet";
        $stamps = Stamp::all();

        return view('stamp.index',compact('breadcrumb','stamps'));
    }

    public function create(){
        $breadcrumb = "Creer cachet";
        $weighbridges = Weighbridge::all();
        return view('stamp.create',compact('breadcrumb','weighbridges'));
    }

    public function store(Request $request){


        $request->validate([
            'weighbridge_id' => 'required',
            'path' => 'required'
        ]);

        $stamp = Stamp::create([
            'path' => '',
            'weighbridge_id' => $request->weighbridge_id,
        ]);

        $bridge = $stamp->weighbridge->label;

        tap($stamp)->update(['path' => $request->path->store('Stamp/'.$bridge,'public')]);

        return redirect()->route('stamp.index')->with('message','cachet enregistré avec succès');
    }
}
