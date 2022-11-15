@push('styles')
<!-- add to document <head> -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />
@endpush
<div>
    <div class="form-elements-wrapper">
        <div class="card-style">
            <div class="row">
                <div class="col-lg-6">
                    <div class="select-style-1">
                        <label>Shift</label>
                        <div class="select-position">
                            <select wire:model.defer="shift" class="form-select " id="basicSelect">
                                <option selected>Selectionner votre shift</option>
                                <option value="06h30-14h30">06h30-14h30</option>
                                <option value="14h30-22h30">14h30-22h30</option>
                                <option value="22h30-06h30"> 22h30-06h30</option>
                            </select>
                        </div>
                      </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-style-1">
                        <label>Nombre d'incidents</label>
                        <input type="number" min="0" wire:model.defer="number_incident" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-style-1">
                        <label>Commentaire incident</label>
                        <textarea wire:model.defer="disciplinary_comment" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-style-1">
                        <label>Commentaire Discipline</label>
                        <textarea wire:model.defer="incidental_comment"  rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-style-1">
                        <label>Commentaire production</label>
                        <textarea wire:model.defer="production_comment" rows="2"></textarea>
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
                        <input type="number" min="0" wire:model.defer="total_complete_weighing" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées complètes payés cash</label>
                        <input type="number" min="0" wire:model.defer="total_complete_weighing_cash" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées complètes prepayées cash</label>
                        <input type="number" min="0" wire:model.defer="total_complete_weighing_prepaid" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées complètes à facturer (non payés)</label>
                        <input type="number" min="0" wire:model.defer="total_complete_weighing_invoiced" />
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-style">
                    <h6 class="mb-25"> Pesées incomplètes</h6>
                    <div class="input-style-1">
                        <label>Total pesée incomplète</label>
                        <input type="number" min="0"  wire:model.defer="total_incomplete_weighing" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées incomplètes payés cash</label>
                        <input type="number" min="0" wire:model.defer="total_incomplete_weighing_cash" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées incomplètes prepayées cash</label>
                        <input type="number" min="0" wire:model.defer="total_incomplete_weighing_prepaid" />
                    </div>
                    <div class="input-style-1">
                        <label>Nombre de pesées incomplètes à facturer (non payés)</label>
                        <input type="number" min="0" wire:model.defer="total_incomplete_weighing_invoiced" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
               <div class="card-style">
                <x-forms.filepond  wire:model="images"  acceptedFileTypes="['image/png', 'image/jpg']" multiple />
                @error('images')
                  <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
               </div>
            </div>
        </div>
        @if (session()->has('success'))
            <div id="alert-message" class="alert alert-success alert-dismissible fade show mt-3"  role="alert"><strong>Enregistré avec succès</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-12 d-flex justify-content-end mt-3">
            <button wire:click="save" class="btn btn-primary me-1 mb-1">Enregistrer</button>
            <button type="reset" class="main-btn danger-btn btn-hover me-1 mb-1">Annuler</button>
        </div>
    </div>
</div>
@push('scripts')
<!-- add before </body> -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    // Register the plugin
    FilePond.registerPlugin(FilePondPluginImagePreview);


    document.addEventListener('filepont',()=>{
        const pond = FilePond.create(
        document.getElementById('pic'));
        pond.removeFiles({ revert: true });
    })

    document.addEventListener('closeAlert',()=>{
        setTimeout(() => {
                let alertNode = document.querySelector('#alert-message');
                let alert = new bootstrap.Alert(alertNode);
                alert.close()
            }, 6000)
    })

</script>

@endpush
