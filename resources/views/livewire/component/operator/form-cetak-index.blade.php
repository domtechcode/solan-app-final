<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Cetak</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Plate</th>
                                        <th class="border-bottom-0">Name</th>
                                        <th class="border-bottom-0">Warna</th>
                                        <th class="border-bottom-0">KETERANGAN</th>
                                        <th class="border-bottom-0">DE</th>
                                        <th class="border-bottom-0">L</th>
                                        <th class="border-bottom-0">a</th>
                                        <th class="border-bottom-0">b</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($dataWarna['rincianPlate']))
                                        @foreach ($dataWarna['rincianPlate'] as $key => $rincianPlate)
                                            <tr>
                                                <td>{{ $rincianPlate['plate'] }}</td>
                                                <td>{{ $rincianPlate['name'] }}</td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Warna"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.warna"
                                                                    disabled>
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.warna')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Warna"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.keterangan"
                                                                    disabled>
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.keterangan')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="DE"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.de">
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.de')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="L"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.l">
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.l')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="a"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.a">
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.a')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($rincianPlate['warnaCetak']))
                                                        @foreach ($rincianPlate['warnaCetak'] as $index => $warnaCetak)
                                                            <div class="form-group">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="b"
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.b">
                                                                @error('dataWarna.' . $key . '.warnaCetak.' . $index .
                                                                    '.b')
                                                                    <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No data available.</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Hasil Akhir Lembar Cetak</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir_lembar_cetak"
                                        id="hasil_akhir_lembar_cetak" class="form-control" autocomplete="off"
                                        placeholder="Hasil Akhir Lembar Cetak">
                                </div>
                                @error('hasil_akhir_lembar_cetak')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Keseluruhan DE Lab</label>
                            <div class="row">
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" wire:model="de" id="de" class="form-control"
                                                autocomplete="off" placeholder="DE">
                                        </div>
                                        @error('de')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" wire:model="l" id="l" class="form-control"
                                                autocomplete="off" placeholder="L">
                                        </div>
                                        @error('l')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" wire:model="a" id="a" class="form-control"
                                                autocomplete="off" placeholder="a">
                                        </div>
                                        @error('a')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" wire:model="b" id="b" class="form-control"
                                                autocomplete="off" placeholder="b">
                                        </div>
                                        @error('b')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
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
                                                class="fe fe-plus"></i>Tambah Catatan</button>
                                    </div>

                                    @forelse ($notes as $index => $note)
                                        <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <select class="form-control form-select"
                                                            data-bs-placeholder="Pilih Tujuan Catatan"
                                                            wire:model.defer="notes.{{ $index }}.tujuan"
                                                            required>
                                                            <option label="Pilih Tujuan Catatan"></option>
                                                            @foreach ($workSteps as $key)
                                                                <option value="{{ $key['work_step_list_id'] }}">
                                                                    {{ $key['workStepList']['name'] }}</option>
                                                            @endforeach

                                                        </select>
                                                        <button class="btn btn-danger" type="button"
                                                            wire:click="removeNote({{ $index }})"><i
                                                                class="fe fe-x"></i></button>
                                                    </div>
                                                    <div class="input-group control-group" style="padding-top: 5px;">
                                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                            wire:model.defer="notes.{{ $index }}.catatan" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty

                                    @endforelse
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
