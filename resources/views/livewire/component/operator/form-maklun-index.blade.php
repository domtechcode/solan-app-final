<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Keluar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-5">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">No</th>
                                        <th class="border-bottom-0">Bentuk Maklun</th>
                                        <th class="border-bottom-0">Rekanan</th>
                                        <th class="border-bottom-0">Tgl Keluar</th>
                                        <th class="border-bottom-0">QTY Keluar</th>
                                        <th class="border-bottom-0">Satuan</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                    ?>
                                    @foreach($maklunPengajuan as $index => $data)
                                        <tr>
                                            <td>
                                                {{ $no++; }}
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPengajuan.{{ $index }}.bentuk_maklun" class="form-control" autocomplete="off" placeholder="Bentuk Maklun">
                                                    </div>
                                                    @error('maklunPengajuan.'.$index.'.bentuk_maklun') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPengajuan.{{ $index }}.rekanan" class="form-control" autocomplete="off" placeholder="Rekanan">
                                                    </div>
                                                    @error('maklunPengajuan.'.$index.'.rekanan') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="date" wire:model="maklunPengajuan.{{ $index }}.tgl_keluar" class="form-control" autocomplete="off">
                                                    </div>
                                                    @error('maklunPengajuan.'.$index.'.tgl_keluar') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPengajuan.{{ $index }}.qty_keluar" class="form-control" autocomplete="off" placeholder="Qty Keluar">
                                                    </div>
                                                    @error('maklunPengajuan.'.$index.'.qty_keluar') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select wire:model="maklunPengajuan.{{ $index }}.satuan_keluar" class="form-control form-select" data-bs-placeholder="Pilih Satuan">
                                                            <option label="-- Pilih Satuan --"></option>
                                                            <option value="Pcs">pcs</option>
                                                            <option value="Lembar Cetak">Lembar Cetak</option>
                                                        </select>
                                                    </div>
                                                    @error('maklunPengajuan.'.$index.'.satuan_keluar') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                wire:click="removeMaklunPengajuan({{ $index }})"><i class="fe fe-x"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success mb-0" wire:click="addMaklunPengajuan">Tambah Maklun</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                        
                    </div>
                    <button type="button" class="btn btn-info mt-4 mb-0" wire:click="pengajuanPurchase" wire:ignore.self>Ajukan Ke Purchase</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->

    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Kembali</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-5">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">No</th>
                                        <th class="border-bottom-0">Bentuk Maklun</th>
                                        <th class="border-bottom-0">Rekanan</th>
                                        <th class="border-bottom-0">Tgl Kembali</th>
                                        <th class="border-bottom-0">QTY Kembali</th>
                                        <th class="border-bottom-0">Satuan</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 1;
                                    ?>
                                    @foreach($maklunPenerimaan as $index => $data)
                                        <tr>
                                            <td>
                                                {{ $no++; }}
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPenerimaan.{{ $index }}.bentuk_maklun" class="form-control" autocomplete="off" placeholder="Bentuk Maklun">
                                                    </div>
                                                    @error('maklunPenerimaan.'.$index.'.bentuk_maklun') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPenerimaan.{{ $index }}.rekanan" class="form-control" autocomplete="off" placeholder="Rekanan">
                                                    </div>
                                                    @error('maklunPenerimaan.'.$index.'.rekanan') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="date" wire:model="maklunPenerimaan.{{ $index }}.tgl_kembali" class="form-control" autocomplete="off">
                                                    </div>
                                                    @error('maklunPenerimaan.'.$index.'.tgl_kembali') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="maklunPenerimaan.{{ $index }}.qty_kembali" class="form-control" autocomplete="off" placeholder="Qty Keluar">
                                                    </div>
                                                    @error('maklunPenerimaan.'.$index.'.qty_kembali') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select wire:model="maklunPenerimaan.{{ $index }}.satuan_kembali" class="form-control form-select" data-bs-placeholder="Pilih Satuan">
                                                            <option label="-- Pilih Satuan --"></option>
                                                            <option value="Pcs">pcs</option>
                                                            <option value="Lembar Cetak">Lembar Cetak</option>
                                                        </select>
                                                    </div>
                                                    @error('maklunPenerimaan.'.$index.'.satuan_kembali') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                wire:click="removeMaklunPengajuanPenerimaan({{ $index }})"><i class="fe fe-x"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success mb-0" wire:click="addMaklunPenerimaan">Tambah Maklun</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                        
                    </div>
                    <button type="button" class="btn btn-info mt-4 mb-0" wire:click="update" wire:ignore.self>Update Data Maklun</button>
                    <button type="button" class="btn btn-success mt-4 mb-0" wire:click="save" wire:ignore.self>Submit & Maklun Selesai</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>