<div>
    <div class="card-style mb-30">
        <table class="table striped-table">
            <thead>
            <tr>
                <th>Opérations</th>
                <th>Partenaires</th>
                <th>Vehicules</th>
                <th>Remorques</th>
                <th>N° conteneur</th>
                <th>N° plomb</th>
                <th>Chargeur</th>
                <th>Produit</th>
                <th>Chef de guerite entrée</th>
                <th>Pont entrée</th>
                <th>Date pesée entrée</th>
                <th>Heure pesée entrée</th>
            </tr>
            <!-- end table row-->
            </thead>
            <tbody>

            {{-- @empty(!$paybacks)
                @foreach ($paybacks as $paid_back) --}}
                    <tr>
                        <td>
                            {{-- <p>{{ $paid_back->who_paid_back }} </p> --}}
                        </td>

                        <td>
                            {{-- <p>{{ $paid_back->date_payback }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ $paid_back->invoice_no }} </p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ $paid_back->created_at->format('d/m/y H:i:s') }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ \App\Helpers\Numbers\MoneyHelper::number($paid_back->amount_paid) }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ \App\Helpers\Numbers\MoneyHelper::number($paid_back->remains) }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ $paid_back->customer->label }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ optional($paid_back->myTractor)->label }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ optional($paid_back->myTrailer)->label }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ $paid_back->bridge_that_paid_off }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ $paid_back->modePayment->label }}</p> --}}
                        </td>
                        <td>
                            {{-- <p>{{ optional($paid_back->typeWeighing)->label }}</p> --}}
                        </td>
                    </tr>
                {{-- @endforeach
            @endempty --}}
            </tbody>
        </table>
    </div>
</div>
