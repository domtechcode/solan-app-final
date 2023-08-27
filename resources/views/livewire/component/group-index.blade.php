<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="row">
        <div class="col-lg-6">
            <form wire:submit.prevent="newGroup">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <label class="form-label mb-3">Form Group Baru</label>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        @foreach ($inputsNewGroup as $index => $inputNewGroup)
                                            <div class="row" wire:key="input-field-{{ $index }}">
                                                <!-- Elemen formulir lainnya -->
                                                <div class="col-lg-6 mt-3">
                                                    <div class="input-group control-group">
                                                        <input type="text" id="spk_number_{{ $index }}"
                                                            class="form-control"
                                                            placeholder="{{ $inputNewGroup['spk_number'] }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mt-3">
                                                    <div class="input-group control-group">
                                                        <input type="text" id="group_status_{{ $index }}"
                                                            class="form-control"
                                                            placeholder="{{ $inputNewGroup['type'] }}" readonly>
                                                        <button class="btn btn-danger" type="button"
                                                            wire:click="removeFieldNewGroup({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    </div>
                                                </div>
                                                @error('inputsNewGroup.' . $index . '.id')
                                                    <div><span class="text-danger">{{ $message }}</span></div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-6">
            <form wire:submit.prevent="currentGroup">
                <div class="expanel expanel-default">
                    <div class="expanel-body">
                        <label class="form-label mb-3">Form Menambahkan ke Group sudah ada</label>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div wire:ignore>
                                                        <label class="form-label">Group <span
                                                                class="text-red">*</span></label>
                                                        <select class="form-control" id="groupCurrentIdSelected"
                                                            data-clear data-pharaonic="select2"
                                                            data-component-id="{{ $this->id }}"
                                                            data-placeholder="Select Group"
                                                            wire:model.defer="groupCurrentIdSelected">
                                                            <option label="Select Group"></option>
                                                            @foreach ($groupCurrentId as $groupId)
                                                                <option value="{{ $groupId }}">Group -
                                                                    {{ $groupId }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('groupCurrentIdSelected')
                                                    <div><span class="text-danger">{{ $message }}</span></div>
                                                @enderror
                                            </div>
                                        </div>
                                        @foreach ($inputsCurrentGroup as $key => $inputCurrentGroup)
                                            <div class="row" wire:key="input-field-{{ $key }}">
                                                <!-- Elemen formulir lainnya -->
                                                <div class="col-lg-12 mt-3">
                                                    <div class="input-group control-group">
                                                        <input type="text" id="spk_number_{{ $key }}"
                                                            class="form-control"
                                                            placeholder="{{ $inputCurrentGroup['spk_number'] }}"
                                                            readonly>
                                                        <button class="btn btn-danger" type="button"
                                                            wire:click="removeFieldCurrentGroup({{ $key }})"><i
                                                                class="fe fe-x"></i></button>
                                                    </div>
                                                </div>
                                                @error('inputsCurrentGroup.' . $key . '.id')
                                                    <div><span class="text-danger">{{ $message }}</span></div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col">
            {{-- <label class="form-label">Customize Select</label> --}}
            <select id="" name="" class="form-control form-select w-auto" wire:model="paginateGroup">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="searchGroup">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">No SPK</th>
                            <th class="border-bottom-0">Type SPK</th>
                            <th class="border-bottom-0">Pemesan</th>
                            <th class="border-bottom-0">Order</th>
                            <th class="border-bottom-0">No Po</th>
                            <th class="border-bottom-0">Style</th>
                            <th class="border-bottom-0">Ukuran Barang</th>
                            <th class="border-bottom-0">TGL Kirim</th>
                            <th class="border-bottom-0">Total Qty</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructionsGroup as $key => $instruction)
                            <tr wire:key="{{ $instruction->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $instruction->spk_number }}
                                    @if ($instruction->spk_number_fsc)
                                        <span class="tag tag-border">{{ $instruction->spk_number_fsc }}</span>
                                    @endif
                                </td>
                                <td>{{ $instruction->spk_type }}</td>
                                <td>{{ $instruction->customer_name }}</td>
                                <td>{{ $instruction->order_name }}</td>
                                <td>{{ $instruction->customer_number }}</td>
                                <td>{{ $instruction->code_style }}</td>
                                <td>{{ $instruction->ukuran_barang }}</td>
                                <td>{{ $instruction->shipping_date }}</td>
                                <td>{{ $instruction->quantity - $instruction->stock }}</td>
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="addFieldNewGroup('parent', '{{ $instruction->spk_number }}', {{ $instruction->id }})">Parent</button>
                                        <button class="btn btn-secondary btn-sm"
                                            wire:click="addFieldNewGroup('child', '{{ $instruction->spk_number }}', {{ $instruction->id }})">Child</button>
                                        <button class="btn btn-info btn-sm"
                                            wire:click="addFieldCurrentGroup('{{ $instruction->spk_number }}', {{ $instruction->id }})">Tambah
                                            Ke Group</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">
                                    No Data!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col d-flex justify-content-end mt-3">
            {{ $instructionsGroup->links() }}
        </div>
    </div>
</div>
