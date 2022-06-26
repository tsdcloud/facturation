
<div>
    <div class="form-elements-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <!-- input style start -->
                <div class="card-style mb-30">
                    <h6 class="mb-25" >Facturation</h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6>Single Select with Label</h6>
                            <input type="text" wire:model="tractor" class="form-control">
                            <div class="absolute z-10 mt-1 w-full text-sm overflow-auto px-2">
                                <ul class="list-group">
                                    @if (empty($tractors) && $tractor != '' )
                                        pas de resultat
                                        @else
                                            @if (!empty($tractors) && $tractor != '')
                                                @foreach($tractors as $i => $tractor)
                                                    <a href="javascript:void(0)"  wire:click="selectTractor({{ $i }})"
                                                       class="list-group-item list-group-item-action">{{$tractor['label']}}
                                                    </a>
                                                @endforeach
                                            @endif
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="input-style-1">
                            <label>Reçu de  <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#Modalfive"> Ajouter un client</a> </label>
                            <input type="text"
                                   placeholder="Rechercher un client..."
                                   wire:model="customer"

                            />
                            @if(!empty($customer) && $selectedCustomer == 0 && $showDropdown1)
                                <div class="absolute z-10 bg-white mt-1 w-full border border-gray-300 rounded-md shadow-lg overflow-auto">
                                    @if (!empty($customer))
                                        @foreach($customers as $i => $customer)
                                            <a role="button"
                                               wire:click="selectCustomer({{ $i }})"
                                               class="block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndexCustomer === $i ? 'bg-blue-50' : '' }}"
                                            >{{$customer['label']  }}</a>
                                        @endforeach
                                    @else
                                        <span class="block py-1 px-2 text-sm">Pas de résultat</span>
                                    @endif
                                </div>
                            @endif
                            @error('customer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6" >
                            <div class="input-style-1">
                                <label>N° Tracteur <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#ModalTree"> Ajouter un tracteur</a> </label>
                                <input type="text"
                                       placeholder="Rechercher le tracteur..."
                                       wire:model="tractor"
                                       wire:keydown.escape="hideDropdown2"
                                       wire:keydown.tab="hideDropdown2"
                                       wire:keydown.Arrow-Up="decrementHighlight"
                                       wire:keydown.Arrow-Down="incrementHighlight"
                                       wire:keydown.enter.prevent="selectTractor"
                                />

                                @if(!empty($tractor) && $selectedTractor == 0 && $showDropdown2)
                                    <div class="absolute z-10 bg-white mt-1 w-full border border-gray-300 rounded-md shadow-lg overflow-auto">
                                        @if (!empty($tractors))
                                            @foreach($tractors as $i => $tractor)
                                                <a role="button"
                                                    wire:click="selectTractor({{ $i }})"
                                                    class="block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndex === $i ? 'bg-blue-50' : '' }}"
                                                >{{ $tractor['label'] }}</a>
                                            @endforeach
                                        @else
                                            <span class="block py-1 px-2 text-sm">Pas de résultat</span>
                                        @endif
                                    </div>
                                @endif
                                @error('tractor') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6" >
                            <div class="input-style-1">
                            <label>N° Remorque <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#Modalfour"> Ajouter une remorque</a> </label>
                                <input type="text" wire:model.defer="trailer"
                                       placeholder="Rechercher la remorque..."
                                       wire:model="trailer"
                                       wire:keydown.escape="hideDropdown3"
                                       wire:keydown.tab="hideDropdown3"
                                       wire:keydown.Arrow-Up="decrementHighlight"
                                       wire:keydown.Arrow-Down="incrementHighlightTrailer"
                                       wire:keydown.enter.prevent="selectTrailer"
                                />
                                @if(!empty($trailer) && $selectedTrailer == 0 && $showDropdown3)
                                    <div class="absolute z-10 bg-white mt-1 w-full border border-gray-300 rounded-md shadow-lg overflow-auto">
                                        @if (!empty($trailers))
                                            @foreach($trailers as $i => $trailer)
                                                <a role="button"
                                                   wire:click="selectTrailer({{ $i }})"
                                                   class="block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndexTrailer === $i ? 'bg-blue-50' : '' }}"
                                                >{{ $trailer['label'] }}</a>
                                            @endforeach
                                        @else
                                            <span class="block py-1 px-2 text-sm">Pas de résultat</span>
                                        @endif
                                    </div>
                                @endif
                                @error('trailer') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="select-style-1">
                                <label>Mode paiement</label>
                                <div class="select-position">
                                    <select wire:model.defer="modePaymentId" >
                                        <option value="" selected >Selectionner le mode</option>
                                        @foreach ($modePayments as $modePayment )
                                            <option value="{{$modePayment->id}}">{{$modePayment->label}}</option>
                                        @endforeach
                                        </select>
                                        @error('modePaymentId') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end input -->
                        <div class="col-md-6">
                            <div class="input-style-1">
                                <label>Pont bascule </label>
                                <input type="text" wire:model="weighbridge" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="select-style-1">
                                <label>Type de pesée</label>
                                <div class="select-position">
                                    <select wire:model="typeWeighing" >
                                        <option value="" selected >Selectionner la pesée</option>
                                        @foreach ($listTypeWeighing as $type_weighing)
                                            <option value="{{$type_weighing->id}}">{{$type_weighing->label}}</option>
                                        @endforeach
                                    </select>
                                    @error('typeWeighing') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="input-style-1">
                            <label>Montant versé</label>
                            <input type="number" min="0" wire:model ="amountPaid" class="form-control" aria-label="Text input with checkbox"/>
                        </div>
                            @error('amountPaid') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <!-- end input -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-style-1">
                                <label>Montant HT</label>
                                <input type="number" disabled wire:model="subtotal"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-style-1">
                                <label>Montant TTC</label>
                                <input type="number" disabled wire:model="total_amount"/>
                            </div>
                        </div>
                    </div>

                    <div class="input-style-1">
                        <label>Reste à rembourser</label>
                        <input type="number" disabled wire:model="remains"/>
                    </div>
                    <div class="text-center">
                        @if (Auth::user()->isChefGuerite())
                            <button wire:click="store"
                            class="main-btn active-btn-outline rounded-md btn-hover">Imprimer
                            </button>
                        @endif
                    </div>
                </div>
                <!-- end card -->

                @if(session()->has('message'))
                <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('message')}} </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{session('error')}} </strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>
            <!-- end col  -->

            {{-- Fin depôt --}}
        </div>

        {{-- afficher la facture --}}
        <div class="warning-modal" >
            <div wire:ignore.self id="myModal" class="modal fade mod" data-bs-backdrop="static" data-bs-keyboard="false"
                 id="ModalTwo" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog  modal-xl">
                    <div class="modal-content card-style">
                        <div class="modal-header px-0 border-0 d-flex justify-content-end ">
                            <button class="border-0 bg-transparent h2" wire:click="cancel"  data-bs-dismiss="modal">
                                <i class="lni lni-cross-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body px-0">
                            @if(!is_null($id_invoice))
                               <iframe src="{{route('show-pdf',$id_invoice)}}"  width="100%" height="500px"></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- nouveau tracteur --}}
        <div class="warning-modal">
            <div  wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalTree" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card-style warning-card">
                        @if(session()->has('new-tractor'))
                            <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session('new-tractor')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error-tractor'))
                            <div id="alert-message" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{session('error-tractor')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title">Nouveau tracteur</h5>
                        </div>
                        <div class="modal-body">
                            <div class="input-style-1">
                                <label>Tracteur</label>
                                <input type="text" wire:model.defer="newTractor" placeholder="" />
                                @error('newTractor') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-center">
                                <button class="main-btn danger-btn-outline rounded-md btn-hover" data-bs-dismiss="modal"
                                        wire:click="storeTractor">Fermer
                                </button>
                                <button class="main-btn active-btn-outline rounded-md btn-hover"
                                        wire:click="storeTractor">Ajouter
                                </button>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- nouvelle remorque --}}
        <div class="warning-modal">
            <div  wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="Modalfour" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card-style warning-card">
                        @if(session()->has('new-trailer'))
                            <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session('new-trailer')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error-trailer'))
                            <div id="alert-message" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{session('error-trailer')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title">Nouvelle remorque</h5>
                        </div>
                        <div class="modal-body">
                            <div class="input-style-1">
                                <label>Remorque</label>
                                <input type="text" wire:model.defer="newTrailer" placeholder="" />
                                @error('new-trailer') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-center">
                                <button class="main-btn danger-btn-outline rounded-md btn-hover" data-bs-dismiss="modal"
                                        wire:click="cancelTrailer">Fermer
                                </button>
                                <button class="main-btn active-btn-outline rounded-md btn-hover"
                                        wire:click="storeTrailer">Ajouter
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- nouveau client --}}
        <div class="warning-modal">
            <div  wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="Modalfive" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card-style warning-card">
                        @if(session()->has('new-customer'))
                            <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{session('new-customer')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error-customer'))
                            <div id="alert-message" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{session('error-customer')}} </strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="modal-header">
                            <h5 class="modal-title">Nouveau client</h5>
                        </div>
                        <div class="modal-body">
                            <div class="input-style-1">
                                <label>Client</label>
                                <input type="text" wire:model.defer="newCustomer" placeholder="" />
                                @error('new-customer') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="text-center">
                                <button class="main-btn danger-btn-outline rounded-md btn-hover" data-bs-dismiss="modal"
                                        wire:click="cancelCustomer">Fermer
                                </button>
                                <button class="main-btn active-btn-outline rounded-md btn-hover"
                                        wire:click="storeCustomer">Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.js" ></script>
    <script>

        document.addEventListener('closeAlert', closeAlert);

        function closeAlert(){

            setTimeout(()=>{
                let alertNode = document.querySelector('#alert-message');
                let alert = new bootstrap.Alert(alertNode);
                alert.close()
            },3000)

            const myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
          // window.open('".$url."', '_blank')
        }
    </script>
@endpush
