<div>
    <div class="form-elements-wrapper">
        {{-- <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Solde veuille</h6>
                            <h6 class="text-bold mb-10"> 0 FCFA</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Solde actuel</h6>
                        <h6 class="text-bold mb-10 text-danger">0 FCFA</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Total Dépôt</h6>
                        <h6 class="text-bold mb-10"> 0 FCFA</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="icon purple">
                        <i class="lni lni-cart-full"></i>
                    </div>
                    <div class="content">
                        <h6 class="mb-10">Total Retrait</h6>
                        <h6 class="text-bold mb-10"> 0 FCFA</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
        </div> --}}
        <div class="row">
            {{-- @if(session()->has('message'))
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
            @endif --}}
            <div class="col-lg-12">
                <!-- input style start -->
                <div class="card-style mb-30">
                    <h6 class="mb-25" >Facturation</h6>
                    <div class="row">
                        <div class="input-style-1">
                            <label>Reçu de </label>
                            <input type="text" wire:model.defer="name" />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6" >
                            <div class="input-style-1">
                                <label>N° Tracteur </label>
                                <input type="text" wire:model.defer="tractor" />
                                @error('tractor') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6" >
                            <div class="input-style-1">
                            <label>N° Remorque </label>
                                <input type="text" wire:model.defer="trailer" />
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
                            <div class="select-style-1">
                                <label>Pont bascule</label>
                                <div class="select-position">
                                    <select  wire:model.defer ="weighbridgeId" >
                                        <option value="" selected>selectionner votre pont</option>
                                        @foreach ($weighbridges as $weighbridge )
                                           <option value="{{$weighbridge->id}}">{{$weighbridge->label}}</option>
                                        @endforeach
                                        </select>
                                        @error('weighbridgeId') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end input -->
                    <div class="input-style-1">
                        <label>Montant versé</label>
                        <input type="number"  min="0" placeholder="Montant versé" wire:model.defer ="amountPaid"/>
                        @error('amountPaid') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-style-1">
                        <label>Reste à rembourser</label>
                        <input type="number"  min="0" placeholder="saisir le montant à rembourser" wire:model.defer="remains"/>
                    </div>
                    <div class="text-center">
                        <button wire:click="store"
                        class="main-btn active-btn-outline rounded-md btn-hover">Imprimer
                        </button>
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

        <!-- Historique de transaction journalière -->
        {{-- @php
            $i = 1
        @endphp
        <div class="row">
            <h3 class="mb-5">Historique facture Journalier</h3>
            <div class="col-lg-12">
                <div class="tab-style-1">
                    <div class="tab-content" id="nav-tabContent1">
                        <div class="tab-pane fade show active" wire:ignore.self id="tabContent-1-1">
                            <div class="card-style mb-30">
                                <h6 class="mb-10">Facture </h6>
                                <div class="d-flex flex-wrap justify-content-between  align-items-center py-3">
                                    <div class="left">
                                        <p> Les 10 premiers reçus</p>
                                    </div>
                                    <div class="right">
                                        <div class="table-search d-flex align-items-md-end">
                                            <form action="#">
                                                <input type="text" wire:model.debounce.500ms="searchTrailerandTractorNumFac"
                                                 placeholder="Tracteur / Remorque / N° Fact" />
                                                <button><i class="lni lni-search-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrapper table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="lead-info"><h6>N° facture</h6></th>
                                            <th class="lead-email"><h6>N° tracteur</h6></th>
                                            <th class="lead-phone"><h6>N° remorque</h6></th>
                                            <th class="lead-company"><h6>Mode paiement</h6></th>
                                            <th class="lead-company"><h6>Pont bascule</h6></th>
                                            <th><h6>Actions</h6></th>
                                        </tr>
                                        <!-- end table row-->
                                        </thead>
                                        <tbody>
                                     @forelse ($dailyInvoices as $invoice)
                                     <tr>
                                        <td class="text-sm" >
                                           {{$invoice->invoice_no}}
                                        </td>
                                        <td>
                                            <p> {{$invoice->tractor}}</p>
                                        </td>
                                        <td>
                                            <p>{{$invoice->trailer}} </p>
                                        </td>
                                        <td>
                                            <p>{{$invoice->modePayment->label}}</p>
                                        </td>
                                        <td>
                                            <p>{{$invoice->weighbridge->label}}</p>
                                        </td>
                                        <td>
                                            <div class="action">
                                                <button class="text-primary" wire:click="downloadPDF({{$invoice->id}})">
                                                    <i class="lni lni-printer"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                     @empty

                                     @endforelse


                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
                                <div class="pt-10 d-flex flex-wrap justify-content-between">
                                    <div class="left">
                                        <p class="text-sm text-gray">   {{$dailyInvoices->total() > 10 ? 'Afficher 10 /'.$dailyInvoices->total() . 'Dépôts' : '' }}  </p>
                                    </div>
                                    <div class="right table-pagination">
                                        {{$dailyInvoices->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div> --}}
        <!-- end row -->
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('closeAlert',closeAlert);
        function closeAlert(){
            setTimeout(()=>{
                let alertNode = document.querySelector('#alert-message');
                let alert = new bootstrap.Alert(alertNode);
                alert.close()
            },3000)
        }
    </script>
@endpush
