<div>
    {{-- In work, do what you enjoy. --}}
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Customer</label>
                    <div class="input-group">
                        <input type="text" wire:model="name" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" placeholder="Nama Customer">
                    </div>
                    @error('name') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Taxes Type <span class="text-red">*</span></label>
                    <div class="row">
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="taxes" class="custom-switch-input @error('taxes') is-invalid @enderror" value="pajak">
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Pajak</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="taxes" class="custom-switch-input @error('taxes') is-invalid @enderror" value="nonpajak">
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Non Pajak</span>
                            </label>
                        </div>
                        @error('taxes') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
    </form>
</div>