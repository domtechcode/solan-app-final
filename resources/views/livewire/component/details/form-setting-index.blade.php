<div>
    {{-- Do your work, then step back. --}}
    @if ($dataInstruction->spk_type == 'layout')
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form Setting</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table
                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">File</th>
                                                <th class="border-bottom-0">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($fileLayoutData as $file)
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset(Storage::url($file['file_path'] . '/' . $file['file_name'])) }}"
                                                            download>{{ $file['file_name'] }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $file['type_file'] }}
                                                    </td>
                                                </tr>
                                            @empty
                                                No Data !!
                                            @endforelse
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
    @else
        <!-- ROW-2-->
        @foreach ($keterangans as $keteranganIndex => $keterangan)
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-warning br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            @if (!isset($stateWorkStepCetakLabel))
                                <h3 class="card-title">Form Setting - Keterangan Bahan - {{ $keteranganIndex }}</h3>
                            @else
                                <h3 class="card-title">Form Setting - Keterangan Bahan Label - {{ $keteranganIndex }}
                                </h3>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                @if (isset($stateWorkStepFoil) && !isset($stateWorkStepCetakLabel))
                                    <div class="col-lg-6 mb-3">
                                        <div class="text-wrap">
                                            <div class="example">
                                                <h3 class="card-title">Foil</h3>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.0.state_foil"
                                                                class="custom-switch-input" value="baru">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Baru</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Foil"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.0.jumlah_foil"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.foil.0.state_foil')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.foil.0.jumlah_foil')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.1.state_foil"
                                                                class="custom-switch-input" value="repeat">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Repeat</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Foil"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.1.jumlah_foil"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.foil.1.state_foil')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.foil.1.jumlah_foil')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.2.state_foil"
                                                                class="custom-switch-input" value="sample">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Sample</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Foil"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.foil.2.jumlah_foil"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.foil.2.state_foil')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.foil.2.jumlah_foil')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('keterangans.' . $keteranganIndex . '.foil')
                                                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($stateWorkStepEmbossDeboss) && !isset($stateWorkStepCetakLabel))
                                    <div class="col-lg-6 mb-3">
                                        <div class="text-wrap">
                                            <div class="example">
                                                <h3 class="card-title">Matress Emboss/Deboss</h3>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.0.state_matress"
                                                                class="custom-switch-input" value="baru">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Baru</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Matress"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.0.jumlah_matress"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.matress.0.state_matress')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.matress.0.jumlah_matress')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.1.state_matress"
                                                                class="custom-switch-input" value="repeat">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Repeat</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Matress"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.1.jumlah_matress"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.matress.1.state_matress')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.matress.1.jumlah_matress')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="custom-switch form-switch me-5">
                                                            <input type="checkbox"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.2.state_matress"
                                                                class="custom-switch-input" value="sample">
                                                            <span
                                                                class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                            <span class="custom-switch-description">Sample</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                class="form-control" placeholder="Jumlah Matress"
                                                                wire:model="keterangans.{{ $keteranganIndex }}.matress.2.jumlah_matress"
                                                                {{ empty(data_get($keterangans, $keteranganIndex . '.matress.2.state_matress')) ? 'disabled' : '' }}>
                                                            @error('keterangans.' . $keteranganIndex .
                                                                '.matress.2.jumlah_matress')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('keterangans.' . $keteranganIndex . '.matress')
                                                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if (isset($stateWorkStepPlate))
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="text-wrap">
                                            <div class="example">
                                                <div class="row">
                                                    <div class="col">
                                                        <h3 class="card-title">Rincian Plate</h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="table-responsive">
                                                    <table
                                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Keterangan Plate</th>
                                                                <th>Plate</th>
                                                                <th>Jumlah Lembar Cetak</th>
                                                                <th>Waste</th>
                                                                <th>Nama Plate</th>
                                                                {{-- <th>Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndexPlate => $rincian)
                                                                <tr>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['state'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['plate'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['jumlah_lembar_cetak'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['waste'] }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['name'] }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isset($stateWorkStepPlate))
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="text-wrap">
                                            <div class="example">
                                                <div class="row">
                                                    <div class="col">
                                                        <h3 class="card-title">Rincian Warna Plate</h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="table-responsive">
                                                    <table
                                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Plate</th>
                                                                <th>Warna</th>
                                                                <th>Keterangan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndexPlate => $rincian)
                                                                <tr>
                                                                    <td>
                                                                        {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['plate'] }}
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        @if (is_array($rincian) && isset($rincian['rincianWarna']))
                                                                            @foreach ($rincian['rincianWarna'] as $indexwarna => $warna)
                                                                            {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'][$indexwarna]['warna'] }}
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (is_array($rincian) && isset($rincian['rincianWarna']))
                                                                            @foreach ($rincian['rincianWarna'] as $indexwarna => $warna)
                                                                            {{ $keterangans[$keteranganIndex]['rincianPlate'][$rincianIndexPlate]['rincianWarna'][$indexwarna]['keterangan'] }}
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW-2 END -->
        @endforeach

        <form wire:submit.prevent="saveSampleAndProduction" enctype="multipart/form-data">
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            <h3 class="card-title">Form Setting</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <table
                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">File</th>
                                                <th class="border-bottom-0">Keperluan</th>
                                                <th class="border-bottom-0">Ukuran Film</th>
                                                <th class="border-bottom-0">Jumlah Film</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($dataFileSetting as $file)
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset(Storage::url($file['file_path'] . '/' . $file['file_name'])) }}"
                                                            download>{{ $file['file_name'] }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $file['keperluan'] }}
                                                    </td>
                                                    <td>
                                                        {{ $file['ukuran_film'] }}
                                                    </td>
                                                    <td>
                                                        {{ $file['jumlah_film'] }}
                                                    </td>
                                                </tr>
                                            @empty
                                                No Data !!
                                            @endforelse

                                            @forelse ($fileLayoutData as $file)
                                                <tr>
                                                    <td>
                                                        <a href="{{ asset(Storage::url($file['file_path'] . '/' . $file['file_name'])) }}"
                                                            download>{{ $file['file_name'] }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $file['type_file'] }}
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                    <td>
                                                        -
                                                    </td>
                                                </tr>
                                            @empty
                                                No Data !!
                                            @endforelse
                                        </tbody>
                                    </table>
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
                                                        </td>
                                                        <td>
                                                            {{ $item->tujuan }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td>
                                                        -
                                                    </td>
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
        </form>

    @endif
</div>
