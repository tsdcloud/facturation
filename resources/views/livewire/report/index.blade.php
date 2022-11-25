<div>
    <div>
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    @if (session()->has('message'))
                        <div id="alert-message" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('message') }} </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }} </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-style mb-30">
                        <small class=" text-black">facture annulée en rouge</small>
                        <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                            <div class="left">
    
                                <p>Afficher <span>10</span> rapports</p>
                            </div>
                            <div class="right">
                                <div class="table-search d-flex">
                                    <form action="#">
                                        <input type="text" wire:model.debounce.500ms="search_invoice_no_tractor_trailer"
                                            placeholder="Entrer n° facture ou tracteur" />
                                        <button><i class="lni lni-search-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="lead-info">
                                            <h6>N° facture</h6>
                                        </th>
                                        <th class="lead-info">
                                            <h6>Date</h6>
                                        </th>
                                        <th class="lead-info">
                                            <h6>Statut facture</h6>
                                        </th>
                                        <th class="lead-email">
                                            <h6>N° tracteur</h6>
                                        </th>
                                        <th class="lead-company">
                                            <h6>Mode paiement</h6>
                                        </th>
                                        <th class="lead-phone">
                                            <h6>Type de pesée</h6>
                                        </th>
                                        <th class="lead-company">
                                            <h6>Pont bascule</h6>
                                        </th>
                                        <th>
                                            <h6>Actions</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                </thead>
                                <tbody>
                                    @forelse ($invoices as $invoice)
                                        @if ($invoice->status_invoice == 'cancelling')
                                            <tr class="table-danger">
                                                <td>
                                                    <p>{{ $invoice->invoice_no }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->created_at->format('d/m/y H:i:s') }}</p>
                                                </td>
                                                <td>
                                                    <p>
                                                        <span class="status-btn danger-btn" >annulée</span>
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ optional($invoice->myTractor)->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ optional($invoice->typeWeighing)->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->modePayment->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->weighbridge->label }}</p>
                                                </td>
    
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="lni lni-more-alt"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="moreAction1">
                                                            <li class="dropdown-item">
                                                                <a style="color:grey" class="link-primary" target="_blank"
                                                                    href="{{ route('show-pdf', $invoice->id) }}">Imprimer la
                                                                    facture</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    <p>{{ $invoice->invoice_no }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->created_at->format('d/m/y H:i:s') }}</p>
                                                </td>
                                                <td>
                                                    <p> @if($invoice->status_invoice == 'validated')
                                                            <span class="status-btn success-btn">validée</span>
                                                        @else
                                                            <span class="mdi-priority-high">annulée</span>
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ optional($invoice->myTractor)->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ optional($invoice->typeWeighing)->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->modePayment->label }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ $invoice->weighbridge->label }}</p>
                                                </td>
    
                                                <td>
                                                    
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
                            <div class="">
                                {{ $invoices->links() }}
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
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('closeAlert', closeAlert);
    
        function closeAlert() {
            setTimeout(() => {
                let alertNode = document.querySelector('#alert-message');
                let alert = new bootstrap.Alert(alertNode);
                alert.close()
            }, 5000)
        }
    </script>
    @endpush
    
</div>