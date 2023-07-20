<div>
    {{-- In work, do what you enjoy. --}}
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Request Kekurangan <span class="text-red">*</span></label>
                    <div class="row">
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="requestKekurangan" class="custom-switch-input @error('requestKekurangan') is-invalid @enderror" value="Pemesan">
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Pemesan</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="requestKekurangan" class="custom-switch-input @error('requestKekurangan') is-invalid @enderror" value="QC">
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">QC</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="requestKekurangan" class="custom-switch-input @error('requestKekurangan') is-invalid @enderror" value="Kekurangan Bahan">
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Kekurangan Bahan</span>
                            </label>
                        </div>
                        @error('requestKekurangan') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <div wire:ignore>
                        <label class="form-label">No SPK <span class="text-red">*</span></label>
                        <select class="form-control" data-clear data-pharaonic="select2" data-component-id="{{ $this->id }}" data-placeholder="Select No SPK" wire:model="spkSelected" id="spkSelected">
                            <option value="">Select No SPK</option>
                            @foreach ($dataInstructions as $instruction)
                                <option value="{{ $instruction->id }}">{{ $instruction->spk_number }} - {{ $instruction->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @error('spkSelected') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. SPK Kekurangan<span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="spk_number" id="spk_number" class="form-control @error('spk_number') is-invalid @enderror" placeholder="No SPK" readonly>
                        <button class="btn btn-primary" type="button" wire:click="generateCode">Generate</button>
                    </div>
                    @error('spk_number') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Tanggal Permintaan Kirim <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="date" wire:model.defer="shipping_date" id="shipping_date" class="form-control @error('shipping_date') is-invalid @enderror">
                    </div>
                    @error('shipping_date') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" autocomplete="off" placeholder="Quantity" type-currency="IDR">
                    </div>
                    @error('quantity') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <div class="form-group">
                            <label class="form-label mb-3">Langkah Kerja</label>
                            @if ($spkSelected)
                                @foreach ($workSteps as $index => $step)
                                    <div class="input-group control-group" style="padding-top: 5px;" id="row_remove{{ $index }}">
                                        <input type="text" class="form-control" value="{{ $step['id'] }}" wire:model.defer="workSteps.{{ $index }}.id" style="display: none;">
                                        <input type="text" class="form-control" value="{{ $step['name'] }}" readonly>
                                        {{-- <button class="btn btn-danger btn_remove" type="button" wire:click="removeField({{ $index }})"><i class="fe fe-x"></i></button> --}}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @error('workStep') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                    </div>
                </div>
            </div>

            {{-- <div class="col-sm-6 col-md-6">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <label class="form-label mb-3">List Langkah Kerja</label>
                        <div class="form-group">
                            <div class="selectgroup selectgroup-pills">
                                @foreach ($dataworksteplists as $key)
                                    <label class="selectgroup-item">
                                        @if ($key['name'] == 'Cetak Label' || $key['name'] == 'Hot Cutting' || $key['name'] == 'Hot Cutting Folding' || $key['name'] == 'Lipat Perahu' || $key['name'] == 'Lipat Kanan Kiri')
                                            <input type="button" class="btn btn-outline-info" wire:click="addField('{{ $key['name'] }}', '{{ $key['id'] }}')" value="{{ $key['name'] }}">
                                        @else
                                            <input type="button" class="btn btn-outline-primary" wire:click="addField('{{ $key['name'] }}', '{{ $key['id'] }}')" value="{{ $key['name'] }}">
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}

            <div class="col-sm-6 col-md-6">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <div class="form-group">
                            <label class="form-label mb-3">Catatan</label>
                            <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i class="fe fe-plus"></i>Tambah Catatan</button>
                        </div>

                        @foreach ($notes as $index => $note)
                        <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <div class="input-group control-group" style="padding-top: 5px;">
                                        <select class="form-control form-select" data-bs-placeholder="Pilih Tujuan Catatan" wire:model.defer="notes.{{ $index }}.tujuan" required>
                                            <option label="Pilih Tujuan Catatan"></option>
                                            @foreach ($workSteps as $key)
                                                @if($key['name'] == 'Hitung Bahan')
                                                    <option value="2">Penjadwalan</option>
                                                    <option value="3">RAB</option>
                                                @endif
                                                <option value="{{ $key['id'] }}">{{ $key['name']  }}</option>
                                            @endforeach
                                            
                                        </select>
                                        <button class="btn btn-danger" type="button" wire:click="removeNote({{ $index }})"><i class="fe fe-x"></i></button>
                                    </div>
                                    <div class="input-group control-group" style="padding-top: 5px;">
                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model.defer="notes.{{ $index }}.catatan" required></textarea>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        
        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('generated', function (data) {
                document.getElementById('spk_number').value = data.spk_number;
            });
        });
    </script>
@endpush