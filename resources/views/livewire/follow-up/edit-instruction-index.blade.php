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

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">Customer <span class="text-red">*</span></label>
                            <select class="form-control" data-clear data-pharaonic="select2" data-component-id="{{ $this->id }}" data-placeholder="Select Customer" name="customer" wire:model="customer" id="customer">
                                <option value="">Select Customer</option>
                                @foreach ($datacustomers as $datacustomer)
                                    <option value="{{ $datacustomer->id }}">{{ $datacustomer->name }} - {{ $datacustomer->taxes }}</option>
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
                                <input type="checkbox" wire:model.defer="sub_spk" class="custom-switch-input @error('sub_spk') is-invalid @enderror" value="sub" {{ $instructions->sub_spk == 'sub' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">Sub</span>
                            </label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div wire:ignore>
                                    <select class="form-control" id="spk_parent" data-clear data-pharaonic="select2" data-component-id="{{ $this->id }}" data-placeholder="Select SPK Parent" wire:model.defer="spk_parent">
                                        <option value="">Select Parent</option>                                        
                                        @foreach($dataparents as $spkparent)
                                            <option value="{{ $spkparent->spk_number }}">[ {{ $spkparent->spk_number }} ] - {{ $spkparent->customer_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('spk_parent') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. SPK <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="spk_number" id="spk_number" class="form-control @error('spk_number') is-invalid @enderror" placeholder="No SPK" readonly>
                        <button class="btn btn-primary" type="button" wire:click="generateCode">Generate</button>
                    </div>
                    @error('spk_number') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">SPK FSC</label>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="custom-switch form-switch me-5">
                                <input type="checkbox" wire:model.defer="spk_fsc" class="custom-switch-input @error('spk_fsc') is-invalid @enderror" value="fsc" {{ $instructions->spk_fsc == 'fsc' ? 'checked' : '' }}>
                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                <span class="custom-switch-description">FSC</span>
                            </label>
                            @error('spk_fsc') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <select wire:model.defer="fsc_type" class="form-control form-select" data-bs-placeholder="Pilih Tipe FSC">
                                    <option label="-- Pilih Tipe FSC --"></option>
                                    <option value="FS">FS</option>
                                    <option value="FM">FM</option>
                                    <option value="FR">FR</option>
                                </select>
                                @error('fsc_type') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. SPK FSC</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="spk_number_fsc" id="spk_number_fsc" class="form-control @error('spk_number_fsc') is-invalid @enderror" placeholder="No SPK FSC" readonly>
                        <button class="btn btn-primary" type="button" wire:click="generateCodeFsc">Generate FSC</button>
                    </div>
                    @error('spk_number_fsc') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
                
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Tanggal Po Masuk <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="date" wire:model.defer="order_date" id="order_date" class="form-control @error('order_date') is-invalid @enderror">
                    </div>
                    @error('order_date') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Tanggal Permintaan Kirim <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="date" wire:model.defer="shipping_date" id="shipping_date" class="form-control @error('shipping_date') is-invalid @enderror">
                    </div>
                    @error('shipping_date') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No. Po Konsumen</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="customer_number" id="customer_number" class="form-control @error('customer_number') is-invalid @enderror" autocomplete="off" placeholder="No. Po Konsumen">
                    </div>
                    @error('customer_number') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Nama Order <span class="text-red">*</span></label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="order_name" id="order_name" class="form-control @error('order_name') is-invalid @enderror" autocomplete="off" placeholder="Nama Order">
                    </div>
                    @error('order_name') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Code Style</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="code_style" id="code_style" class="form-control @error('code_style') is-invalid @enderror" autocomplete="off" placeholder="Code Style">
                    </div>
                    @error('code_style') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" autocomplete="off" placeholder="Quantity" type-currency="IDR">
                    </div>
                    @error('quantity') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Follow Up</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="follow_up" id="follow_up" class="form-control @error('follow_up') is-invalid @enderror" autocomplete="off" placeholder="Follow Up">
                    </div>
                    @error('follow_up') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">Harga</label>
                    <div class="input-group">
                        <input type="text" wire:model.defer="price" id="price" class="form-control @error('price') is-invalid @enderror" autocomplete="off" placeholder="Harga" type-currency="IDR">
                    </div>
                    @error('price') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="form-group">
                    <label class="form-label">PPN</label>
                    <div class="input-group">
                        <select wire:model.defer="type_ppn" id="type_ppn" class="form-control form-select @error('type_ppn') is-invalid @enderror" data-bs-placeholder="Pilih Tipe PPN">
                            <option label="-- Pilih Tipe PPN --"></option>
                            <option value="Include">Include</option>
                            <option value="Exclude">Exclude</option>
                        </select>
                    </div>
                    @error('type_ppn') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">SPK Layout</label>
                            <select class="form-control" data-clear data-pharaonic="select2" data-component-id="{{ $this->id }}" wire:model.defer="spk_layout_number" id="spk_layout_number" data-placeholder="Choose one">
                                <option value="">Choose one</option>
                                @foreach ($datalayouts as $datalayout)
                                    <option value="{{ $datalayout->spk_number }}">{{ $datalayout->spk_number }} - {{ $datalayout->order_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <div wire:ignore>
                        <div class="form-group">
                            <label class="form-label">SPK Sample</label>
                            <select class="form-control" data-clear data-pharaonic="select2" data-component-id="{{ $this->id }}" wire:model.defer="spk_sample_number" id="spk_sample_number" data-placeholder="Choose one">
                                <option value="">Choose one</option>
                                @foreach ($datasamples as $datasample)
                                    <option value="{{ $datasample->spk_number }}">{{ $datasample->spk_number }} - {{ $datasample->order_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <div class="form-group">
                            <label class="form-label mb-3">Langkah Kerja</label>
                            @foreach ($workSteps as $index => $step)
                                <div class="input-group control-group" style="padding-top: 5px;" id="row_remove{{ $index }}">
                                    <input type="text" class="form-control" value="{{ $step['id'] }}" wire:model.defer="workSteps.{{ $index }}.id" style="display: none;">
                                    <input type="text" class="form-control" value="{{ $step['name'] }}">
                                    <button class="btn btn-danger btn_remove" type="button" wire:click="removeField({{ $index }})"><i class="fe fe-x"></i></button>
                                </div>
                            @endforeach
                        </div>
                        @error('workStep') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <label class="form-label mb-3">List Langkah Kerja</label>
                        <div class="form-group">
                            <div class="selectgroup selectgroup-pills">
                                @foreach ($dataworksteplists as $key)
                                    <label class="selectgroup-item">
                                        @if ($key['name'] == 'Cetak Label' || $key['name'] == 'Hot Cutting' || $key['name'] == 'Hot Cutting Folding' || $key['name'] == 'Lipat Perahu' || $key['name'] == 'Lipat Kanan Kiri')
                                            <input type="button" class="btn btn-outline-info add_field" wire:click="addField('{{ $key['name'] }}', '{{ $key['id'] }}')" value="{{ $key['name'] }}">
                                        @else
                                            <input type="button" class="btn btn-outline-primary add_field" wire:click="addField('{{ $key['name'] }}', '{{ $key['id'] }}')" value="{{ $key['name'] }}">
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
    </form>
</div>
