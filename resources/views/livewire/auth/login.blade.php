<div>

<div class="card-body cardbody-color p-lg-5">
        <div class="text-center mb-3">
            <img src="assets/images/logo/logo-dpws.png" alt="profile">
        </div>

        @if($currentStep == 1)
            <div class="mb-3">
                <label>Votre email</label>
                <input type="email" wire:model="email" class="form-control "
                       placeholder="Votre email" />
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="text-center"><button wire:click="firstStepEmail" class="btn btn-primary px-5 mb-5 w-100">Suivant</button></div>
        @endif

        @if($currentStep == 2)

            @if ($user->role == "user")

            @endif
            <div class="mb-3">
                <label>Votre Mot de passe</label>
                <input wire:model="password" type="password" class="form-control "
                       placeholder="votre mot de passe" />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
                @if($user->role == "admin")
            <div class="text-center"><button wire:click="twoStepPassword" class="btn btn-primary px-5 mb-5 w-100">Se connecter</button></div>
                @endif
                @if($user->role == "user")
            <div class="text-center"><button wire:click="twoStepPassword" class="btn btn-primary px-5 mb-5 w-100">Suivant</button></div>
                @endif
        @endif

        @if($currentStep == 3)
            <div class="mb-3">
                <div class="select-position">
                    <label for="exampleFormControlInput1" class="form-label">Vous travaillez sur quel pont ?</label>
                    <select  wire:model ="bridge" class="form-select" >
                        <option value="" selected>selectionner votre pont</option>
                        @foreach ($weighbridges as $weighbridge )
                            <option value="{{$weighbridge->id}}">{{$weighbridge->label}}</option>
                        @endforeach
                    </select>
                    @error('bridge') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="text-center"><button wire:click="threeStepRole" class="btn btn-primary px-5 mb-5 w-100">Se connecter</button></div>
        @endif

        @if($currentStep == 4)
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input wire:model="password" name="password" type="password" class="form-control"
                       placeholder="votre mot de passe" />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmer mot le de passe</label>
            <input type="password" wire:model="password_confirmation" name="password_confirmation" class="form-control" placeholder="recommencer"  />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="text-center"><button wire:click="resetPassword" class="btn btn-primary px-5 mb-5 w-100">Se connecter</button></div>
    @endif
    
</div>

</div>
