@extends('layouts.app')

@section('content')
    <div class="card-style mb-30">
        <div class="table-wrapper table-responsive">
            <button type="button" id="export_button" class="btn btn-success btn-sm">Exporter</button>
            <table id="employee_data" class="table striped-table">
                <thead>
                <tr>
                    <th>
                        <h6>Partenaires</h6>
                    </th>
                    <th>
                        <h6>Vehicule</h6>
                    </th>
                    <th>
                        <h6>Remorque</h6>
                    </th>
                    <th>
                        <h6>N° Conteneur</h6>
                    </th>
                    <th>
                        <h6>N° Plomb</h6>
                    </th>
                    <th>
                        <h6>Chargeur</h6>
                    </th>
                    <th>
                        <h6>Produit</h6>
                    </th>
                    <th>
                        <h6>Chef de Guerite</h6>
                    </th>
                    <th>
                        <h6>Guerite entrée</h6>
                    </th>
                    <th>
                        <h6>Statut de la pesée</h6>
                    </th>
                    <th>
                        <h6>Pesée d'entrée</h6>
                    </th>
                    <th>
                        <h6>Date</h6>
                    </th>
                    <th>
                        <h6>Heure</h6>
                    </th>
                </tr>
                <!-- end table row-->
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>
                                <p>{{ $invoice->customer->label }} </p>
                            </td>
                            <td>
                                <p>{{ optional($invoice->myTractor)->label }} </p>
                            </td>
                            <td>
                                <p>{{ optional($invoice->myTrailer)->label }} </p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <p>{{ $invoice->user->name }} </p>
                            </td>
                            <td>
                                <p>{{ $invoice->weighbridge->label }} </p>
                            </td>
                            <td></td> {{-- statut de la pesée  --}}
                            <td>OUI</td> {{-- pesee entree  --}}
                            <td>
                                <p>{{ $invoice->created_at->format('d/m/y') }} </p>
                            </td>
                            <td>
                                <p>{{ $invoice->created_at->format('H:i:s') }} </p>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <!-- end table -->
        </div>
    </div>

@stop
@push('scripts')

    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <script>

        function html_table_to_excel(type)
        {
            var data = document.getElementById('employee_data');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet"});

            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

            XLSX.writeFile(file, 'export.' + type);
        }

        const export_button = document.getElementById('export_button');

        export_button.addEventListener('click', () =>  {
            html_table_to_excel('xlsx');
        });
    </script>
@endpush
