<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form {{ $jenis_pekerjaan }}</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pekerjaan Sebelumnya</label>
                                <div class="input-group">
                                    <input type="text" wire:model="workStepsBefore" id="workStepsBefore"
                                        class="form-control" autocomplete="off" placeholder="Pekerjaan Sebelumnya" disabled>
                                </div>
                                @error('workStepsBefore')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Pekerjaan Selanjutnya</label>
                                <div class="input-group">
                                    <input type="text" wire:model="workStepsAfter" id="workStepsAfter"
                                        class="form-control" autocomplete="off" placeholder="Pekerjaan Sebelumnya" disabled>
                                </div>
                                @error('workStepsAfter')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 mb-5">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Nama Anggota</th>
                                        <th class="border-bottom-0">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggota as $index => $data)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select wire:model="anggota.{{ $index }}.nama"
                                                            class="form-control form-select"
                                                            data-bs-placeholder="Pilih Nama Anggota" readonly>
                                                            <option label="-- Pilih Nama Anggota --"></option>
                                                            @foreach ($dataAnggota as $data)
                                                                <option value="{{ $data['name'] }}">
                                                                    {{ $data['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('anggota.' . $index . '.nama')
                                                        <div><span class="text-danger">{{ $message }}</span></div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            wire:model="anggota.{{ $index }}.hasil"
                                                            class="form-control" autocomplete="off"
                                                            placeholder="Hasil" readonly>
                                                    </div>
                                                    @error('anggota.' . $index . '.hasil')
                                                        <div><span class="text-danger">{{ $message }}</span></div>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <div class="input-group">
                                    <input type="text" wire:model="jenis_pekerjaan" id="jenis_pekerjaan"
                                        class="form-control" autocomplete="off" placeholder="Jenis Pekerjaan" readonly>
                                </div>
                                @error('jenis_pekerjaan')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Hasil Akhir</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir" id="hasil_akhir" class="form-control"
                                        autocomplete="off" placeholder="Hasil Akhir" readonly>
                                </div>
                                @error('hasil_akhir')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Jumlah Barang Gagal</label>
                                <div class="input-group">
                                    <input type="text" wire:model="jumlah_barang_gagal" id="jumlah_barang_gagal" class="form-control"
                                        autocomplete="off" placeholder="Jumlah Barang Gagal" readonly>
                                </div>
                                @error('jumlah_barang_gagal')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Satuan</label>
                                <div class="input-group">
                                    <select wire:model="satuan" id="satuan" class="form-control form-select"
                                        data-bs-placeholder="Pilih Satuan" readonly>
                                        <option label="-- Pilih Satuan --"></option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Lembar Cetak">Lembar Cetak</option>
                                    </select>
                                </div>
                                @error('satuan')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <div class="table-responsive">
                                <table
                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Catatan Proses Pengerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                @php
                                                    $catatan_proses_pengerjaan_Data = json_decode($workStepData->catatan_proses_pengerjaan);
                                                @endphp

                                                @if (is_array($catatan_proses_pengerjaan_Data))
                                                    <ul>
                                                        @foreach ($catatan_proses_pengerjaan_Data as $item)
                                                            <li>-> {{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <div class="table-responsive">
                                <table
                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Tujuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($catatanData as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->catatan }}
                                                    {{ $item->tujuan }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                -
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
