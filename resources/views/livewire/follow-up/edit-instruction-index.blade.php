<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <form wire:submit.prevent="update">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Jenis Instruksi Kerja <span class="text-red">*</span></label>
                    <div class="row">
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type" class="custom-switch-input @error('spk_type') is-invalid @enderror" value="layout" {{ $instructions->type_order == 'layout' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Layout</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type" class="custom-switch-input @error('spk_type') is-invalid @enderror" value="sample" {{ $instructions->type_order == 'sample' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Sample</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type" class="custom-switch-input @error('spk_type') is-invalid @enderror" value="production" {{ $instructions->type_order == 'production' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Production</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type" class="custom-switch-input @error('spk_type') is-invalid @enderror" value="stock" {{ $instructions->type_order == 'stock' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Stock</span>
                            </label>
                        </div>
                        @error('spk_type') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
    </form>
</div>
