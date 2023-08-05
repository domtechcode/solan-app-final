<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
                <select id="" name="" class="form-control form-select w-auto" wire:model="paginate">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="search">
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
                        @forelse ($pengajuanBarangSpk as $key => $itemPengajuanBarangSpk)
                        <tr>
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
                            @if(in_array($itemPengajuanBarangSpk->status_id, [8]))
                            <td>
                                <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangSpk->status_id, [9, 10, 11, 15]))
                            <td>
                                <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangSpk->status_id, [12]))
                            <td>
                                <span class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangSpk->status_id, [17, 18]))
                            <td>
                                <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                            </td>
                            @else
                            <td>
                                <span class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangSpk->state }}</span>
                            </td>
                            @endif
                            <td>
                                <div class="btn-list">         
                                    <button class="btn btn-icon btn-sm btn-dark" wire:click="modalPengajuanBarangSpk({{ $itemPengajuanBarangSpk->id }}, {{ $itemPengajuanBarangSpk->instruction_id }})"><i class="fe fe-eye"></i></button>
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
            {{ $pengajuanBarangSpk->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalPengajuanBarangSpk" tabindex="-1" role="dialog">
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
                                        @if($selectedInstruction)
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
                                        @if($selectedInstruction)
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
                            @if(isset($workStepHitungBahanNew))
                                <div class="btn-list">  
                                    <a target="blank" class="btn btn-icon btn-sm btn-dark" href="{{ route('accounting.indexWorkStep', ['instructionId' =>  $selectedInstruction->id, 'workStepId' => $workStepHitungBahanNew]) }}"><i class="fe fe-link"></i> Cek Hasil Pekerjaan Hitung Bahan</a>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($dataBarang))
                                        <tr>
                                            <td>{{ $dataBarang->workStepList->name }}</td>
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
                                    <input type="text" wire:model="harga_satuan" id="harga_satuan" class="form-control" autocomplete="off" placeholder="Harga Satuan" type-currency="IDR">
                                </div>
                                @error('harga_satuan') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Qty Purchase</label>
                                <div class="input-group">
                                    <input type="text" wire:model="qty_purchase" id="qty_purchase" class="form-control" autocomplete="off" placeholder="Qty Purchase" type-currency="IDR">
                                </div>
                                @error('qty_purchase') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Stock</label>
                                <div class="input-group">
                                    <input type="text" wire:model="stock" id="stock" class="form-control" autocomplete="off" placeholder="Stock" type-currency="IDR">
                                </div>
                                @error('stock') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Total Harga Barang</label>
                                <div class="input-group">
                                    <input type="text" wire:model="total_harga" id="total_harga" class="form-control" autocomplete="off" placeholder="Total Harga Barang" readonly>
                                    <button class="btn btn-primary" type="button" wire:click="cekTotalHarga()">Cek Total</button>
                                </div>
                                @error('total_harga') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                    @if(isset($dataBarang))
                        @if($dataBarang->state == 'Purchase')
                            @if($dataBarang->status_id == 8)
                                <button class="btn btn-info" wire:click="ajukanAccountingBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Accounting</button>
                                <button class="btn btn-info" wire:click="ajukanRabBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Rab</button>
                                <button class="btn btn-warning" wire:click="stockBarang({{ $dataBarang->id }})">Check Stock</button>
                            @elseif($dataBarang->status_id == 9)
                                <button class="btn btn-info" wire:click="ajukanAccountingBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Accounting</button>
                                <button class="btn btn-info" wire:click="ajukanRabBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Rab</button>
                            @elseif($dataBarang->status_id == 12)
                                <button class="btn btn-info" wire:click="ajukanAccountingBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Accounting</button>
                                <button class="btn btn-info" wire:click="ajukanRabBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Rab</button>
                                <button class="btn btn-success" wire:click="completeBarang">Complete</button>
                            @elseif(in_array($dataBarang->status_id, [13, 14]))
                                <button class="btn btn-success" wire:click="completeBarang">Complete</button>
                                <button class="btn btn-info" wire:click="beliBarang">Beli</button>
                            @else
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @endif
                        @elseif($dataBarang->state == 'Accounting')\
                            
                            <button class="btn btn-info" wire:click="ajukanAccountingBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Accounting</button>
                            <button class="btn btn-info" wire:click="ajukanRabBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Rab</button>
                            <button class="btn btn-warning" wire:click="stockBarang({{ $dataBarang->id }})">Check Stock</button>
                        @else
                            <button class="btn btn-info" wire:click="ajukanAccountingBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Accounting</button>
                            <button class="btn btn-info" wire:click="ajukanRabBarang({{ $dataBarang->id }})">Ajukan <i class="fe fe-arrow-right"></i> Rab</button>
                            <button class="btn btn-warning" wire:click="stockBarang({{ $dataBarang->id }})">Check Stock</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Group-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModalGroupNewSpk" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction Group</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default active">
                            <div class="panel-heading " role="tab" id="headingOne1">
                                <h4 class="panel-title">
                                    <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            {{ $selectedGroupParent->spk_number ?? '-' }} <span class="tag tag-blue">Parent</span>
                                        </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                                <div class="panel-body">
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
                                                            <th class="border-bottom-0">QTY</th>
                                                            <th class="border-bottom-0">STOCK</th>
                                                            <th class="border-bottom-0">HARGA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->spk_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->code_style ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->quantity ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->stock ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->price ?? '-' }}</td>
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
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->follow_up ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->taxes_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_parent ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->sub_spk ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->group_id ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_layout_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_sample_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date_first ?? '-' }}</td>
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
                                                            <th>LANGKAH KERJA</th>
                                                            <th>TARGET SELESAI</th>
                                                            <th>DIJADWALKAN</th>
                                                            <th>TARGET JAM</th>
                                                            <th>OPERATOR/REKANAN</th>
                                                            <th>MACHINE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($selectedWorkStepParent)
                                                            @foreach ($selectedWorkStepParent as $workstep)
                                                                <tr>
                                                                    <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                                    <td>{{ $workstep->target_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                                    <td>{{ $workstep->user->name ?? '-' }}</td>
                                                                    <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- file --}}
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Contoh <hr>
                                                    <div class="d-flex text-center">
                                                        <ul>
                                                            @if ($selectedFileContohParent)
                                                                @foreach ($selectedFileContohParent as $file)
                                                                    <li class="mb-3">
                                                                        <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                        <div class="expanel expanel-default">
                                                                            <div class="expanel-body">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <p>No files found.</p>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Arsip <hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileArsipParent)
                                                            @foreach ($selectedFileArsipParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                            </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <p>No files found.</p>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Sample <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileSampleParent)
                                                                    @foreach ($selectedFileSampleParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Accounting<hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileAccountingParent)
                                                            @foreach ($selectedFileAccountingParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                            </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <p>No files found.</p>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Layout <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileLayoutParent)
                                                                    @foreach ($selectedFileLayoutParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $no = 2; ?>
                        @if($selectedInstructionChild)
                            @foreach ($selectedInstructionChild as $index => $data)
                            <?php $no++; ?>
                            <div class="panel panel-default mt-2">
                                <div class="panel-heading" role="tab" id="headingTwo2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse{{ $no }}" aria-expanded="false" aria-controls="collapse{{ $no }}">
    
                                                {{ $data->spk_number ?? '-' }} <span class="tag tag-red">Child</span>
                                            </a>
                                    </h4>
                                </div>
                                <div id="collapse{{ $no }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
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
                                                                <th class="border-bottom-0">QTY</th>
                                                                <th class="border-bottom-0">STOCK</th>
                                                                <th class="border-bottom-0">HARGA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data)
                                                            <tr>
                                                                <td>{{ $data->spk_number ?? '-' }}</td>
                                                                <td>{{ $data->customer_name ?? '-' }}</td>
                                                                <td>{{ $data->customer_number ?? '-' }}</td>
                                                                <td>{{ $data->order_name ?? '-' }}</td>
                                                                <td>{{ $data->code_style ?? '-' }}</td>
                                                                <td>{{ $data->order_date ?? '-' }}</td>
                                                                <td>{{ $data->shipping_date ?? '-' }}</td>
                                                                <td>{{ $data->quantity ?? '-' }}</td>
                                                                <td>{{ $data->stock ?? '-' }}</td>
                                                                <td>{{ $data->price ?? '-' }}</td>
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
                                                            @if($data)
                                                            <tr>
                                                                <td>{{ $data->follow_up ?? '-' }}</td>
                                                                <td>{{ $data->spk_type ?? '-' }}</td>
                                                                <td>{{ $data->taxes_type ?? '-' }}</td>
                                                                <td>{{ $data->spk_parent ?? '-' }}</td>
                                                                <td>{{ $data->sub_spk ?? '-' }}</td>
                                                                <td>{{ $data->group_id ?? '-' }}</td>
                                                                <td>{{ $data->spk_layout_number ?? '-' }}</td>
                                                                <td>{{ $data->spk_sample_number ?? '-' }}</td>
                                                                <td>{{ $data->shipping_date_first ?? '-' }}</td>
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
                                                                <th>LANGKAH KERJA</th>
                                                                <th>TARGET SELESAI</th>
                                                                <th>DIJADWALKAN</th>
                                                                <th>TARGET JAM</th>
                                                                <th>OPERATOR/REKANAN</th>
                                                                <th>MACHINE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data->workstep)
                                                                @foreach ($data->workstep as $workstep)
                                                                    <tr>
                                                                        <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                                        <td>{{ $workstep->target_date ?? '-' }}</td>
                                                                        <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                                        <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                                        <td>{{ $workstep->user->name ?? '-' }}</td>
                                                                        <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- file --}}
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Contoh <hr>
                                                        <div class="d-flex text-center">
                                                            <ul>
                                                                @if ($data->fileArsip)
                                                                    @foreach ($data->fileArsip as $file)
                                                                    @if($file->type_file == 'contoh')
                                                                        <li class="mb-3">
                                                                            <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                            <div class="expanel expanel-default">
                                                                                <div class="expanel-body">
                                                                                    <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    <p>No files found.</p>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Arsip <hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'arsip')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    <p>No files found.</p>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                File Sample <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'sample')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                        @endforeach
                                                                    @else
                                                                        <li>
                                                                            <p>No files found.</p>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Accounting<hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'accounting')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    <p>No files found.</p>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                File Layout <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'layout')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                        @endforeach
                                                                    @else
                                                                        <li>
                                                                            <p>No files found.</p>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- PANEL-GROUP -->
                            @endforeach
                        @endif
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
        function addCurrencyListener() {
            document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPostion = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLenght = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {    
                        this.value = value.toLocaleString('id-ID', {
                            minimumFractionDigits: 0
                        });
                        cursorPostion = this.value.length - originalLenght + cursorPostion;
                        this.setSelectionRange(cursorPostion, cursorPostion);
                    }
                });
            });
        }

        window.addEventListener('close-modal-pengajuan-barang-spk', event =>{
            $('#modalPengajuanBarangSpk').modal('hide');
            // $('#detailInstructionModalGroupNewSpk').modal('hide');
        });

        window.addEventListener('show-detail-pengajuan-barang-spk', event =>{
            $('#modalPengajuanBarangSpk').modal('show');
            addCurrencyListener();
        });

        // window.addEventListener('show-detail-instruction-modal-group-new-spk', event =>{
        //     $('#detailInstructionModalGroupNewSpk').modal('show');
        // });
    </script>
@endpush