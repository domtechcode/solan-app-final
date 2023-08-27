<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginatePengajuanCompleteMaklunSpk">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchPengajuanCompleteMaklunSpk">
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
                            <th class="border-bottom-0">Bentuk Maklun</th>
                            <th class="border-bottom-0">Rekanan</th>
                            <th class="border-bottom-0">Tgl Keluar</th>
                            <th class="border-bottom-0">QTY Keluar</th>
                            <th class="border-bottom-0">Satuan Keluar</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuanCompleteMaklunSpk as $key => $itemPengajuanCompleteMaklunSpk)
                            <tr wire:key="{{ $itemPengajuanCompleteMaklunSpk->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->instruction->spk_number }}
                                </td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->bentuk_maklun }}
                                </td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->rekanan }}
                                </td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->tgl_keluar }}
                                </td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->qty_keluar }}
                                </td>
                                <td>
                                    {{ $itemPengajuanCompleteMaklunSpk->satuan_keluar }}
                                </td>
                                @if ($itemPengajuanCompleteMaklunSpk->status == 'Pengajuan Purchase')
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanCompleteMaklunSpk->status, ['Pengajuan Accounting', 'Pengajuan RAB']))
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanCompleteMaklunSpk->status, ['Reject Accounting', 'Reject RAB']))
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanCompleteMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalPengajuanCompleteMaklunSpk"
                                            wire:click="modalPengajuanCompleteMaklunSpk({{ $itemPengajuanCompleteMaklunSpk->id }}, {{ $itemPengajuanCompleteMaklunSpk->instruction_id }})"
                                            wire:key="modalPengajuanCompleteMaklunSpk({{ $itemPengajuanCompleteMaklunSpk->id }}, {{ $itemPengajuanCompleteMaklunSpk->instruction_id }})"><i
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
            {{ $pengajuanCompleteMaklunSpk->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanCompleteMaklunSpk" tabindex="-1" role="dialog">
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
                                            <th class="border-bottom-0">BENTUK MAKLUN</th>
                                            <th class="border-bottom-0">REKANAN</th>
                                            <th class="border-bottom-0">TGL KELUAR</th>
                                            <th class="border-bottom-0">QTY KELUAR</th>
                                            <th class="border-bottom-0">SATUAN KELUAR</th>
                                            <th class="border-bottom-0">CATATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($dataMaklun))
                                            <tr>
                                                <td>{{ $dataMaklun->bentuk_maklun }}</td>
                                                <td>{{ $dataMaklun->rekanan }}</td>
                                                <td>{{ $dataMaklun->tgl_keluar }}</td>
                                                <td>{{ $dataMaklun->qty_keluar }}</td>
                                                <td>{{ $dataMaklun->satuan_keluar }}</td>
                                                <td>{{ $dataMaklun->catatan }}</td>
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
                                <label class="form-label">Harga Satuan Maklun</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Harga Satuan Maklun"
                                        wire:model="harga_satuan_maklun"
                                        class="form-control @error('harga_satuan_maklun') is-invalid @enderror"
                                        readonly>
                                </div>
                                @error('harga_satuan_maklun')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Qty Purchase Maklun</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Qty Purchase Maklun"
                                        wire:model="qty_purchase_maklun"
                                        class="form-control @error('qty_purchase_maklun') is-invalid @enderror"
                                        readonly>
                                </div>
                                @error('qty_purchase_maklun')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Total Harga Maklun</label>
                                <div class="input-group">
                                    <input x-data x-mask:dynamic="$money($input, '.', ',', 4)" x-ref="input"
                                        type="text" placeholder="Total Harga Maklun"
                                        wire:model="total_harga_maklun"
                                        class="form-control @error('total_harga_maklun') is-invalid @enderror"
                                        readonly>
                                </div>
                                @error('total_harga_maklun')
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
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
