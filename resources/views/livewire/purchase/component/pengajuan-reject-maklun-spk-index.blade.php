<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto"
                wire:model="paginatePengajuanRejectMaklunSpk">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search"
                wire:model="searchPengajuanRejectMaklunSpk">
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
                        @forelse ($pengajuanRejectMaklunSpk as $key => $itemPengajuanRejectMaklunSpk)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->instruction->spk_number }}
                                </td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->bentuk_maklun }}
                                </td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->rekanan }}
                                </td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->tgl_keluar }}
                                </td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->qty_keluar }}
                                </td>
                                <td>
                                    {{ $itemPengajuanRejectMaklunSpk->satuan_keluar }}
                                </td>
                                @if ($itemPengajuanRejectMaklunSpk->status == 'Pengajuan Purchase')
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanRejectMaklunSpk->status, ['Pengajuan Accounting', 'Pengajuan RAB']))
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @elseif(in_array($itemPengajuanRejectMaklunSpk->status, ['Reject Accounting', 'Reject RAB']))
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->status }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanRejectMaklunSpk->pekerjaan }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalPengajuanRejectMaklunSpk"
                                            wire:click="modalPengajuanRejectMaklunSpk({{ $itemPengajuanRejectMaklunSpk->id }}, {{ $itemPengajuanRejectMaklunSpk->instruction_id }})"
                                            wire:key="modalPengajuanRejectMaklunSpk({{ $itemPengajuanRejectMaklunSpk->id }}, {{ $itemPengajuanRejectMaklunSpk->instruction_id }})"><i
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
            {{ $pengajuanRejectMaklunSpk->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanRejectMaklunSpk" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
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
                                        class="form-control @error('harga_satuan_maklun') is-invalid @enderror">
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
                                        class="form-control @error('qty_purchase_maklun') is-invalid @enderror">
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
                                    <button class="btn btn-primary" type="button" wire:click="cekTotalHargaMaklun"
                                        wire:key="cekTotalHargaMaklun">Cek Total</button>
                                </div>
                                @error('total_harga_maklun')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (isset($dataMaklun))
                        <button class="btn btn-info" wire:click="ajukanAccountingMaklun({{ $dataMaklun->id }})"
                            wire:key="ajukanAccountingMaklun({{ $dataMaklun->id }})">Ajukan <i
                                class="fe fe-arrow-right"></i> Accounting</button>
                        <button class="btn btn-info" wire:click="ajukanRabMaklun({{ $dataMaklun->id }})"
                            wire:key="ajukanRabMaklun({{ $dataMaklun->id }})">Ajukan <i
                                class="fe fe-arrow-right"></i> Rab</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-pengajuan-reject-maklun-spk', event => {
            $('#modalPengajuanRejectMaklunSpk').modal('hide');
        });
    </script>
@endpush
