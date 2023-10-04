<div>
    {{-- Do your work, then step back. --}}

    @if (isset($collectStep))
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Hasil Langkah Kerja - {{ $collectStep }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Hasil Akhir</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="collectHasilAkhir" id="collectHasilAkhir"
                                            class="form-control" autocomplete="off" placeholder="Hasil Akhir" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @endif

    @if ($anggotaGroupSpk)
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
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">No Spk</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Keluar</th>
                                            <th class="border-bottom-0">QTY Keluar</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Status</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPengajuan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPengajuan.{{ $index }}.instruction_id"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih No Spk">
                                                                <option label="-- Pilih No Spk --"></option>
                                                                @foreach ($anggotaGroupSpk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->spk_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.instruction_id')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.bentuk_maklun"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Bentuk Maklun" readonly>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.bentuk_maklun')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.rekanan"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Rekanan">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.rekanan')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date"
                                                                wire:model="maklunPengajuan.{{ $index }}.tgl_keluar"
                                                                class="form-control" autocomplete="off">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.tgl_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.qty_keluar"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Keluar">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.qty_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPengajuan.{{ $index }}.satuan_keluar"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih Satuan">
                                                                <option label="-- Pilih Satuan --"></option>
                                                                <option value="Pcs">pcs</option>
                                                                <option value="Lembar Cetak">Lembar Cetak</option>
                                                            </select>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.satuan_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea class="form-control" placeholder="Catatan" rows="1"
                                                                wire:model="maklunPengajuan.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.catatan')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $data['status'] }}
                                                </td>
                                                <td>
                                                    @if ($data['status'] == 'Pengajuan Purchase')
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="removeMaklunPengajuanGroup({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-success mb-0"
                                                        wire:click="addMaklunPengajuanGroup">Tambah Maklun</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="button" class="btn btn-info mt-4 mb-0" wire:click="pengajuanPurchaseGroup"
                            wire:ignore.self>Ajukan Ke Purchase</button>
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
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">No Spk</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Kembali</th>
                                            <th class="border-bottom-0">QTY Kembali</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPenerimaan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPenerimaan.{{ $index }}.instruction_id"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih No Spk">
                                                                <option label="-- Pilih No Spk --"></option>
                                                                @foreach ($anggotaGroupSpk as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->spk_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.instruction_id')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.bentuk_maklun"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Bentuk Maklun" readonly>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.bentuk_maklun')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.rekanan"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Rekanan">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.rekanan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date"
                                                                wire:model="maklunPenerimaan.{{ $index }}.tgl_kembali"
                                                                class="form-control" autocomplete="off">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.tgl_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.qty_kembali"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Keluar">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.qty_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPenerimaan.{{ $index }}.satuan_kembali"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih Satuan">
                                                                <option label="-- Pilih Satuan --"></option>
                                                                <option value="Pcs">pcs</option>
                                                                <option value="Lembar Cetak">Lembar Cetak</option>
                                                            </select>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.satuan_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea class="form-control" placeholder="Catatan" rows="1"
                                                                wire:model="maklunPenerimaan.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.catatan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="removeMaklunPengajuanPenerimaan({{ $index }})"><i
                                                            class="fe fe-x"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-success mb-0"
                                                        wire:click="addMaklunPenerimaan">Tambah Penerimaan</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="button" class="btn btn-info mt-4 mb-0" wire:click="updateGroup"
                            wire:ignore.self>Update Data Maklun</button>
                        <button type="button" class="btn btn-success mt-4 mb-0" wire:click="saveGroup"
                            wire:ignore.self>Submit & Maklun Selesai</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @else
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
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Keluar</th>
                                            <th class="border-bottom-0">QTY Keluar</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Status</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPengajuan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.bentuk_maklun"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Bentuk Maklun" readonly>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.bentuk_maklun')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.rekanan"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Rekanan">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.rekanan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date"
                                                                wire:model="maklunPengajuan.{{ $index }}.tgl_keluar"
                                                                class="form-control" autocomplete="off">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.tgl_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPengajuan.{{ $index }}.qty_keluar"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Keluar">
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.qty_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPengajuan.{{ $index }}.satuan_keluar"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih Satuan">
                                                                <option label="-- Pilih Satuan --"></option>
                                                                <option value="Pcs">pcs</option>
                                                                <option value="Lembar Cetak">Lembar Cetak</option>
                                                            </select>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.satuan_keluar')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea class="form-control" placeholder="Catatan" rows="1"
                                                                wire:model="maklunPengajuan.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                        @error('maklunPengajuan.' . $index . '.catatan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $data['status'] }}
                                                </td>
                                                <td>
                                                    @if ($data['status'] == 'Pengajuan Purchase')
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="removeMaklunPengajuan({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-success mb-0"
                                                        wire:click="addMaklunPengajuan">Tambah Maklun</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="button" class="btn btn-info mt-4 mb-0" wire:click="pengajuanPurchase"
                            wire:ignore.self>Ajukan Ke Purchase</button>
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
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Kembali</th>
                                            <th class="border-bottom-0">QTY Kembali</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPenerimaan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.bentuk_maklun"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Bentuk Maklun" readonly>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.bentuk_maklun')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.rekanan"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Rekanan">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.rekanan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date"
                                                                wire:model="maklunPenerimaan.{{ $index }}.tgl_kembali"
                                                                class="form-control" autocomplete="off">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.tgl_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="maklunPenerimaan.{{ $index }}.qty_kembali"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Qty Keluar">
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.qty_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select
                                                                wire:model="maklunPenerimaan.{{ $index }}.satuan_kembali"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih Satuan">
                                                                <option label="-- Pilih Satuan --"></option>
                                                                <option value="Pcs">pcs</option>
                                                                <option value="Lembar Cetak">Lembar Cetak</option>
                                                            </select>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.satuan_kembali')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <textarea class="form-control" placeholder="Catatan" rows="1"
                                                                wire:model="maklunPenerimaan.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                        @error('maklunPenerimaan.' . $index . '.catatan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="removeMaklunPengajuanPenerimaan({{ $index }})"><i
                                                            class="fe fe-x"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8">
                                                <div class="text-center">
                                                    <button type="button" class="btn btn-success mb-0"
                                                        wire:click="addMaklunPenerimaan">Tambah Penerimaan</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                        <button type="button" class="btn btn-info mt-4 mb-0" wire:click="update"
                            wire:ignore.self>Update Data Maklun</button>
                        <button type="button" class="btn btn-success mt-4 mb-0" wire:click="save"
                            wire:ignore.self>Submit & Maklun Selesai</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @endif

</div>
