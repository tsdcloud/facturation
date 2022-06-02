@extends('layouts.app')

@section('content')
 <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Nombre total de factures/jour</h6>
                            <h6 class="text-bold mb-10"> 0 </h6>
                    </div>
                </div>
                <!-- End Icon Cart -->
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="icon-card mb-30">
                    <div class="content">
                        <h6 class="mb-10">Encaissement</h6>
                        <h6 class="text-bold mb-10">0 FCFA</h6>
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
            {{-- <div class="col-xl-3 col-lg-4 col-sm-6">
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
            </div> --}}
        </div>
 {!! QrCode::size(100)->generate(Request::url())!!}
{{-- {{QrCode::format('png')->size(120)->generate('https://postsrc.com')}}--}}
@stop
