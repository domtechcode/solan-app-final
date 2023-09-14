<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginateRiwayatPengajuanBarangPersonal">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchRiwayatPengajuanBarangPersonal">
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
                            <th class="border-bottom-0">Tanggal Pengajuan</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPengajuanBarangPersonal as $key => $itemPengajuanBarangPersonal)
                            <tr wire:key="{{ $itemPengajuanBarangPersonal->id }}">
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
                                @elseif(in_array($itemPengajuanBarangPersonal->status_id, [3, 17, 18]))
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
                                            data-bs-target="#modalRiwayatPengajuanBarangPersonal"
                                            wire:key="modalRiwayatPengajuanBarangPersonal"
                                            wire:click="modalRiwayatPengajuanBarangPersonal({{ $itemPengajuanBarangPersonal->id }})"><i
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
            {{ $riwayatPengajuanBarangPersonal->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalRiwayatPengajuanBarangPersonal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengajuan Barang</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">USER</th>
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
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
