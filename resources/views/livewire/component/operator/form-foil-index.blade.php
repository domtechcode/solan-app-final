<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Foil1</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">KETERANGAN PLATE</th>
                                        <th class="border-bottom-0">PLATE</th>
                                        <th class="border-bottom-0">JUMLAH LEMBAR CETAK</th>
                                        <th class="border-bottom-0">WASTE</th>
                                        <th class="border-bottom-0">HASIL AKHIR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($dataHasilAkhir))
                                        <?php
                                        $totalLembarCetakHasilAkhir = 0;
                                        ?>
                                        @foreach ($dataHasilAkhir as $key => $rincianPlate)
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataHasilAkhir.{{ $key }}.state"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="State" readonly>
                                                        </div>
                                                        @error('dataHasilAkhir.' . $key . '.state')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataHasilAkhir.{{ $key }}.plate"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Plate" readonly>
                                                        </div>
                                                        @error('dataHasilAkhir.' . $key . '.plate')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataHasilAkhir.{{ $key }}.jumlah_lembar_cetak"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Jumlah Lembar Cetak" readonly>
                                                        </div>
                                                        @error('dataHasilAkhir.' . $key . '.jumlah_lembar_cetak')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataHasilAkhir.{{ $key }}.waste"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Waste" readonly>
                                                        </div>
                                                        @error('dataHasilAkhir.' . $key . '.waste')
                                                            <div><span class="text-danger">{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                wire:model="dataHasilAkhir.{{ $key }}.hasil_akhir_lembar_cetak_plate"
                                                                class="form-control" autocomplete="off"
                                                                placeholder="Hasil Akhir">
                                                        </div>
                                                        @error('dataHasilAkhir.' . $key .
                                                            '.hasil_akhir_lembar_cetak_plate')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $totalLembarCetak = $dataHasilAkhir[$key]['hasil_akhir_lembar_cetak_plate'];

                                            if (is_numeric($totalLembarCetak)) {
                                                $totalLembarCetakHasilAkhir += $totalLembarCetak;
                                            } else {
                                                $totalLembarCetakHasilAkhir = 0;
                                            }

                                            ?>
                                        @endforeach
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td>{{ $totalLembarCetakHasilAkhir }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="3">No data available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Total Hasil Akhir</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir" id="hasil_akhir" class="form-control"
                                        autocomplete="off" placeholder="Hasil Akhir">
                                </div>
                                @error('hasil_akhir')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Nama Matress</label>
                                <div class="input-group">
                                    <input type="text" wire:model="nama_matress" id="nama_matress"
                                        class="form-control" autocomplete="off" placeholder="Nama Matress">
                                </div>
                                @error('nama_matress')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Lokasi Matress</label>
                                <div class="input-group">
                                    <input type="text" wire:model="lokasi_matress" id="lokasi_matress"
                                        class="form-control" autocomplete="off" placeholder="Lokasi Matress">
                                </div>
                                @error('lokasi_matress')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Status Matress</label>
                                <div class="input-group">
                                    <select wire:model="status_matress" id="type_ppn" class="form-control form-select"
                                        data-bs-placeholder="Pilih Status Matress">
                                        <option label="-- Pilih Status Pisau --"></option>
                                        <option value="Baru">Baru</option>
                                        <option value="Repeat">Repeat</option>
                                    </select>
                                </div>
                                @error('status_matress')
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
