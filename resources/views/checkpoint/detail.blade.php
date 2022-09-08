@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <a href="{{route('checkpoint.index')}}" class="main-btn primary-btn-outline mb-2">Retour</a>
            <div class="card-style">
                <h6 class="mb-25">Détails</h6>
                <div class="row">
                    <p class="text-muted">Nom client : {{ optional($invoice->customer)->label }} </p>
                    <p class="text-muted">Tracteur : {{ $invoice->myTractor->label }}</p>
                    <p class="text-muted">Remorque : {{ optional($invoice->myTrailer)->label }}</p>
                    <p class="text-muted">Chef de guerite : {{ $invoice->user->name }}</p>
                    <p class="text-muted">Pont : {{ $invoice->weighbridge->label }}</p>
                    <p class="text-muted">Date facture : {{ $invoice->created_at->format('d/m/Y H:i:s') }}</p>
                    <p class="text-muted">Vu contrôle entrée : {{ $invoice->seen_entry_control }}</p>
                    <p class="text-muted">Date contrôle entrée : {{ $invoice->date_entry }}</p>
                    <p class="text-muted">Nom controleur entrée : {{ $invoice->name_controleur_input }}</p>
                    <p class="text-muted">Vu contrôle sortie : {{ $invoice->seen_exit_control }}</p>
                    <p class="text-muted">Date contrôle sortie : {{ $invoice->date_exit }}</p>
                    <p class="text-muted">Nom controleur sortie : {{ $invoice->name_controleur_ouput }} </p>
                </div>
                @if ($invoice->seen_entry_control === null)
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <a  class="main-btn active-btn-outline rounded-md btn-hover" href="{{route('checkpoint.update',$invoice)}}">Vu entrée
                        </a>
                    </div>
                @endif
                @if ($invoice->seen_exit_control === null && $invoice->seen_entry_control != null)
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <a  class="main-btn active-btn-outline rounded-md btn-hover" href="{{route('checkpoint.update',$invoice)}}">Vu sortie
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop
