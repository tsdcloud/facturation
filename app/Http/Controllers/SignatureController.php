<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Signature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    
    public function index(){

        $breadcrumb = "signature";
        $signatures = Signature::all();
        return view('signature.index',compact('signatures','breadcrumb'));
    }

    public function create(){

        $breadcrumb = "Creer une signature";
        $users = User::all();
        return view('signature.create',compact('users','breadcrumb'));
    }

    public function store(Request $request){

            $request->validate([
                'user_id' => 'required',
                'path' => 'required'
            ]);

        $signature = Signature::create([
            'path' => '',
            'user_id' =>  $request->user_id,
        ]);
        $user = Str::substr($signature->user->name,0,15);
        tap($signature)->update(['path'=> $request->path->store('signature/'.$user,'public')]);

        return redirect()->route('signature.index')->with('message','signature enregistré avec succès');
    }
}
