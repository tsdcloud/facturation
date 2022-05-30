@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card-style mb-30">
            <h6 class="mb-10"></h6>
            <div class="table-wrapper table-responsive">
                <table class="table striped-table">
                    <thead>
                    <tr>
                        <th> <h6>Nom</h6> </th>
                        <th><h6>Rôle</h6></th>
                        <th><h6>Statut</h6></th>
{{--                        <th><h6>Mode Paiement</h6></th>--}}
{{--                        <th><h6>Montant</h6></th>--}}
{{--                        <th><h6>statut</h6></th>--}}
                        <th><h6>Actions</h6></th>
                    </tr>
                    <!-- end table row-->
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <p>{{$user->name}}</p>
                            </td>
                            <td>
                                <h6 class="text-sm">{{$user->role}}</h6>
                            </td>
                            <td>
                                <p> <span class="status-btn success-btn">{{$user->status}}</span> </p>
                            </td>
                            <td>
                                <div class="action">
                                    <button class="edit" data-bs-toggle="modal">
                                        <i class="lni lni-pencil"></i>
                                    </button>
{{--                                    <button class="text-danger" data-bs-toggle="modal">--}}
{{--                                         Annuler--}}
{{--                                    </button>--}}
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
