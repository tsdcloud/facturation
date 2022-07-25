@push('styles')

    <link href="/assets/css/bootstrap-timepicker.min.css" />
    <link href="/assets/css/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="/assets/css/daterangepicker.css" rel="stylesheet">
@endpush

<div>
    <!-- End Row -->
{{--    <div class="row">--}}
{{--        <small class="text-muted">veuillez </small>--}}
{{--        <div class="col-lg-3">--}}
{{--            <input type="checkbox" id="shift" wire:model="shift_22" >--}}
{{--            <label for="shift">shift de 22H30 06h30</label>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row">
        @if(Auth::user()->isSupport() || Auth::user()->isAccount())
            <div class="form-check checkbox-style mb-20 mr-5">
                <input class="form-check-input" type="checkbox" wire:model="myStates" id="checkbox-1" />
                <label class="form-check-label" for="checkbox-1">
                    Mon état de facture </label>
            </div>
        @endif

        @if(!$myStates)
            @if (Auth::user()->isAdmin() || Auth::user()->isSupport() || Auth::user()->isAccount() || Auth::user()->isAdministration())
                <div class="col-lg-4">
                    <div class="select-style-1">
                        <label>Selectionner le chef de Guerite</label>
                        <div class="select-position">
                            <select wire:model="user_id">
                                <option selected value="" Selectionner le chef de Geurite>...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        @else
        @endif
        <div class="col-lg-4">
            <div class="input-style-1">
                @if (Auth::user()->isChefGuerite())
                    <label>Périodicité du shift :</label>
                @else
                    <label>Périodicité du :</label>
                @endif
                <input wire:model="startDate" type="date" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-style-1">
                <label>Au:</label>
                <input type="date" wire:model="endDate" />
            </div>
        </div>
        @if($shift_22)
            <div class="col-lg-2">
                <div class="input-style-1">
                    <label>De:</label>
                    <input type="time" wire:model="startHour" />
                </div>
            </div>
            <div class="col-lg-2">
                <div class="input-style-1">
                    <label>A:</label>
                    <input type="time" wire:model="endHour" />
                </div>
            </div>
        @endif
        @if (Auth::user()->isChefGuerite())
            <div class="col-lg-2 mb-2">
                <button wire:click="searchCG" style="margin-top: 1.8rem!important;"
                    class="main-btn active-btn-outline rounded-md btn-hover" type="submit">Filtrer</button>
            </div>
        @endif
            @if(!$myStates)

                @if (Auth::user()->isAdmin() || Auth::user()->isSupport() || Auth::user()->isAccount() || Auth::user()->isAdministration())
                    <div class="col-lg-2 mb-2">
                        <button wire:click="search" style="margin-top: 1.8rem!important;"
                                class="main-btn active-btn-outline rounded-md btn-hover" type="submit">Filtrer</button>
                    </div>
                @endif
             @else
                <div class="col-lg-2 ">
                    <button wire:click="searchCG" style="margin-top: 1.8rem!important;"
                            class="main-btn active-btn-outline rounded-md btn-hover" type="submit">Filtrer</button>
                </div>
            @endif
        {{-- <div class="col-lg-2 justify-content-end mb-2">
            <button style="margin-top: 1.8rem!important;" class="main-btn dark-btn-outline rounded-md btn-hover"
                wire:click="exportCG">Exporter</button>
        </div> --}}
    </div>

    @php
        $i = 1;
    @endphp

    @if (Auth::user()->isAdmin() || Auth::user()->isSupport() || Auth::user()->isAccount() || Auth::user()->isAdministration())
        <div class="row">
            <div class="col-lg-12">
                @isset($invoices)
                <div class="row mt-4">

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Nombre de facture</label>
                            <span class="text-bold mb-10">{{ $number_invoice }} </span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Espèce</label>
                                <span class="text-bold mb-10">({{$numberCashMoney}})
                                    {{\App\Helpers\Numbers\MoneyHelper::number($cashMoney) }} </span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Paiement mobile</label>
                            <span class="text-bold mb-10">({{$numberMobileMoney}})
                                {{ \App\Helpers\Numbers\MoneyHelper::number($mobileMoney )    }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Facture annulée</label>
                            <span class="text-bold mb-10">({{ $cancelledInvoice }})
                                 {{ \App\Helpers\Numbers\MoneyHelper::number($amountCancelledInvoice ) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Remboursé</label>
                            <span class="text-bold mb-10">({{$numberRemains}})
                                {{  \App\Helpers\Numbers\MoneyHelper::number($payback) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Montant total</label>
                            <span class="text-bold mb-10">{{
                            \App\Helpers\Numbers\MoneyHelper::price($total_amount)}}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Montant net</label>
                            <span class="text-bold mb-10">{{
                            \App\Helpers\Numbers\MoneyHelper::price($totalValue)}}</span>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Montant net = (total espèce + total paiement mobile) - (facture annulées + remboursement)</small>
            @endisset
                <div class="card-style mb-30">
                    <div class="table-wrapper table-responsive">
                        {{-- <h6> Montant Total : {{ \App\Helpers\Numbers\MoneyHelper::price($total_amount) }}</h6>
                        <small> Nombre de facture : {{ $number_invoice }} </small> --}}
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <h6>N° Facture</h6>
                                    </th>
                                    <th>
                                        <h6>Date</h6>
                                    </th>
                                    <th>
                                        <h6>Facturé par</h6>
                                    </th>
                                    <th>
                                        <h6>Statut facture</h6>
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
                                        <h6>Mode de paiment</h6>
                                    </th>
                                    <th>
                                        <h6>Type de pesée</h6>
                                    </th>
                                    <th>
                                        <h6>Montant</h6>
                                    </th>
                                </tr>
                                <!-- end table row-->
                            </thead>
                            <tbody>

                            @empty(!$invoices)
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <h6 class="text-sm">{{ $i++ }}</h6>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->invoice_no }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->created_at->format('d/m/y H:i:s') }} </p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->user->name }}</p>
                                        </td>
                                        <td>
                                            @if ($invoice->status_invoice == 'validated')
                                                <p>Validée</p>
                                            @else
                                                <p>Annulée</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p>{{ $invoice->customer->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ optional($invoice->myTractor)->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ optional($invoice->myTrailer)->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->weighbridge->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->modePayment->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->typeWeighing->label }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $invoice->total_amount }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            @endempty


                        </tbody>
                    </table>

                    <!-- end table -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
@endif

{{-- interface pour les CG --}}

@if (Auth::user()->isChefGuerite())
    <div class="row">
        <div class="col-lg-12">
            @isset($invoices)
                <div class="row">

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Nombre de facture</label>
                            <span class="text-bold mb-10">{{ $number_invoice }} </span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Espèce</label>
                                <span class="text-bold mb-10">({{$numberCashMoney}})
                                    {{\App\Helpers\Numbers\MoneyHelper::number($cashMoney) }} </span>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Paiement mobile</label>
                            <span class="text-bold mb-10">({{$numberMobileMoney}})
                                {{ \App\Helpers\Numbers\MoneyHelper::number($mobileMoney )    }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Facture annulée</label>
                            <span class="text-bold mb-10">({{ $cancelledInvoice }})
                                 {{ \App\Helpers\Numbers\MoneyHelper::number($amountCancelledInvoice ) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Remboursé</label>
                            <span class="text-bold mb-10">({{$numberRemains}})
                                {{  \App\Helpers\Numbers\MoneyHelper::number($payback) }}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Montant total</label>
                            <span class="text-bold mb-10">{{
                            \App\Helpers\Numbers\MoneyHelper::price($total_amount)}}</span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="select-style-1 text-center">
                            <label>Montant net</label>
                            <span class="text-bold mb-10">{{
                            \App\Helpers\Numbers\MoneyHelper::price($totalValue)}}</span>
                        </div>
                    </div>
                </div>
                <small class="text-muted">Montant net = (total espèce + total paiement mobile) - (facture annulées + remboursement)</small>
            @endisset
            {{-- fin statistique --}}
            <div class="card-style mb-30">
                <div class="table-wrapper table-responsive">
                    {{-- <h6> Montant Total : {{ \App\Helpers\Numbers\MoneyHelper::price($total_amount) }}</h6> --}}
                    <table class="table striped-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h6>N° Facture</h6>
                                </th>
                                <th>
                                    <h6>Tracteur</h6>
                                </th>
                                <th>
                                    <h6>Statut facture</h6>
                                </th>
                                <th>
                                    <h6>Mode de paiement</h6>
                                </th>
                                <th>
                                    <h6>Montant TTC</h6>
                                </th>
                                <th>
                                    <h6>Pont</h6>
                                </th>
                                <th>
                                    <h6>Date</h6>
                                </th>
                                {{-- <th> --}}
                                {{-- <h6>Remorque</h6> --}}
                                {{-- </th> --}}
                                {{-- <th> --}}
                                {{-- <h6>Mode de paiment</h6> --}}
                                {{-- </th> --}}
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody>

                        @empty(!$invoices)
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>
                                        <h6 class="text-sm">{{ $i++ }}</h6>
                                    </td>
                                    <td>
                                        <p>{{ $invoice->invoice_no }} </p>
                                    </td>

                                    <td>
                                        <p>{{ optional($invoice->myTractor)->label }}</p>
                                    </td>
                                    <td>
                                        @if ($invoice->status_invoice == 'validated')
                                            <p>Validée</p>
                                        @else
                                            <p>Annulée</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{ $invoice->modePayment->label }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $invoice->total_amount }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $invoice->weighbridge->label }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $invoice->created_at->format('d/m/y H:i:s') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        @endempty


                    </tbody>
                </table>

                <!-- end table -->
            </div>
        </div>
        <!-- end card -->
    </div>
</div>
@endif
</div>
@push('scripts')
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/bootstrap-timepicker.js"></script>
    <script src="/assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/bootstrap-clockpicker.min.js"></script>
    <script src="/assets/js/daterangepicker.js"></script>
    <script src="/assets/js/jquery.form-pickers.init.js"></script>

@endpush
