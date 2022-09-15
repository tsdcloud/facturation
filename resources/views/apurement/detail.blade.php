@extends('layouts.app')

@section('content')
    <div class="row">
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }} </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-12 col-sm-12 col-lg-12">
            <a href="{{ route('search.container') }}" class="main-btn primary-btn-outline mb-2">Retour</a>
            <div class="card-style">
                <h6 class="mb-25">Détails</h6>
                <div class="row">
                    <p class="text-muted">Partenaire :  </p>
                    <p class="text-muted">Tracteur : {{ $prediction->tractor }}</p>
                    <p class="text-muted">Remorque : {{ $prediction->trailer }}</p>
                    <p class="text-muted">N° Plomb : {{ $prediction->seal_number }}</p>
                    <p class="text-muted">N° Conteneur : {{ $prediction->container_number }}</p>
                    <p class="text-muted">Chargeur : {{ $prediction->loader }}</p>
                    <p class="text-muted">Produit : {{ $prediction->product }}</p>
                    <p class="text-muted">Pesée entrée : {{ $prediction->weighing_in }}</p>
                    <p class="text-muted">Chef de guerite entrée : {{ $prediction->head_guerite_entry }}</p>
                    <p class="text-muted">Pont entrée : {{ $prediction->guerite_entry }}</p>
                    <p class="text-muted">Date pesée entrée {{ $prediction->date_weighing_entry }}</p>

                    <p class="text-muted">Pesée sortie : {{ $prediction->weighing_out }}</p>
                    <p class="text-muted">Chef de guerite sortie : {{$prediction->head_geurite_output }}</p>
                    <p class="text-muted">Pont sortie : {{ $prediction->geurite_output }}</p>
                    <p class="text-muted">Date pesée sortie {{ $prediction->date_weighing_output }}</p>
                </div>
                @if ($prediction->weighing_in === null)
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <a class="main-btn active-btn-outline rounded-md btn-hover"
                            href="{{ route('apure.entry', $prediction) }}"> Apuré en Entrée
                        </a>
                    </div>
                @endif
                @if ($prediction->weighing_out === null && $prediction->weighing_in != null)
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <a class="main-btn active-btn-outline rounded-md btn-hover"
                            href="{{ route('apure.exit', $prediction) }}">Apuré en sortie
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
