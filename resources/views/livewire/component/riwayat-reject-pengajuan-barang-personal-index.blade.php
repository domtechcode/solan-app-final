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
                                            data-bs-target="#modalRiwayatRejectPengajuanBarangPersonal"
                                            wire:key="modalRiwayatRejectPengajuanBarangPersonal"
                                            wire:click="modalRiwayatRejectPengajuanBarangPersonal({{ $itemPengajuanBarangPersonal->id }})"><i
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
    <div wire:ignore.self class="modal fade" id="modalRiwayatRejectPengajuanBarangPersonal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengajuan Barang</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (isset($catatanRejectBarangPersonal))
                        @foreach ($catatanRejectBarangPersonal as $datanote)
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
                                                <strong>Keterangan Reject : {{ $datanote->user->name }}</strong>
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
                                            <th class="border-bottom-0">USER</th>
                                            <th class="border-bottom-0">NAMA BARANG</th>
                                            <th class="border-bottom-0">QTY PENGAJUAN</th>
                                            <th class="border-bottom-0">KETERANGAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dataBarangPersonal))
                                            <tr>
                                                @foreach ($dataBarangPersonal as $key => $data)
                                                <td>{{ $data['user'] }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataBarangPersonal.{{ $key }}.nama_barang"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Nama Barang">
                                                        </div>
                                                        @error("dataBarangPersonal.$key.nama_barang")
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataBarangPersonal.{{ $key }}.qty_barang"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Barang">
                                                        </div>
                                                        @error("dataBarangPersonal.$key.qty_barang")
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea
                                                                wire:model="dataBarangPersonal.{{ $key }}.keterangan"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Barang"></textarea>
                                                        </div>
                                                        @error("dataBarangPersonal.$key.keterangan")
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                @endforeach
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" wire:click="ajukanBarangPersonalKembali" wire:key="ajukanBarangPersonalKembali">Ajukan Kembali</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-pengajuan-reject-barang-personal', event => {
            $('#modalRiwayatRejectPengajuanBarangPersonal').modal('hide');
        });
    </script>
@endpush