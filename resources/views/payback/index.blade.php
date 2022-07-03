@extends('layouts.app')

@section('content')
    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                @if(session()->has('succès'))
                    <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('succès')}} </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{session('error')}} </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-style mb-30">
                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="left">

                            <p>Afficher <span>10</span> factures</p>
                        </div>
                        <div class="right">
                            <div class="table-search d-flex">
                                <form action="#">
                                    <input type="text" wire:model.debounce.500ms="search_invoice_no_tractor_trailer" placeholder="Entrer le n° facture"/>
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
                                <th class="lead-company"><h6>Pont bascule</h6></th>
                                <th class="lead-company"><h6>Emise par</h6></th>
                                <th><h6>Actions</h6></th>
                            </tr>
                            <!-- end table row-->
                            </thead>
                            <tbody>
                            @forelse ($refunds as $refund)
                                    <tr>
                                        <td>
                                            <p>{{$refund->invoice_no}}</p>
                                        </td>
                                        <td>
                                            <p>{{$refund->myTractor->label}}</p>
                                        </td>
                                        <td>
                                            <p>{{optional($refund->myTrailer)->label}}</p>
                                        </td>
                                        <td>
                                            <p>{{$refund->weighbridge->label}}</p>
                                        </td>
                                        <td>
                                            <p>{{$refund->user->name}}</p>
                                        </td>

                                        <td>
                                            <div class="action justify-content-end">
                                                <button
                                                    class="more-btn ml-10 dropdown-toggle"
                                                    id="moreAction1"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                >
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul
                                                    class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a href="{{route('payback.edit',$refund->id)}}" class="text-gray">Rembourser</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                            @empty
                            <p>pas d'enregistrement</p>
                            @endforelse
                            <!-- end table row -->
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                    <div class="pt-10 d-flex flex-wrap justify-content-between ">
                        <div class="left">
                            <p class="text-sm text-gray">
                        </div>
                        <div class="">
                            {{$refunds->links()}}
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
@stop
