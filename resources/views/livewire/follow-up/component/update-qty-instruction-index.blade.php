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
                                <input type="radio" wire:model="spk_type"
                                    class="custom-switch-input @error('spk_type') is-invalid @enderror" value="layout"
                                    {{ $instructions->type_order == 'layout' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Layout</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type"
                                    class="custom-switch-input @error('spk_type') is-invalid @enderror" value="sample"
                                    {{ $instructions->type_order == 'sample' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Sample</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type"
                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                    value="production" {{ $instructions->type_order == 'production' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Production</span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="custom-switch form-switch me-5">
                                <input type="radio" wire:model="spk_type"
                                    class="custom-switch-input @error('spk_type') is-invalid @enderror" value="stock"
                                    {{ $instructions->type_order == 'stock' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Stock</span>
                            </label>
                        </div>
                        @error('spk_type')
                            <div><span class="text-danger">{{ $message }}</span></div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">Customer <span class="text-red">*</span></label>
                            <select class="form-control" data-clear data-pharaonic="select2"
                                data-component-id="{{ $this->id }}" data-placeholder="Select Customer"
                                name="customer" wire:model="customer" id="customer" disabled>
                                <option value="">Select Customer</option>
                                @foreach ($datacustomers as $datacustomer)
                                    <option value="{{ $datacustomer->id }}">{{ $datacustomer->name }} -
                                        {{ $datacustomer->taxes }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Sub SPK</label>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="custom-switch form-switch me-5">
                                <input type="checkbox" wire:model="sub_spk"
                                    class="custom-switch-input @error('sub_spk') is-invalid @enderror" value="sub"
                                    {{ $instructions->sub_spk == 'sub' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Sub</span>
                            </label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div wire:ignore>
                                    <select class="form-control" id="spk_parent" data-clear data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}" data-placeholder="Select SPK Parent"
                                        wire:model="spk_parent" disabled>
                                        <option value="">Select Parent</option>
                                        @foreach ($dataparents as $spkparent)
                                            <option value="{{ $spkparent->spk_number }}">[
                                                {{ $spkparent->spk_number }} ] - {{ $spkparent->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('spk_parent')
                                <div><span class="text-danger">{{ $message }}</span></div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. SPK <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="text" wire:model="spk_number" id="spk_number"
                            class="form-control @error('spk_number') is-invalid @enderror" placeholder="No SPK"
                            autocomplete="off" disabled>
                    </div>
                    @error('spk_number')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">SPK FSC</label>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="custom-switch form-switch me-5">
                                <input type="checkbox" wire:model="spk_fsc"
                                    class="custom-switch-input @error('spk_fsc') is-invalid @enderror" value="fsc"
                                    {{ $instructions->spk_fsc == 'fsc' ? 'checked' : '' }} disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">FSC</span>
                            </label>
                            @error('spk_fsc')
                                <div><span class="text-danger">{{ $message }}</span></div>
                            @enderror
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <select wire:model="fsc_type" class="form-control form-select"
                                    data-bs-placeholder="Pilih Tipe FSC" disabled>
                                    <option label="-- Pilih Tipe FSC --"></option>
                                    <option value="FS">FS</option>
                                    <option value="FM">FM</option>
                                    <option value="FR">FR</option>
                                </select>
                                @error('fsc_type')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. SPK FSC</label>
                    <div class="input-group">
                        <input type="text" wire:model="spk_number_fsc" id="spk_number_fsc"
                            class="form-control @error('spk_number_fsc') is-invalid @enderror"
                            placeholder="No SPK FSC" autocomplete="off" disabled>
                    </div>
                    @error('spk_number_fsc')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>

            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Tanggal Po Masuk <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="date" wire:model="order_date" id="order_date"
                            class="form-control @error('order_date') is-invalid @enderror" disabled>
                    </div>
                    @error('order_date')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Tanggal Permintaan Kirim <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="date" wire:model="shipping_date" id="shipping_date"
                            class="form-control @error('shipping_date') is-invalid @enderror" disabled>
                    </div>
                    @error('shipping_date')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Tanggal Permintaan Kirim <span
                            class="text-red">*Perubahan</span></label>
                    <div class="input-group">
                        <input type="date" wire:model="shipping_date_change" id="shipping_date_change"
                            class="form-control @error('shipping_date_change') is-invalid @enderror" disabled>
                    </div>
                    @error('shipping_date_change')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">FOC</label>
                            <label class="custom-switch form-switch me-5">
                                <input type="checkbox" wire:model="po_foc"
                                    class="custom-switch-input @error('po_foc') is-invalid @enderror" value="foc" disabled>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">FOC</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="form-label">No. Po Konsumen</label>
                            <div class="input-group">
                                <input type="text" wire:model="customer_number" id="customer_number"
                                    class="form-control @error('customer_number') is-invalid @enderror"
                                    autocomplete="off" placeholder="No. Po Konsumen" disabled>
                            </div>
                            @error('customer_number')
                                <div><span class="text-danger">{{ $message }}</span></div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Order <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="text" wire:model="order_name" id="order_name"
                            class="form-control @error('order_name') is-invalid @enderror" autocomplete="off"
                            placeholder="Nama Order" disabled>
                    </div>
                    @error('order_name')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Code Style</label>
                    <div class="input-group">
                        <input type="text" wire:model="code_style" id="code_style"
                            class="form-control @error('code_style') is-invalid @enderror" autocomplete="off"
                            placeholder="Code Style" disabled>
                    </div>
                    @error('code_style')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <div class="input-group">
                        <input x-data x-mask:dynamic="$money($input)" x-ref="input" type="text"
                            placeholder="Quantity" wire:model="quantity"
                            class="form-control @error('quantity') is-invalid @enderror">
                    </div>
                    @error('quantity')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Follow Up</label>
                    <div class="input-group">
                        <input type="text" wire:model="follow_up" id="follow_up"
                            class="form-control @error('follow_up') is-invalid @enderror" autocomplete="off"
                            placeholder="Follow Up" disabled>
                    </div>
                    @error('follow_up')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input" type="text"
                            placeholder="Harga" wire:model="price"
                            class="form-control @error('price') is-invalid @enderror" disabled>
                    </div>
                    @error('price')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">PPN</label>
                    <div class="input-group">
                        <select wire:model="type_ppn" id="type_ppn"
                            class="form-control form-select @error('type_ppn') is-invalid @enderror"
                            data-bs-placeholder="Pilih Tipe PPN" disabled>
                            <option label="-- Pilih Tipe PPN --"></option>
                            <option value="Include">Include</option>
                            <option value="Exclude">Exclude</option>
                        </select>
                    </div>
                    @error('type_ppn')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">SPK Layout</label>
                            <select class="form-control" data-clear data-pharaonic="select2"
                                data-component-id="{{ $this->id }}" wire:model="spk_layout_number"
                                id="spk_layout_number" data-placeholder="Choose one" disabled>
                                <option value="">Choose one</option>
                                @foreach ($datalayouts as $datalayout)
                                    <option value="{{ $datalayout->spk_number }}">{{ $datalayout->spk_number }} -
                                        {{ $datalayout->order_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">SPK Sample</label>
                            <select class="form-control" data-clear data-pharaonic="select2"
                                data-component-id="{{ $this->id }}" wire:model="spk_sample_number"
                                id="spk_sample_number" data-placeholder="Choose one" disabled>
                                <option value="">Choose one</option>
                                @foreach ($datasamples as $datasample)
                                    <option value="{{ $datasample->spk_number }}">{{ $datasample->spk_number }} -
                                        {{ $datasample->order_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">SPK STK</label>
                            <select class="form-control" data-clear data-pharaonic="select2"
                                data-component-id="{{ $this->id }}" wire:model="spk_stock_number"
                                id="spk_stock_number" data-placeholder="Choose one" disabled>
                                <option value="">Choose one</option>
                                @foreach ($datastocks as $datastock)
                                    <option value="{{ $datastock->spk_number }}">{{ $datastock->spk_number }} -
                                        {{ $datastock->order_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Panjang Barang</label>
                    <div class="input-group">
                        <input type="text" wire:model="panjang_barang" id="panjang_barang"
                            class="form-control @error('panjang_barang') is-invalid @enderror" autocomplete="off"
                            placeholder="Panjang Barang" disabled>
                    </div>
                    @error('panjang_barang')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Lebar Barang</label>
                    <div class="input-group">
                        <input type="text" wire:model="lebar_barang" id="lebar_barang"
                            class="form-control @error('lebar_barang') is-invalid @enderror" autocomplete="off"
                            placeholder="Lebar Barang" disabled>
                    </div>
                    @error('lebar_barang')
                        <div><span class="text-danger">{{ $message }}</span></div>
                    @enderror
                </div>
            </div>

        </div>
        <button type="button" class="btn btn-info mt-4 mb-0" wire:click="sampleRecord">Download Sample
            Record</button>
        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
    </form>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('generated', function(data) {
                document.getElementById('spk_number').value = data.spk_number;
            });
            Livewire.on('generatedfsc', function(data) {
                document.getElementById('spk_number_fsc').value = data.spk_number_fsc;
            });
        });
    </script>
@endpush
