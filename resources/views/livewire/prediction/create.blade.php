<div>
    <div class="card-style">
        <div x-data="{ isUpoloading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                     >
            <div class="col">
                <div class="mb-3">
                    <input class="form-control" wire:model="file_excel" type="file" id="formFile">
                </div>
            </div>
            <div  x-show="isUploading" class="progress mb-3">
                <div class="progress-bar progress-bar-striped" role="progressbar" aria-label="Default striped example" x-bind:style="`width:${progress}%`" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        @if (!empty($file_excel))
         <button wire:click="preview" class="btn btn-primary">Afficher le fichier</button>   
        @endif
    </div>

    @if (!empty($predictions))
        <div class="card-style mt-3">
            <div class="table-wrapper table-responsive">
                <table class="table striped-table">
                    <thead>
                        <tr>
                            {{-- @foreach ($predictions[0] as $key => $preview)
                                <th>
                                    <div class="select-style-1">
                                        <div class="select-position">
                                            <select>
                                                @foreach (config('excel_field') as $field)
                                                    <option value="{{ $field }}"
                                                        @if ($key == $field) selected @endif>
                                                        {{ $field }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </th>
                            @endforeach --}}
                            <th>Partenaires</th>
                            <th>Vehicules</th>
                            <th>Remorques</th>
                            <th>N° conteneur</th>
                            <th>N° plomb</th>
                            <th>Chargeur</th>
                            <th>Produit</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($predictions as $row)
                            <tr>
                                @foreach ($row as $key => $value)
                                    <td>
                                        <p>{{ $value }}</p>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button wire:click="import" wire:loading.attr="disabled" class="btn btn-primary mt-3">
                <div class="spinner-border" wire:loading role="status" wire:target="store"></div>
            <div wire:loading.remove  wire:target="store">Importer</div>
            </button>
        </div>

        {{-- éléments existants et nouveau éléments --}}

        {{-- <div class="card-style mt-3">
            <div class="table-wrapper table-responsive">
                <h5>Conteneur déja enregistrés</h5>
                <table class="table striped-table">
                    <thead>
                        <tr>
                            <th>Partenaires</th>
                            <th>Vehicules</th>
                            <th>Remorques</th>
                            <th>N° conteneur</th>
                            <th>N° plomb</th>
                            <th>Chargeur</th>
                            <th>Produit</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                            <th>Opérations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($existingItems as $row)
                            <tr>
                                <td>
                                    <p>{{ $row['partenaire'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['tractor'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['trailer'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['container_number'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['seal_number'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['loader'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['product'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['head_guerite_entry'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['guerite_entry'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['date_weighing_entry'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['weighing_in'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['head_geurite_output'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['geurite_output'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['date_weighing_output'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['weighing_out'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['weighing_status'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['seen_entry_control'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['name_controleur_input'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['date_entry'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['seen_exit_control'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['name_controleur_ouput'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['date_exit'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['weighbridge_entry'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['weighbridge_exit'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['user_id'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['created_at'] }}</p>
                                </td>
                                <td>
                                    <p>{{ $row['updated_at'] }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button wire:click="import" wire:loading.attr="disabled" class="btn btn-primary mt-3">
                <div class="spinner-border" wire:loading role="status" wire:target="store"></div>
            <div wire:loading.remove  wire:target="store">Importer</div>
            </button>
        </div> --}}
        
    @endif
</div>
@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
