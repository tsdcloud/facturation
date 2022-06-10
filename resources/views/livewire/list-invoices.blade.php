<div>
    <div class="tables-wrapper">
        <div class="row">
          <div class="col-lg-12">
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
                        <th class="lead-company"><h6>Mode paiement</h6></th>
                        <th class="lead-company"><h6>Pont bascule</h6></th>
                        <th><h6>Actions</h6></th>
                    </tr>
                    <!-- end table row-->
                  </thead>
                  <tbody>
                    @forelse ($invoices as $invoice)
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
                             <a style="color:grey" class="link-primary" target="_blank" href="{{route('show-pdf',$invoice->id)}}">Imprimer la facture</a>
                            </li>
                            <li class="dropdown-item">
                              <a href="javascript:void(0)" wire:click="getInvoice({{$invoice->id}})"
                                data-bs-toggle="modal" data-bs-target="#ModalTree" class="text-gray">Annuler la facture</a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
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

{{-- modale d'annulation d'une facture --}}
<div class="warning-modal">
  <div  wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="ModalTree" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content card-style warning-card text-center">
              <div class="modal-header px-0 border-0 d-flex justify-content-end ">
                  <button class="border-0 bg-transparent h1" data-bs-dismiss="modal">
                      <i class="lni lni-cross-circle"></i>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="icon text-danger mb-20">
                      <i class="lni lni-warning"></i>
                  </div>
                  <div class="content mb-30">
                      <h2 class="mb-15">Attentions !</h2>
                      <p class="text-sm text-medium">
                          Vous êtes sur le point d'annuler cette facture
                          ok
                      </p>
                     {{-- @isset($data)
                       <p>ok</p>
                       {{-- <p>Facture N°  {{$data->id}}</p> 
                     @endisset --}}
                      {{-- <p>Facture N°  {{$data}}</p> --}}

                      {{-- @empty(!$data)
                        <p>Facture N°  {{$data['invoice_no'] }}</p> 
                        {{-- <p>Nom Client {{$data->customer->label}}</p>
                        <p>N° Tracteur {{$data->myTractor->label}}</p>
                        <p>N° Remorque {{$data->myTrailer->label}}</p>
                        <p> Crée par {{$data->user->name}}</p> 
                      @endempty --}}
                  </div>
                  <div class="action d-flex flex-wrap justify-content-center">
                      <button data-bs-dismiss="modal" class="main-btn danger-btn btn-hover m-1"
                      > Supprimer
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</div>
@push('scripts')
    <script>
        document.addEventListener('closeAlert', closeAlert);
        function closeAlert(){
            setTimeout(()=>{
                let alertNode = document.querySelector('#alert-message');
                let alert = new bootstrap.Alert(alertNode);
                alert.close()
            },3000)
        }
    </script>
@endpush