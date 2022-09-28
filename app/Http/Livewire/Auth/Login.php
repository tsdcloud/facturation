<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Models\Weighbridge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $currentStep = 1, $email = null, $password = null, $user = null, $bridge = null,
    $password_confirmation = null;

    public function render()
    {
        return view('livewire.auth.login',[
//            'weighbridges' => Weighbridge::all()->reject(function($bridge){
//                return $bridge->label == "Direction" && $bridge->label == "P18" && $bridge->label == "P19";
//            }),
            'weighbridges' => Weighbridge::whereIn('id', ['1', '2','3','4','5','6','7','8','9','10','11'])->get()

        ]);
    }

    //étape de validation de l'email
    public function firstStepEmail(){
         $this->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'veuillez saisir votre email',
            ],
        );

        if (User::where('email',$this->email)->exists()){

            $this->user = User::where('email', $this->email)->first();

                if (!$this->user->firstLogin)
                    return $this->currentStep = 4;

            $this->currentStep = 2;
        }else{
            $this->addError('email', 'email invalide');
        }
    }

    // validation du mot de passe
    public function twoStepPassword(){

        $this->validate(
            ['password' => 'required'],
            [
                'password.required' => 'veuillez saisir votre mot de passe',
            ],
        );

        if ($this->user && Hash::check($this->password, $this->user->password)){

            if ($this->user->role =="user" || $this->user->role =="ope")
                return $this->currentStep = 3;

                Auth::login($this->user);
                to_route('home');
        }else{

            $this->addError('password','mot de passe incorrect');
        }
    }

    // selection du pont
    public function threeStepRole(){
        $this->validate(
            ['bridge' => 'required'],
            [
                'bridge.required' => 'veuillez selectionner votre pont de travaille',
            ],
        );

        if ($this->user && Hash::check($this->password, $this->user->password)){

            Auth::login($this->user);

            tap($this->user)->update(['currentBridge' => $this->bridge]);

            to_route('home');
        }
    }

    public function resetPassword(){
        $this->validate(
            ['password' => 'required|confirmed'],
            ['password.required' => 'mot de passe non identique',]
            );
        tap($this->user)->update([
            'password' => Hash::make($this->password),
            'firstLogin' => true,
            'status' => 'actif',
        ]);
        $this->password = '';
        $this->password_confirmation = '';
        $this->currentStep = 2;
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }
}
