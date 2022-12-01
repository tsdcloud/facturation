@extends('layouts.app')

@section('content')
<div class="form-elements-wrapper">
    <div class="card-style">
        <div class="row">
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Opérateur de pesée 1</label>
                    <input class="form-control" value="{{$report->operator_name_one}}" readonly type="text" />
                </div>

            </div>
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Opérateur de pesée 2</label>
                    <input class="form-control" value="{{$report->operator_name_two}}" readonly type="text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Nom HSE 1</label>
                    <input class="form-control" value="{{$report->name_hse_1}}" readonly type="text" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Nom HSE 2</label>
                    <input class="form-control" value="{{$report->name_hse_2}}" readonly type="text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Commentaire incident</label>
                    <input class="form-control" value="{{$report->incidental_comment}}" readonly type="text" />
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-style-1">
                    <label>Commentaire Discipline</label>
                    <input class="form-control" value="{{$report->disciplinary_comment}}" readonly type="text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="input-style-1">
                    <label>Commentaire production</label>
                    <input class="form-control" value="{{$report->production_comment}}" readonly type="text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="input-style-1">
                    <label>Nombre de factures cash</label>
                    <input class="form-control" value="{{$report->number_cash_invoices}}" readonly type="text"/>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="input-style-1">
                    <label>Montant total à verser</label>
                    <input class="form-control" value="{{$report->amount_pay}}" readonly type="text" />
                </div>
            </div>
            <div class="col-lg-4">
                <div class="input-style-1">
                    <label>Nombre de factures à facturer</label>
                    <input class="form-control" value="{{$report->number_invoice_to_be_billed}}" readonly type="text" />
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card-style">
                <h6 class="mb-25"> Pesées complètes</h6>
                <div class="input-style-1">
                    <label>Total pesée complète</label>
                    <input class="form-control" value="{{$report->total_complete_weighing}}" readonly type="text" />
                </div>
                <div class="input-style-1">
                    <label>Nombre de pesées complètes payés cash</label>
                    <input class="form-control" value="{{$report->total_complete_weighing_cash}}" readonly type="text" />
                </div>
                <div class="input-style-1">
                    <label>Nombre de pesées complètes à facturer (non payés)</label>
                    <input class="form-control" value="{{$report->total_complete_weighing_invoiced}}" readonly type="text" />
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-style">
                <h6 class="mb-25"> Pesées incomplètes</h6>
                <div class="input-style-1">
                    <label>Total pesée incomplète</label>
                    <input class="form-control" value="{{$report->total_incomplete_weighing}}" readonly type="text" />
                </div>
                <div class="input-style-1">
                    <label>Nombre de pesées incomplètes payés cash</label>
                    <input class="form-control" value="{{$report->total_incomplete_weighing_cash}}" readonly type="text" />
                </div>
                <div class="input-style-1">
                    <label>Nombre de pesées incomplètes à facturer (non payés)</label>
                    <input class="form-control" value="{{$report->total_incomplete_weighing_invoiced}}" readonly type="text" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card-style">
            <div class="row">
                <div class="col-lg-4">
                    <div class="input-style-1">
                        <label>Nombre total de pesées type 1</label>
                        <input class="form-control" value="{{$report->total_number_type_1_weighings}}" readonly type="text" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-style-1">
                        <label>Nombre total de pesées type 2</label>
                        <input class="form-control" value="{{$report->total_number_type_2_weighings}}" readonly type="text" />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-style-1">
                        <label>Nombre total de pesées</label>
                        <input class="form-control" value="{{$report->total_number_weighings}}" readonly type="text" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="card-style">
            <h6 class="mb-25"> Pièce jointe email</h6>
            <div class="row">
                @foreach ($report->attachments as $attachment)
                    <div class="col-lg-4">
                        <label>{{$attachment->name}}</label>
                        <a href="javascript:void(0)" download="{{asset('storage/'.$attachment->path)}}">
                             Télécharger
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12">
            @foreach ($report->images as $image )

            <div class="card mt-3" style="width: 73rem;">
                <img src="{{asset('storage/'.$image->path)}}" alt="">
              </div>
            @endforeach
            {{-- <div class="card-style">
                <x-forms.filepond wire:model="images" acceptedFileTypes="['image/*']" multiple />
            </div> --}}
        </div>
    </div>
</div>
@stop