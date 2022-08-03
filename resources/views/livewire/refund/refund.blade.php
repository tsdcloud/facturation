<div>
    @php
        $i = 1
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="tab-style-1">
                <nav class="nav " id="nav-tab">
                    <button wire:ignore class="active" id="tab-1-1" data-bs-toggle="tab" data-bs-target="#tabContent-1-1">
                        En attente
                    </button>
                    <button wire:ignore id="tab-1-2" data-bs-toggle="tab" data-bs-target="#tabContent-1-2">
                        Remboursé
                    </button>
                </nav>
                <div class="tab-content" id="nav-tabContent1">
                    <div class="tab-pane fade show active" wire:ignore.self id="tabContent-1-1">
                        <div class="card-style mb-30">
                            <div class="table-wrapper table-responsive">
                                {{-- <h6> Montant Total : {{ \App\Helpers\Numbers\MoneyHelper::price($total_amount) }}</h6>
                                <small> Nombre de facture : {{ $number_invoice }} </small> --}}
                                <table class="table striped-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>
                                            <h6>N° Facture</h6>
                                        </th>
                                        <th>
                                            <h6>Date</h6>
                                        </th>
                                        <th>
                                            <h6>Montant versé</h6>
                                        </th>
                                        <th>
                                            <h6>A rembourser</h6>
                                        </th>
                                        <th>
                                            <h6>Nom client</h6>
                                        </th>
                                        <th>
                                            <h6>Tracteur</h6>
                                        </th>
                                        <th>
                                            <h6>Remorque</h6>
                                        </th>
                                        <th>
                                            <h6>Pont</h6>
                                        </th>
                                        <th>
                                            <h6>Mode de paiement</h6>
                                        </th>
                                        <th>
                                            <h6>Type de pesée</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                    </thead>
                                    <tbody>

                                    @forelse($refunds as $refund )
                                        <tr>
                                            <td class="text-sm" >
                                                {{$i ++}}
                                            </td>
                                            <td>
                                                <p>{{ $refund->invoice_no }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->created_at->format('d/m/y H:i:s') }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->amount_paid }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->remains }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->customer->name }}</p>
                                            </td>
                                            <td>
                                                <p>{{ optional($refund->myTractor)->label }}</p>
                                            </td>
                                            <td>
                                                <p>{{ optional($refund->myTrailer)->label }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->weighbridge->label }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $refund->modePayment->label }}</p>
                                            </td>
                                            <td>
                                                <p>{{ optional($refund->typeWeighing)->label }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <p>Aucun remboursement pour le moment</p>
                                    @endforelse

                                    </tbody>
                                </table>

                                <!-- end table -->
                            </div>
                            <div class="pt-10 d-flex flex-wrap justify-content-between ">
                                <div class="left">
                                    <p class="text-sm text-gray">
                                </div>
                                <div class="">
                                    {{ $refunds->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $j = 1
                    @endphp
                    <div class="tab-pane fade" id="tabContent-1-2" wire:ignore.self >
                        <div class="card-style mb-30">
                            <h6 class="mb-10">Mes remboursements remboursés </h6>
                            <div class=" d-flex flex-wrap justify-content-between align-items-center py-3" >
                                <div class="left">
                                    <p>Afficher <span>10 ères</span> transactions</p>
                                </div>
                                <div class="right">
                                    <div class="table-search d-flex">
                                        <form action="#">
                                            <input type="text" placeholder="libelle ou numéro" />
                                            <button><i class="lni lni-search-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="lead-info"><h6>N°</h6></th>
                                        <th class="lead-email"><h6>Opération</h6></th>
                                        <th class="lead-phone"><h6>Montant retrait</h6></th>
                                        <th class="lead-company"><h6>Transaction</h6></th>
                                        <th class="lead-company"><h6>Libellé</h6></th>
                                        <th><h6>Action</h6></th>
                                    </tr>
                                    <!-- end table row-->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{$j++}}
                                            </td>
                                            <td>
                                                <p>libelle</p>
                                            </td>
                                            <td>
                                                <p>150 000 FCFA</p>
                                            </td>
                                            <td>
                                                <p>transaction</p>
                                            </td>
                                            <td>
                                                <p>retrait</p>
                                            </td>
                                            <td>
                                                <div class="action">
                                                    <button class="text-primary">
                                                        <i class="lni lni-pencil"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                            <tr>

                                            </tr>
                                    </tbody>
                                </table>
                                <!-- end table -->
                            </div>
                            <div class="pt-10 d-flex flex-wrap justify-content-between">
                                <div class="left">
                                    <p class="text-sm text-gray">
                                       </p>
                                </div>
                                <div class="right table-pagination">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
