<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginatePengajuanBeliBarangPersonal">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchPengajuanBeliBarangPersonal">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">Request</th>
                            <th class="border-bottom-0">Nama Barang</th>
                            <th class="border-bottom-0">Qty</th>
                            <th class="border-bottom-0">Target Tersedia</th>
                            <th class="border-bottom-0">Tgl Pengajuan</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuanBeliBarangPersonal as $key => $itemPengajuanBarangSpk)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->user->name }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->nama_barang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->qty_barang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->tgl_target_datang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->tgl_pengajuan }}
                                </td>
                                @if (in_array($itemPengajuanBarangSpk->status_id, [8]))
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangSpk->status_id, [9, 10, 11, 15]))
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangSpk->status_id, [12]))
                                    <td>
                                        <span
                                            class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangSpk->status_id, [17, 18]))
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalPengajuanBeliBarangPersonal"
                                            wire:click="modalPengajuanBeliBarangPersonal({{ $itemPengajuanBarangSpk->id }})"
                                            wire:key="modalPengajuanBeliBarangPersonal({{ $itemPengajuanBarangSpk->id }})"><i
                                                class="fe fe-eye"></i></button>
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
            {{ $pengajuanBeliBarangPersonal->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanBeliBarangPersonal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">REQUEST</th>
                                            <th class="border-bottom-0">NAMA BARANG</th>
                                            <th class="border-bottom-0">QTY PENGAJUAN</th>
                                            <th class="border-bottom-0">KETERANGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dataBarang))
                                            <tr>
                                                <td>{{ $dataBarang->user->name }}</td>
                                                <td>{{ $dataBarang->nama_barang }}</td>
                                                <td>{{ $dataBarang->qty_barang }}</td>
                                                <td>{{ $dataBarang->keterangan }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Harga Satuan" wire:model="harga_satuan"
                                        class="form-control @error('harga_satuan') is-invalid @enderror" readonly>
                                </div>
                                @error('harga_satuan')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Qty Purchase</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input" type="text"
                                        placeholder="Quantity Purchase" wire:model="qty_purchase"
                                        class="form-control @error('qty_purchase') is-invalid @enderror" readonly>
                                </div>
                                @error('qty_purchase')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Stock</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input" type="text"
                                        placeholder="Stock" wire:model="stock"
                                        class="form-control @error('stock') is-invalid @enderror" readonly>
                                </div>
                                @error('stock')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Harga Barang</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Total Harga" wire:model="total_harga"
                                        class="form-control @error('total_harga') is-invalid @enderror" readonly>
                                </div>
                                @error('total_harga')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <label class="form-label mb-3">Catatan</label>
                                    @foreach ($notes as $index => $note)
                                        <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <select class="form-control form-select"
                                                            data-bs-placeholder="Pilih Tujuan Catatan"
                                                            wire:model.defer="notes.{{ $index }}.tujuan"
                                                            readonly>
                                                            <option label="Pilih Tujuan Catatan"></option>
                                                            <option value="RAB">RAB</option>
                                                            <option value="Purchase">Purchase</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                            wire:model.defer="notes.{{ $index }}.catatan" readonly></textarea>
                                                    </div>
                                                    @error('notes.' . $index . '.catatan')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-pengajuan-beli-barang-personal', event => {
            $('#modalPengajuanBeliBarangPersonal').modal('hide');
        });
    </script>
@endpush
