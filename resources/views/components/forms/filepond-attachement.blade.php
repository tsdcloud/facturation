<div>
    <div wire:ignore x-data class="col-lg-12"  
    x-init="() => {
        const post = FilePond.create($refs.input);
        post.setOptions({
            allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                },
            },
        });
    }">
        <div class="input-style-1" >
            <label for="email-id-column">Piece(s) jointe(s) de l'email</label>
            <input id="attachements" type="file" x-ref="input" multiple />
        </div>
    </div>
</div>