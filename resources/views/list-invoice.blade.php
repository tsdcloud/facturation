@extends('layouts.app')

@section('content')
    <div class="row">
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
                                    @forelse ($invoices as $invoice)
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
                                                    <a class="link-primary" target="_blank" href="{{route('show-pdf',$invoice->id)}}" >
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
                                    <p class="text-sm text-gray">   {{$invoices->total() > 10 ? 'Afficher 10 /'.$invoices->total() . 'Dépôts' : '' }}  </p>
                                </div>
                                <div class="right table-pagination">
                                    {{$invoices->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@stop
