<div>
    <!-- End Row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="select-style-1">
                <label>Selectionner le chef de Guerite</label>
                <div class="select-position">
                    <select wire:model="user_id" >
                        <option selected value="" Selectionner le chef de Geurite>...</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-style-1">
                <label>Périodicité du :</label>
                <input wire:model="startDate" type="date" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="input-style-1">
                <label>Au:</label>
                <input type="date" wire:model="endDate" />
            </div>
        </div>
        <div class="col-lg-2 mb-2 justify-content-end">
            <button wire:click="search" class="main-btn active-btn-outline rounded-md btn-hover" type="submit">Filtrer</button>
        </div>
        <div class="col-lg-2 mb-2 justify-content-end">
            <button class="main-btn dark-btn-outline rounded-md btn-hover" type="submit">Rénitialiser le filtre</button>
        </div>
    </div>

    @php
        $i = 1
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <div class="table-wrapper table-responsive">
                    <h6>   Montant Total : {{\App\Helpers\Numbers\MoneyHelper::price($total_amount) }}</h6>
                    <small>   Nombre de facture : {{$number_invoice}} </small>
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>
                                <h6>N° Facture</h6>
                            </th>
                            <th>
                                <h6>Emise par</h6>
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
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>

                        @empty(!$invoices)

                            @foreach($invoices as $invoice)

                                <tr>
                                    <td>
                                        <h6 class="text-sm">{{$i ++}}</h6>
                                    </td>
                                    <td>
                                        <p>{{$invoice->invoice_no}} </p>
                                    </td>

                                    <td>
                                        <p>{{$invoice->user->name}}</p>
                                    </td>
                                    <td>
                                        @if($invoice->status_invoice == "validated")
                                            <p>Valide</p>
                                        @else
                                            <p>Annulé</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p>{{$invoice->customer->label}}</p>
                                    </td>
                                    <td>
                                        <p>{{$invoice->myTractor->label}}</p>
                                    </td>
                                    <td>
                                        <p>{{$invoice->myTrailer->label}}</p>
                                    </td>
                                    <td>
                                        <p>{{$invoice->weighbridge->label}}</p>
                                    </td>
                                    <td>
                                        <p>{{$invoice->modePayment->label}}</p>
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
</div>
