@extends('layouts.app')

@section('content')
<div class="tables-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-style mb-30">
            <small class=" text-black" >facture annulée en rouge</small>f
          <div
            class="d-flex flex-wrap justify-content-between align-items-center py-3">
            <div class="left">
              <p>Afficher <span>10</span> factures</p>
            </div>
            <div class="right">
              <div class="table-search d-flex">
                <form action="#">
                  <input type="text" placeholder="Entrer le n° facture"/>
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
                    @if($invoice->status_invoice =='cancelling')
                        <tr  class="table-danger">
                            <td>
                                <p>{{$invoice->invoice_no}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->myTractor->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->myTrailer->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->modePayment->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->weighbridge->label}}</p>
                            </td>
                            <td>
                            <div class="action justify-content-end">
                                <div class="action">
                                    <a class="text-primary" target="_blank" href="{{route('show-pdf',$invoice->id)}}">
                                        <i class="lni lni-printer"></i>
                                    </a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                <p>{{$invoice->invoice_no}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->myTractor->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->myTrailer->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->modePayment->label}}</p>
                            </td>
                            <td>
                                <p>{{$invoice->weighbridge->label}}</p>
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
                                        aria-labelledby="moreAction1"
                                    >
                                        <li class="dropdown-item">
                                            <a style="color:grey" class="link-primary" target="_blank"
                                               href="{{route('show-pdf',$invoice->id)}}">Imprimer la facture</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a href="javascript:void(0)"
                                               wire:click="getInvoice({{$invoice->id}})"
                                               data-bs-toggle="modal" data-bs-target="#ModalTree"
                                               class="text-gray">Annuler la facture</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endif

                @empty

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
            <div class="" >
              {{$invoices->links()}}
            </div>
        </div>
        </div>
        <!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</div>
@stop
