<div
    wire:ignore
    x-data
    x-init="() => {
        const post = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});
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
            allowImagePreview: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
            imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
            allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
            acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
            allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
            maxFileSize: {!! $attributes->has('maxFileSize') ? "'".$attributes->get('maxFileSize')."'" : 'null' !!}
        });
        this.addEventListener('pondReset', e => {
            post.removeFiles();
        });
    }"
>
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>

@push('styles')
    @once
        <link href="{{ asset('assets/plugins/filepond/unpkg.com_filepond@4.30.4_dist_filepond.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/filepond/unpkg.com_filepond-plugin-image-preview@4.6.11_dist_filepond-plugin-image-preview.css') }}" rel="stylesheet">
    @endonce
@endpush

@push('scripts')
    @once
        <script src="{{ asset('assets/plugins/filepond/unpkg.com_filepond-plugin-file-validate-type@1.2.8_dist_filepond-plugin-file-validate-type.js') }}"></script>
        <script src="{{ asset('assets/plugins/filepond/unpkg.com_filepond-plugin-file-validate-size@2.2.8_dist_filepond-plugin-file-validate-size.js') }}"></script>
        <script src="{{ asset('assets/plugins/filepond/unpkg.com_filepond-plugin-image-preview@4.6.11_dist_filepond-plugin-image-preview.js') }}"></script>
        <script src="{{ asset('assets/plugins/filepond/unpkg.com_filepond@4.30.4_dist_filepond.js') }}"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);
        </script>
    @endonce
@endpush
