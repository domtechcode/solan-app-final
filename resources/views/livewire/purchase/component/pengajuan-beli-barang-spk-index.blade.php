<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginatePengajuanBeliBarangSpk">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchPengajuanBeliBarangSpk">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">No SPK</th>
                            <th class="border-bottom-0">Langkah Kerja</th>
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
                        @forelse ($pengajuanBeliBarangSpk as $key => $itemPengajuanBarangSpk)
                            <tr wire:key="{{ $itemPengajuanBarangSpk->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->instruction->spk_number }}
                                </td>
                                <td>
                                    {{ $itemPengajuanBarangSpk->workStepList->name }}
                                </td>
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
                                            data-bs-target="#modalPengajuanBeliBarangSpk"
                                            wire:click="modalPengajuanBeliBarangSpk({{ $itemPengajuanBarangSpk->id }}, {{ $itemPengajuanBarangSpk->instruction_id }})"
                                            wire:key="modalPengajuanBeliBarangSpk({{ $itemPengajuanBarangSpk->id }}, {{ $itemPengajuanBarangSpk->instruction_id }})"><i
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
            {{ $pengajuanBeliBarangSpk->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanBeliBarangSpk" tabindex="-1" role="dialog">
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
                                            <th class="border-bottom-0">NO. SPK</th>
                                            <th class="border-bottom-0">PEMESAN</th>
                                            <th class="border-bottom-0">NO. PO</th>
                                            <th class="border-bottom-0">ORDER</th>
                                            <th class="border-bottom-0">CODE STYLE</th>
                                            <th class="border-bottom-0">TGL. PO MASUK</th>
                                            <th class="border-bottom-0">TGL. DIKIRIM</th>
                                            <th class="border-bottom-0">QTY SPK</th>
                                            <th class="border-bottom-0">STOCK SPK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($selectedInstruction)
                                            <tr>
                                                <td>{{ $selectedInstruction->spk_number ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->customer_name ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->customer_number ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->order_name ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->code_style ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->order_date ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->shipping_date ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->quantity ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->stock ?? '-' }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">FOLLOW UP</th>
                                            <th class="border-bottom-0">TYPE SPK</th>
                                            <th class="border-bottom-0">PAJAK</th>
                                            <th class="border-bottom-0">MASTER SPK</th>
                                            <th class="border-bottom-0">SUB SPK</th>
                                            <th class="border-bottom-0">GROUP</th>
                                            <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                            <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                            <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($selectedInstruction)
                                            <tr>
                                                <td>{{ $selectedInstruction->follow_up ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->spk_type ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->taxes_type ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->spk_parent ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->sub_spk ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->group_id ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->spk_layout_number ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->spk_sample_number ?? '-' }}</td>
                                                <td>{{ $selectedInstruction->shipping_date_first ?? '-' }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col d-flex justify-content-center">
                            @if (isset($workStepHitungBahanNew))
                                <div class="btn-list">
                                    <a target="blank" class="btn btn-icon btn-sm btn-dark"
                                        href="{{ route('purchase.indexWorkStep', ['instructionId' => $selectedInstruction->id, 'workStepId' => $workStepHitungBahanNew]) }}"><i
                                            class="fe fe-link"></i> Cek Hasil Pekerjaan Hitung Bahan</a>
                                </div>
                            @endif
                        </div>
                    </div>


                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">LANGKAH KERJA</th>
                                            <th class="border-bottom-0">NAMA BARANG</th>
                                            <th class="border-bottom-0">QTY PENGAJUAN</th>
                                            <th class="border-bottom-0">KETERANGAN</th>
                                            <th class="border-bottom-0">FILE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dataPengajuanBarangSpk))
                                            <tr>
                                                @foreach ($dataPengajuanBarangSpk as $data)
                                                    <td>{{ $data->workStepList->name }}</td>
                                                    <td>{{ $data->nama_barang }}</td>
                                                    <td>{{ $data->qty_barang }}</td>
                                                    <td>{{ $data->keterangan }}</td>
                                                    <td>
                                                        @foreach ($data->filesPengajuanBarangSpk as $file)
                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                download>{{ $file->file_name }}</a> <br>
                                                        @endforeach
                                                    </td>
                                                @endforeach
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
                                                            <option value="Accounting">Accounting</option>
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
                    @if (isset($dataBarang))
                        <button class="btn btn-success" wire:click="completeBarang({{ $dataBarang->id }})"
                            wire:key="completeBarang({{ $dataBarang->id }})">Complete</button>
                    @endif
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-pengajuan-beli-barang-spk', event => {
            $('#modalPengajuanBeliBarangSpk').modal('hide');
        });
    </script>
@endpush
