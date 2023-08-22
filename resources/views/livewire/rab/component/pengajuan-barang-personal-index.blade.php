<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginatePengajuanBarangPersonal">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchPengajuanBarangPersonal">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">Nama</th>
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
                        @forelse ($pengajuanBarangPersonal as $key => $itemPengajuanBarangPersonal)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $itemPengajuanBarangPersonal->user->name }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangPersonal->nama_barang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangPersonal->qty_barang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangPersonal->tgl_target_datang }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangPersonal->tgl_pengajuan }}
                                </td>
                                @if (in_array($itemPengajuanBarangPersonal->status_id, [8]))
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangPersonal->status_id, [9, 10, 11, 15]))
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangPersonal->status_id, [12]))
                                    <td>
                                        <span
                                            class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanBarangPersonal->status_id, [17, 18]))
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalPengajuanBarangPersonal"
                                            wire:key="modalPengajuanBarangPersonal({{ $itemPengajuanBarangPersonal->id }})"
                                            wire:click="modalPengajuanBarangPersonal({{ $itemPengajuanBarangPersonal->id }})"><i
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
            {{ $pengajuanBarangPersonal->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanBarangPersonal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (isset($catatan))
                        @foreach ($catatan as $datanote)
                            @if (isset($datanote))
                                <div class="row row-sm mb-5">
                                    <div class="text-wrap">
                                        <div class="">
                                            <div class="alert alert-info">
                                                <span class=""><svg xmlns="http://www.w3.org/2000/svg"
                                                        height="40" width="40" viewBox="0 0 24 24">
                                                        <path fill="#70a9ee"
                                                            d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                                        <circle cx="12" cy="17" r="1"
                                                            fill="#1170e4" />
                                                        <path fill="#1170e4"
                                                            d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                                    </svg></span>
                                                <strong>Catatan Dari Operator : {{ $datanote->user->name }}</strong>
                                                <hr class="message-inner-separator">
                                                <p>{{ $datanote->catatan }}</p>
                                                <div class="d-flex justify-content-end">
                                                    <small>{{ $datanote->created_at }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">NAMA</th>
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
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Quantity Purchase" wire:model="qty_purchase"
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
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Stock" wire:model="stock"
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
                                    <div class="form-group">
                                        <label class="form-label mb-3">Catatan</label>
                                        <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i
                                                class="fe fe-plus"></i>Tambah Catatan</button>
                                    </div>

                                    @foreach ($notes as $index => $note)
                                        <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <select class="form-control form-select"
                                                            data-bs-placeholder="Pilih Tujuan Catatan"
                                                            wire:model.defer="notes.{{ $index }}.tujuan">
                                                            <option label="Pilih Tujuan Catatan"></option>
                                                            <option value="Purchase">Purchase</option>
                                                            <option value="Accounting">Accounting</option>
                                                        </select>
                                                        <button class="btn btn-danger" type="button"
                                                            wire:click="removeNote({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    </div>
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                            wire:model.defer="notes.{{ $index }}.catatan"></textarea>
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
                    @if (isset($dataBarang))
                        <button class="btn btn-success"
                            wire:click="approveBarang({{ $dataBarang->id }})" wire:key="approveBarang({{ $dataBarang->id }})">Approve</button>
                        <button class="btn btn-primary"
                            wire:click="rejectBarang({{ $dataBarang->id }})" wire:key="rejectBarang({{ $dataBarang->id }})">Reject</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-pengajuan-barang-personal', event => {
            $('#modalPengajuanBarangPersonal').modal('hide');
        });
    </script>
@endpush
