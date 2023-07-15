@push('styles')
    <style>
        .canvas-container {
            border: 1px solid #000;
            /* margin-bottom: 20px; */
        }
    </style>
@endpush
<div>
    {{-- Do your work, then step back. --}}

    <form wire:submit.prevent="save">
        @foreach ($layoutSettings as $index => $setting)
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            <h3 class="card-title">Layout Setting - {{ $index }}</h3>
                            <div class="card-options">
                                <div class="btn-list">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeFormSetting({{ $index }})"><i class="fe fe-minus"></i>
                                        Delete Form Layout Setting</button>
                                    <button type="button" class="btn btn-sm btn-success" wire:click="addFormSetting"
                                        wire:loading.attr="disabled"><i class="fe fe-plus"></i> Add Form Layout
                                        Setting</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Shape</h3>
                                            <div class="btn-list">
                                                <button type="button" class="btn btn-sm btn-dark"
                                                    onclick="addRectangle({{ $index }})">Rectangle</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="addText({{ $index }})">Text</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="addLine({{ $index }})">Line</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Action</h3>
                                            <div class="btn-list">
                                                <button type="button" class="btn btn-sm btn-dark"
                                                    onclick="copy({{ $index }})">Copy</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="paste({{ $index }})">Paste</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="deleteObjects({{ $index }})">Delete</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-success save-canvas-setting"
                                                    onclick="exportCanvas({{ $index }})"
                                                    style="display: none;">Export</button>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="addCanvas({{ $index }})">Create Canvas</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="canvas-wrapper-{{ $index }}" wire:ignore></div>
                            @error('layoutSettings.' . $index . '.dataURL')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('layoutSettings.' . $index . '.dataJSON')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" wire:model="layoutSettings.{{ $index }}.dataURL"
                                id="dataURL-{{ $index }}">
                            <input type="hidden" wire:model="layoutSettings.{{ $index }}.dataJSON"
                                id="dataJSON-{{ $index }}">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Details Layout Setting - {{ $index }}</h3>
                                            <div class="form-row">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Ukuran Barang Jadi (P x L)
                                                            (cm)
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Panjang"
                                                                    wire:model="layoutSettings.{{ $index }}.panjang_barang_jadi">
                                                                @error('layoutSettings.' . $index .
                                                                    '.panjang_barang_jadi')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label class="form-label text-center">X</label>
                                                            </div>
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Lebar"
                                                                    wire:model="layoutSettings.{{ $index }}.lebar_barang_jadi">
                                                                @error('layoutSettings.' . $index .
                                                                    '.lebar_barang_jadi')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Ukuran Bahan Cetak (P x L)
                                                            (cm)</label>
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Panjang"
                                                                    wire:model="layoutSettings.{{ $index }}.panjang_bahan_cetak">
                                                                @error('layoutSettings.' . $index .
                                                                    '.panjang_bahan_cetak')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label class="form-label text-center">X</label>
                                                            </div>
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Lebar"
                                                                    wire:model="layoutSettings.{{ $index }}.lebar_bahan_cetak">
                                                                @error('layoutSettings.' . $index .
                                                                    '.lebar_bahan_cetak')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW-2 END -->
        @endforeach


        @foreach ($keterangans as $keteranganIndex => $keterangan)
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-warning br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            <h3 class="card-title">Form Keterangan Bahan - {{ $keteranganIndex }}</h3>
                            <div class="card-options">
                                <div class="btn-list">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeFormKeterangan({{ $keteranganIndex }})"><i
                                            class="fe fe-minus"></i> Delete Form Keterangan Bahan</button>
                                    <button type="button" class="btn btn-sm btn-success"
                                        wire:click="addFormKeterangan({{ $keteranganIndex }})"><i
                                            class="fe fe-plus"></i>
                                        Add Form Keterangan Bahan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Plate</h3>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.0.state"
                                                            class="custom-switch-input" value="baru">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Baru</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.0.jumlah_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.0.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.0.jumlah_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.0.ukuran_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.0.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.0.ukuran_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.1.state"
                                                            class="custom-switch-input" value="repeat">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Repeat</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.1.jumlah_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.1.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.1.jumlah_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.1.ukuran_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.1.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.1.ukuran_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.2.state"
                                                            class="custom-switch-input" value="sample">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Sample</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.2.jumlah_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.2.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.2.jumlah_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran Plate"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.2.ukuran_plate"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.2.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.2.ukuran_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Pond</h3>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.0.state"
                                                            class="custom-switch-input" value="baru">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Baru</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Pisau"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.0.jumlah_pisau"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.0.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.pond.0.jumlah_pisau')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.1.state"
                                                            class="custom-switch-input" value="repeat">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Repeat</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Pisau"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.1.jumlah_pisau"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.1.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.pond.1.jumlah_pisau')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.2.state"
                                                            class="custom-switch-input" value="sample">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Sample</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah Pisau"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.2.jumlah_pisau"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.2.state')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.pond.2.jumlah_pisau')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">File Rincian</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">File Rincian</label>
                                                        <x-forms.filepond
                                                            wire:model="keterangans.{{ $keteranganIndex }}.fileRincian"
                                                            multiple allowImagePreview imagePreviewMaxHeight="200"
                                                            allowFileTypeValidation allowFileSizeValidation
                                                            maxFileSize="1024mb" />

                                                        @error('keterangans.' . $keteranganIndex . '.fileRincian')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <div class="row">
                                                <div class="col">
                                                    <h3 class="card-title">Rincian Plate</h3>
                                                </div>
                                                <div class="col d-flex justify-content-end">
                                                    <button class="btn btn-sm btn-success" type="button"
                                                        wire:click="addRincianPlate({{ $keteranganIndex }})">Add
                                                        Rincian Plate</button>
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
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndex => $rincian)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <select
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndex }}.state"
                                                                            class="form-control form-select"
                                                                            data-bs-placeholder="Pilih View">
                                                                            <option label="-- Pilih View --"></option>
                                                                            <option value="depan/belakang">
                                                                                Depan/Belakang</option>
                                                                            <option value="depan">Depan</option>
                                                                            <option value="tengah">Tengah</option>
                                                                            <option value="belakang">Belakang
                                                                            </option>
                                                                        </select>
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndex . '.state')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control" placeholder="Plate"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndex }}.plate">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndex . '.plate')
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndex }}.jumlah_lembar_cetak">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndex .
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndex }}.waste">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndex . '.waste')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group input-group control-group">
                                                                        <button class="btn btn-primary" type="button"
                                                                            wire:click="removeRincianPlate({{ $index }}, {{ $rincianIndex }})"><i
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

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <div class="form-row">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Catatan</label>
                                                        <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.notes"></textarea>
                                                        @error('keterangans.' . $keteranganIndex . '.notes')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-4 mb-0" id="submitBtn">Submit</button>
    </form>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/fabricjs/fabric.js') }}"></script>
    <script src="{{ asset('assets/plugins/fabricjs/centering_guidelines.js') }}"></script>
    <script src="{{ asset('assets/plugins/fabricjs/aligning_guidelines.js') }}"></script>

    <script>
        //   var canvasId = 0;
        var canvases = {};

        function addCanvas(index) {
            var canvasContainer = document.createElement('div');
            canvasContainer.id = 'canvas-container-' + index;
            canvasContainer.classList.add('canvas-container');

            var canvasWrapper = document.getElementById('canvas-wrapper-' + index);
            canvasWrapper.appendChild(canvasContainer);

            // Buat elemen <canvas> baru
            var canvasElement = document.createElement('canvas');
            canvasElement.id = 'canvas-' + index;
            canvasElement.width = canvasWrapper.offsetWidth; // Atur lebar sesuai dengan lebar canvas-wrapper
            canvasElement.height = canvasWrapper.offsetWidth / 1.5; // Atur tinggi sesuai kebutuhan

            // Tambahkan elemen <canvas> ke dalam wrapper
            // canvasWrapper.appendChild(canvasElement);
            canvasContainer.appendChild(canvasElement);

            // Inisialisasi objek canvas menggunakan Fabric.js
            var canvas = new fabric.Canvas('canvas-' + index, {
                snapAngle: 45,
                guidelines: true,
                snapToGrid: 10,
                snapToObjects: true
            });

            // Tambahkan kode logika lainnya di sini, seperti menambahkan objek atau event listener

            console.log('Canvas created:', canvas);
            canvases[canvasContainer.id] = canvas;
            initCenteringGuidelines(canvas);
            initAligningGuidelines(canvas);
        }

        function addRectangle(index) {
            var currentCanvas = getCurrentCanvas(index);
            var rect = new fabric.Rect({
                left: 50,
                top: 50,
                width: 100,
                height: 100,
                fill: 'transparent',
                stroke: 'black',
                strokeWidth: 2,
                snapAngle: 15,
                snapThreshold: 10,
                snapToGrid: 10,
                strokeUniform: true
            });
            currentCanvas.add(rect);
        }

        function addText(index) {
            var currentCanvas = getCurrentCanvas(index);
            var text = new fabric.Textbox('Sample Text', {
                left: 50,
                top: 50,
                width: 200,
                fontSize: 20,
                fontFamily: 'Arial',
                fill: 'black',
                snapAngle: 15,
                snapThreshold: 10,
                snapToGrid: 10,
                strokeUniform: true
            });
            currentCanvas.add(text);
        }

        function addLine(index) {
            var currentCanvas = getCurrentCanvas(index);
            var line = new fabric.Line([50, 50, 200, 200], {
                fill: 'black',
                stroke: 'black',
                strokeWidth: 2,
                snapAngle: 15,
                snapThreshold: 10,
                snapToGrid: 10,
                strokeUniform: true
            });
            currentCanvas.add(line);
        }

        function copy(index) {
            var currentCanvas = getCurrentCanvas(index);
            var activeObject = currentCanvas.getActiveObject();
            if (activeObject) {
                activeObject.clone(function(cloned) {
                    currentCanvas.clipboard = cloned;
                });
            }
        }

        function paste(index) {
            var currentCanvas = getCurrentCanvas(index);
            if (currentCanvas.clipboard) {
                currentCanvas.clipboard.clone(function(clonedObj) {
                    currentCanvas.discardActiveObject();
                    clonedObj.set({
                        left: clonedObj.left + 10,
                        top: clonedObj.top + 10,
                        evented: true,
                    });
                    if (clonedObj.type === 'activeSelection') {
                        clonedObj.canvas = currentCanvas;
                        clonedObj.forEachObject(function(obj) {
                            currentCanvas.add(obj);
                        });
                        clonedObj.setCoords();
                    } else {
                        currentCanvas.add(clonedObj);
                    }
                    currentCanvas.clipboard.top += 100;
                    currentCanvas.clipboard.left += 100;
                    currentCanvas.setActiveObject(clonedObj);
                    currentCanvas.requestRenderAll();
                });
            }
        }

        function deleteObjects(index) {
            var currentCanvas = getCurrentCanvas(index);
            var activeObject = currentCanvas.getActiveObject();
            if (activeObject) {
                if (activeObject.type === 'activeSelection') {
                    activeObject.forEachObject(function(obj) {
                        currentCanvas.remove(obj);
                    });
                } else {
                    currentCanvas.remove(activeObject);
                }
                currentCanvas.discardActiveObject();
                currentCanvas.requestRenderAll();
            }
        }

        function exportCanvas(index) {
            var currentCanvas = getCurrentCanvas(index);
            if (currentCanvas) {
                var dataURL = currentCanvas.toDataURL();
                var dataJSON = currentCanvas.toJSON();
                delete dataJSON.version;
                var dataJSON = JSON.stringify(dataJSON);
                @this.set('layoutSettings.' + index + '.dataURL', dataURL);
                @this.set('layoutSettings.' + index + '.dataJSON', dataJSON);
            }
        }

        function getCurrentCanvas(index) {
            var currentCanvasId = 'canvas-container-' + index;
            return canvases[currentCanvasId];
        }

        document.getElementById("submitBtn").addEventListener("click", function(event) {
            var allCanvasButtons = document.querySelectorAll(".save-canvas-setting");
            allCanvasButtons.forEach(function(button) {
                button.click();
            });

            // var allCanvasButtonsBahan = document.querySelectorAll(".save-canvas-bahan");
            // allCanvasButtonsBahan.forEach(function(button) {
            //     button.click();
            // });

            // // Submit form after all buttons are clicked
            // document.getElementById("the-form").submit();
        });
    </script>
@endpush
