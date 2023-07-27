<div>
    {{-- Do your work, then step back. --}}
    @if($dataInstruction->spk_type == 'layout')
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
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
                                            <a href="{{ asset(Storage::url($file['file_path'].'/'.$file['file_name'])) }}" download>{{ $file['file_name'] }}</a>
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
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">File Layout</label>
                                <x-forms.filepond
                                    wire:model="fileLayout"
                                    multiple
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    allowFileSizeValidation
                                    maxFileSize="1024mb"
                                />
            
                                @error('fileLayout') <p class="mt-2 text-sm text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Catatan Proses Pengerjaan</label>
                            <div class="input-group control-group" style="padding-top: 5px;">
                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn" wire:click="saveLayout" wire:ignore.self>Submit</button>
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
                            @if(!isset($stateWorkStepCetakLabel))
                            <h3 class="card-title">Form Setting - Keterangan Bahan - {{ $keteranganIndex }}</h3>
                            @else
                            <h3 class="card-title">Form Setting - Keterangan Bahan Label - {{ $keteranganIndex }}</h3>
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Foil"
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Foil"
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Foil"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.foil.2.jumlah_foil"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.foil.2.state_foil')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.foil.2.jumlah_foil')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @error('keterangans.' . $keteranganIndex .'.foil')
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Matress"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.matress.0.jumlah_matress"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.matress.0.state_matress')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.matress.0.jumlah_matress')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Matress"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.matress.1.jumlah_matress"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.matress.1.state_matress')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.matress.1.jumlah_matress')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
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
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Matress"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.matress.2.jumlah_matress"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.matress.2.state_matress')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.matress.2.jumlah_matress')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @error('keterangans.' . $keteranganIndex .'.matress')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if(isset($stateWorkStepPlate) && !isset($stateWorkStepCetakLabel))
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
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndexPlate => $rincian)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <select
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.state"
                                                                            class="form-control form-select"
                                                                            data-bs-placeholder="Pilih View" readonly>
                                                                            <option label="-- Pilih View --"></option>
                                                                            <option value="depan/belakang">
                                                                                Depan/Belakang</option>
                                                                            <option value="depan">Depan</option>
                                                                            <option value="tengah">Tengah</option>
                                                                            <option value="belakang">Belakang
                                                                            </option>
                                                                        </select>
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate . '.state')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control" placeholder="Plate"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.plate" readonly>
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate . '.plate')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control"
                                                                            placeholder="Jumlah Lembar Cetak"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.jumlah_lembar_cetak" readonly>
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate .
                                                                            '.jumlah_lembar_cetak')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control" placeholder="Waste"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.waste" readonly>
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate . '.waste')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control" placeholder="Nama Plate"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.name">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate . '.name')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group input-group control-group">
                                                                        <button class="btn btn-primary" type="button"
                                                                            wire:click="removeRincianPlate({{ $keteranganIndex }}, {{ $rincianIndexPlate }})"><i
                                                                                class="fe fe-x"></i></button>
                                                                    </div>
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
                            @if(isset($stateWorkStepPlate) && !isset($stateWorkStepCetakLabel))
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
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndexPlate => $rincian)
                                                        <tr>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" autocomplete="off" class="form-control" placeholder="Plate" wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.plate" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            @if (is_array($rincian) && isset($rincian['rincianWarna']))
                                                                @foreach ($rincian['rincianWarna'] as $indexwarna => $warna)
                                                                <div class="form-group">
                                                                    <div class="input-group mb-2">
                                                                        <input type="text" wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.rincianWarna.{{ $indexwarna }}.warna" class="form-control" placeholder="Warna">
                                                                        <button class="btn btn-danger" type="button" wire:click="removeWarnaField({{ $keteranganIndex }}, {{ $rincianIndexPlate }}, {{ $indexwarna }})"><i class="fe fe-trash-2"></i></button>
                                                                    </div>
                                                                    @error('keterangans.' . $keteranganIndex .'.rincianPlate.' . $rincianIndexPlate . '.rincianWarna.' . $indexwarna . '.warna') <p class="mt-2 text-sm text-danger">{{ $message }}</p> @enderror
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                            </td>
                                                            <td>
                                                                @if (is_array($rincian) && isset($rincian['rincianWarna']))
                                                                @foreach ($rincian['rincianWarna'] as $indexwarna => $warna)
                                                                <div class="form-group">
                                                                    <textarea class="form-control mb-4" placeholder="Catatan" rows="1" wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.rincianWarna.{{ $indexwarna }}.keterangan"></textarea>
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                            </td>
                                                                
                                                            <td>
                                                                <button class="btn btn-success" type="button" wire:click="addWarnaField({{ $keteranganIndex }}, {{ $rincianIndexPlate }})"><i class="fe fe-plus"></i></button>
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
        @endforeach

        <button type="submit" class="btn btn-success mt-4 mb-0 submitBtn" wire:click="saveSampleAndProduction" wire:ignore.self>Submit</button>
    <!-- ROW-2 END -->
{{--     
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
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
                                            <a href="{{ asset(Storage::url($file['file_path'].'/'.$file['file_name'])) }}" download>{{ $file['file_name'] }}</a>
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
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Catatan Proses Pengerjaan</label>
                            <div class="input-group control-group" style="padding-top: 5px;">
                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn" wire:click="saveSampleAndProduction" wire:ignore.self>Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END --> --}}

    @endif
</div>
