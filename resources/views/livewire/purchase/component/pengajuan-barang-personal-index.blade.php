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
                            @if(in_array($itemPengajuanBarangPersonal->status_id, [8]))
                            <td>
                                <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangPersonal->status_id, [9, 10, 11, 15]))
                            <td>
                                <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangPersonal->status_id, [12]))
                            <td>
                                <span class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-warning rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                            </td>
                            @elseif(in_array($itemPengajuanBarangPersonal->status_id, [17, 18]))
                            <td>
                                <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                            </td>
                            @else
                            <td>
                                <span class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->status->desc_status }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success rounded-pill text-white p-2 px-3">{{ $itemPengajuanBarangPersonal->state }}</span>
                            </td>
                            @endif
                            <td>
                                <div class="btn-list">         
                                    <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#modalPengajuanBarangPersonal" wire:key="modalPengajuanBarangSpk" wire:click="modalPengajuanBarangSpk({{ $itemPengajuanBarangPersonal->id }})"><i class="fe fe-eye"></i></button>
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
                                        @if(isset($dataBarang))
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
                                <button class="btn btn-success" wire:click="completeBarang({{ $dataBarang->id }})">Complete</button>
                            @elseif(in_array($dataBarang->status_id, [13, 14]))
                                <button class="btn btn-info" wire:click="beliBarang({{ $dataBarang->id }})">Beli</button>
                            @elseif($dataBarang->status_id == 15)
                                <button class="btn btn-success" wire:click="completeBarang({{ $dataBarang->id }})">Complete</button>
                            @else
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @endif
                        @elseif($dataBarang->state == 'Accounting')
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @else
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @endif
                    @endif
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

        window.addEventListener('close-modal-pengajuan-barang-personal', event =>{
            $('#modalPengajuanBarangPersonal').modal('hide');
        });

        window.addEventListener('show-detail-pengajuan-barang-personal', event =>{
            $('#modalPengajuanBarangPersonal').modal('show');
            addCurrencyListener();
        });
    </script>
@endpush