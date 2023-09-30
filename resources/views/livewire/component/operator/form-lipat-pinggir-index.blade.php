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
                        <div class="col-sm-12 col-md-12 mb-5">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Nama Anggota</th>
                                        <th class="border-bottom-0">Pekerjaan</th>
                                        <th class="border-bottom-0">Hasil</th>
                                        <th class="border-bottom-0">Action</th>
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
                                                            data-bs-placeholder="Pilih Nama Anggota">
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
                                                            wire:model="anggota.{{ $index }}.pekerjaan_per_anggota"
                                                            class="form-control" autocomplete="off"
                                                            placeholder="Pekerjaan">
                                                    </div>
                                                    @error('anggota.' . $index . '.pekerjaan_per_anggota')
                                                        <div><span class="text-danger">{{ $message }}</span></div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            wire:model="anggota.{{ $index }}.hasil"
                                                            class="form-control" autocomplete="off" placeholder="Hasil">
                                                    </div>
                                                    @error('anggota.' . $index . '.hasil')
                                                        <div><span class="text-danger">{{ $message }}</span></div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="removeAnggota({{ $index }})"><i
                                                        class="fe fe-x"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success mb-0"
                                                    wire:click="addAnggota">Tambah Anggota</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <div class="input-group">
                                    <input type="text" wire:model="jenis_pekerjaan" id="jenis_pekerjaan"
                                        class="form-control" autocomplete="off" placeholder="Jenis Pekerjaan" disabled>
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
                                        autocomplete="off" placeholder="Hasil Akhir">
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
                                    <input type="text" wire:model="jumlah_barang_gagal" id="jumlah_barang_gagal"
                                        class="form-control" autocomplete="off" placeholder="Jumlah Barang Gagal">
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
                                        data-bs-placeholder="Pilih Satuan">
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
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Catatan Proses Pengerjaan</label>
                            <div class="input-group control-group" style="padding-top: 5px;">
                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <div class="form-group">
                                        <label class="form-label mb-3">Catatan</label>
                                        <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i
                                                class="fe fe-plus"></i>Tambah
                                            Catatan</button>
                                    </div>

                                    @foreach ($notes as $index => $note)
                                        <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <select class="form-control form-select"
                                                            data-bs-placeholder="Pilih Tujuan Catatan"
                                                            wire:model="notes.{{ $index }}.tujuan">
                                                            <option label="Pilih Tujuan Catatan"></option>
                                                            <option value="semua">Semua</option>
                                                            @foreach ($workSteps as $key)
                                                                <option value="{{ $key['work_step_list_id'] }}">
                                                                    {{ $key['workStepList']['name'] }}</option>
                                                            @endforeach

                                                        </select>
                                                        <button class="btn btn-danger" type="button"
                                                            wire:click="removeNote({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    </div>
                                                    @error('notes.' . $index . '.tujuan')
                                                        <p class="mt-2 text-sm text-danger">{{ $message }}
                                                        </p>
                                                    @enderror

                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                            wire:model="notes.{{ $index }}.catatan" required></textarea>
                                                    </div>
                                                    @error('notes.' . $index . '.catatan')
                                                        <p class="mt-2 text-sm text-danger">{{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn"
                        wire:click="save" wire:ignore.self>Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
