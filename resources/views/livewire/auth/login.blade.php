<div>
    <div class="card-body cardbody-color p-lg-5">
        <div class="text-center mb-3">
            <img src="assets/images/logo/logo-dpws.png" alt="profile">
        </div>

        @if ($currentStep == 1)
            <div class="mb-3">
                <label>Votre email</label>
                <input type="email" wire:model.defer="email" class="form-control " placeholder="Votre email" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="text-center">
                <button wire:click="firstStepEmail" wire:loading.attr="disabled"
                    class="btn btn-primary px-5 mb-5 w-100">
                    <div class="spinner-border" wire:loading role="status"></div>
                    <div wire:loading.remove> Suivant </div>
                </button>
            </div>
        @endif

        @if ($currentStep == 2)

            {{-- @if ($user->role == 'user')
            @endif --}}
            <div class="mb-3">
                <label>Votre Mot de passe</label>
                <input wire:model.defer="password" type="password" class="form-control "
                    placeholder="votre mot de passe" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @if ($user->role == 'admin' || $user->role == 'support' || $user->role == 'administration' || $user->role == 'account')
                <div class="text-center">
                    <button wire:click="twoStepPassword" class="btn btn-primary px-5 mb-5 w-100"
                     wire:loading.attr="disabled">
                        <div class="spinner-border" wire:loading role="status"></div>
                        <div wire:loading.remove> Se connecter </div>
                    </button>
                </div>
            @endif
            @if ($user->role == 'user')
                <div class="text-center">
                    <button wire:click="twoStepPassword"  class="btn btn-primary px-5 mb-5 w-100"
                         wire:loading.attr="disabled">
                        <div class="spinner-border" wire:loading role="status"></div>
                        <div wire:loading.remove> Suivant </div>
                    </button>
                </div>
            @endif
        @endif

        @if ($currentStep == 3)
            <div class="mb-3">
                <div class="select-position">
                    <label for="exampleFormControlInput1" class="form-label">Vous travaillez sur quel pont ?</label>
                    <select wire:model.defer="bridge" class="form-select">
                        <option value="" selected>selectionner votre pont</option>
                        @foreach ($weighbridges as $weighbridge)
                            <option value="{{ $weighbridge->id }}">{{ $weighbridge->label }}</option>
                        @endforeach
                    </select>
                    @error('bridge')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button wire:click="threeStepRole" wire:loading.attr="disabled" class="btn btn-primary px-5 mb-5 w-100">
                    <div class="spinner-border" wire:loading role="status"></div>
                    <div wire:loading.remove> Se connecter </div>
                </button>
            </div>
        @endif

        @if ($currentStep == 4)
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input wire:model.defer="password" name="password" type="password" class="form-control"
                    placeholder="votre mot de passe" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer mot le de passe</label>
                <input type="password" wire:model.defer="password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="recommencer" />
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center">
                <button wire:click="resetPassword" wire:loading.attr="disabled" class="btn btn-primary px-5 mb-5 w-100">
                    <div class="spinner-border" wire:loading role="status"></div>
                    <div wire:loading.remove> Se connecter </div>
                </button>
            </div>
        @endif

    </div>

</div>
