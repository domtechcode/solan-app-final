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
                                                                    readonly>
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
                                                                    readonly>
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
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.de" readonly>
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
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.l" readonly>
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
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.a" readonly>
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
                                                                    wire:model="dataWarna.rincianPlate.{{ $key }}.warnaCetak.{{ $index }}.b" readonly>
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

                        <div class="col-sm-12 col-md-12 mb-3">
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
                                                                placeholder="Hasil Akhir Lembar Cetak" readonly>
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

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Total Hasil Akhir Lembar Cetak</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir_lembar_cetak"
                                        id="hasil_akhir_lembar_cetak" class="form-control" autocomplete="off"
                                        placeholder="Total Hasil Akhir Lembar Cetak" readonly>
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
                                            <input type="text" wire:model="de" id="de"
                                                class="form-control" autocomplete="off" placeholder="DE" readonly>
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
                                                autocomplete="off" placeholder="L" readonly>
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
                                                autocomplete="off" placeholder="a" readonly>
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
                                                autocomplete="off" placeholder="b" readonly>
                                        </div>
                                        @error('b')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
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
