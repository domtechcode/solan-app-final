<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="row">
        <div class="col">
            {{-- <label class="form-label">Customize Select</label> --}}
            <select id="" name="" class="form-control form-select w-auto" wire:model="paginateUngroup">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="searchUngroup">
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
                            <th class="border-bottom-0">Priority</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructionsUngroup as $key => $instruction)
                            <tr wire:key="{{ $instruction->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $instruction->spk_number }}
                                    @if ($instruction->spk_number_fsc)
                                        <span class="tag tag-border">{{ $instruction->spk_number_fsc }}</span>
                                    @endif
                                    @if ($instruction->group_id)
                                        <button class="btn btn-icon btn-sm btn-info"
                                            wire:click="modalInstructionDetailsGroup({{ $instruction->group_id }})">Group-{{ $instruction->group_id }}</button>
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
                                <td>{{ $instruction->group_priority }}</td>
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="deleteGroup({{ $instruction->id }})">Ungroup</button>
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
            {{ $instructionsUngroup->links() }}
        </div>
    </div>
</div>
