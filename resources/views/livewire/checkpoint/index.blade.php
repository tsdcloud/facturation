<div>
    <div class="col-md-6 col-sm-12 col-lg-12">
        <div class="card-style">
            <h6 class="mb-25">Rechercher le camion</h6>
            <div class="row">
                <div class="input-style-1">
                    <input type="text" placeholder="Rechercher le tracteur..." wire:model.debounce.500ms="search"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-12 mt-2">
            @foreach ($invoices as $invoice )
                <div class="card-style mb-3">
                    <p class="text-muted">Nom client : {{$invoice->customer->label}} </p>
                    <p class="text-muted">Tracteur : {{$invoice->myTractor->label}}</p>
                    <p class="text-muted">Remorque : {{optional($invoice->myTrailer)->label}}</p>
                    <a href="{{route('checkpoint.detail',$invoice)}}" class="stretched-link"></a>
                </div>
            @endforeach
        </div>
    </div>
</div>
