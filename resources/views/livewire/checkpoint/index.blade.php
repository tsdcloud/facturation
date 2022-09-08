<div>
    @if (session()->has('success'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-md-6 col-sm-12 col-lg-12">
        <div class="card-style">
            <h6 class="mb-25">Rechercher le camion</h6>
            <div class="row">
                <div class="input-style-1">
                    <input type="text" placeholder="Rechercher le tracteur/remorque..."
                        wire:model.debounce.500ms="search" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-12 mt-2">
            @foreach ($invoices as $invoice)
                <div class="card-style mb-3">
                    <p class="text-muted">Nom client : {{$invoice->customer->label }} </p>
                    <p class="text-muted">Tracteur : {{$invoice->myTractor->label }}</p>
                    <p class="text-muted">Remorque : {{optional($invoice->myTrailer)->label }}</p>
                    <a href="{{route('checkpoint.detail',$invoice)}}"  class="stretched-link"></a>
                </div>
            @endforeach
        </div>
    </div>


    <div class="warning-modal">
        <div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalTree"
            tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content card-style warning-card text-center">
                    <div class="modal-header px-0 border-0 d-flex justify-content-end ">
                        <button class="border-0 bg-transparent h1" data-bs-dismiss="modal">
                            <i class="lni lni-cross-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (!is_null($invoice))
                            <p class="text-muted">Nom client : {{ $invoice->customer->label }} </p>
                            <p class="text-muted">Tracteur : {{ $invoice->myTractor->label }}</p>
                            <p class="text-muted">Remorque : {{ optional($invoice->myTrailer)->label }}</p>
                            <p class="text-muted">Chef de guerite : {{ $invoice->user->name }}</p>
                            <p class="text-muted">Date facture : {{ $invoice->created_at->format('d/m/Y H:i:s') }}</p>
                            <p class="text-muted">Vu contrôle entrée : {{ $invoice->seen_entry_control }}</p>
                            <p class="text-muted">Date contrôle entrée : {{ $invoice->date_entry }}</p>
                            <p class="text-muted">Nom controleur entrée : {{ $invoice->name_controleur_input }}</p>
                            <p class="text-muted">Vu contrôle sortie : {{ $invoice->seen_exit_control }}</p>
                            <p class="text-muted">Date contrôle sortie : {{ $invoice->date_exit }}</p>
                            <p class="text-muted">Nom controleur sortie : {{ $invoice->name_controleur_ouput }} </p>

                            @if ($invoice->seen_entry_control === null)
                                <button data-bs-dismiss="modal" class="main-btn active-btn-outline rounded-md btn-hover"
                                    wire:click="storeEntry">Vu entrée
                                </button>
                            @endif
                            @if ($invoice->seen_entry_control != null)
                                <button data-bs-dismiss="modal" class="main-btn active-btn-outline rounded-md btn-hover"
                                    wire:click="storeExit">Vu sortie
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
