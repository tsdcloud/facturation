<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $currentStep = 1, $email = null, $password = null, $user = null, $bridge = null;

    public function render()
    {
        return view('livewire.auth.login',[
            'weighbridges' => Weighbridge::all()->reject(function($bridge){
                return $bridge->label == "Direction";
            }),
        ]);
    }

    public function firstStepEmail(){


         $this->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'veuillez saisir votre email',
            ],
        );

        if (User::where('email',$this->email)->exists()){
            $this->user = User::where('email', $this->email)->first();
            $this->currentStep = 2;
        }else{

            $this->addError('email', 'email invalide');
        }


    }

    public function twoStepPassword(){

        $this->validate(
            ['password' => 'required'],
            [
                'password.required' => 'veuillez saisir votre mot de passe',
            ],
        );

        //if ($this->)

        if ($this->user && Hash::check($this->password, $this->user->password)){

            if ($this->user->role =="user")
                 return $this->currentStep = 3;

            dd('ok');
            Auth::login($this->user);
            to_route('home');
        }else{

            $this->addError('password','mot de passe incorrect');
        }


    }

    public function threeStepRole(){


        $this->validate(
            ['bridge' => 'required'],
            [
                'bridge.required' => 'veuillez selectionner votre pont de travaille',
            ],
        );

        if ($this->user && Hash::check($this->password, $this->user->password)){

            Auth::login($this->user);
            session(['bridge',$this->bridge]);
            to_route('home');
        }
    }


    public function back($step)
    {
        $this->currentStep = $step;
    }

}
