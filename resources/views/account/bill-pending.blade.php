@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card-style mb-30">
            <h6 class="mb-10"></h6>
            <div class="table-wrapper table-responsive">
                <table class="table striped-table">
                    <thead>
                    <tr>
                        <th> <h6>Reçu de</h6> </th>
                        <th><h6>Facture N°</h6></th>
                        <th><h6>Tracteur N°</h6></th>
                        <th><h6>Mode Paiement</h6></th>
                        <th><h6>Montant</h6></th>
                        <th><h6>statut</h6></th>
                        <th><h6>Actions</h6></th>
                    </tr>
                    <!-- end table row-->
                    </thead>
                    <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>
                                <p>Oumarou</p>
                            </td>
                            <td>
                                <h6 class="text-sm">001</h6>
                            </td>
                            <td>
                                <p>LTTR785OP </p>
                            </td>
                            <td>
                                <p>Espèce</p>
                            </td>
                            <td>
                                <p>11925</p>
                            </td>
                            <td>
                                <p> <span class="status-btn close-btn">En attente</span> </p>
                            </td>
                            <td>
                                <div class="action">
                                    <button class="edit" data-bs-toggle="modal">
                                        Valider /
                                    </button>
                                    <button class="text-danger" data-bs-toggle="modal">
                                        Annuler
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        Pas de facture en attente
                    @endforelse

                    </tbody>
                </table>
                <!-- end table -->
            </div>
        </div>
        <!-- end card -->
    </div>
@stop
