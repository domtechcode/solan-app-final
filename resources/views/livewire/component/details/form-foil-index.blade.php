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
                                                                placeholder="Hasil Akhir" readonly>
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
                                        autocomplete="off" placeholder="Hasil Akhir" readonly>
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
                                        class="form-control" autocomplete="off" placeholder="Nama Matress" readonly>
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
                                        class="form-control" autocomplete="off" placeholder="Lokasi Matress" readonly>
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
                                        data-bs-placeholder="Pilih Status Matress" readonly>
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
