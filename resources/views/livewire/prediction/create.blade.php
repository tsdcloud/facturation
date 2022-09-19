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
        <button wire:click="preview" class="btn btn-primary">Précharger</button>
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
    @endif
</div>
@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
