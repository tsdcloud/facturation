@extends('layouts.app')

@section('content')
 <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Nombre facture / jour</h6>
                            <h6 class="text-bold mb-10"> 0 </h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Encaissement</h6>
                        <h6 class="text-bold mb-10">{{\App\Helpers\Numbers\MoneyHelper::price($total_amount_month)}}</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Cash à rembourser</h6>
                        <h6 class="text-bold mb-10"> 0 FCFA</h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Factures annulées</h6>
                        <h6 class="text-bold mb-10"> 0 </h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
        </div>

    <div class="row">
      <livewire:dashboard.dashboard/>
    </div>


@stop

@push('scripts')

@endpush
