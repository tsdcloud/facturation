<div>
    <div class="card-style">
        <div class="col">
            <div class="mb-3">
                <input class="form-control" wire:model="file_excel" type="file" id="formFile">
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
                            @foreach ($predictions[0] as $key => $preview)
                                <th>
                                    {{-- {{dd($preview)}} --}}
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
                            @endforeach
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
            <button wire:click="import" class="btn btn-primary mt-3">Importer</button>
        </div>
    @endif
</div>
