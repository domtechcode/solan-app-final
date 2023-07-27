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

    @foreach ($note as $datanote)
    @if (isset($datanote))
        <div class="row row-sm mb-5">
            <div class="text-wrap">
                <div class="">
                    <div class="alert alert-info">
                        <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24"><path fill="#70a9ee" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"/><circle cx="12" cy="17" r="1" fill="#1170e4"/><path fill="#1170e4" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"/></svg></span>
                        <strong>Catatan Dari Operator : {{ $datanote->user->name }}</strong>
                        <hr class="message-inner-separator">
                        <p>{{ $datanote->catatan }}</p>
                        <div class="d-flex justify-content-end">
                            <small>{{ $datanote->created_at }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endforeach

    @foreach ($notereject as $datanotereject)
    @if (isset($datanotereject))
        <div class="row row-sm mb-5">
            <div class="text-wrap">
                <div class="">
                    <div class="alert alert-danger">
                        <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24"><path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"/><circle cx="12" cy="17" r="1" fill="#e62a45"/><path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"/></svg></span>
                        <strong>Catatan Reject Dari Operator : {{ $datanotereject->user->name }}</strong>
                        <hr class="message-inner-separator">
                        <p>{{ $datanotereject->catatan }}</p>
                        <div class="d-flex justify-content-end">
                            <small>{{ $datanotereject->created_at }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endforeach

    <!-- ROW-1 Data Order-->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Data Order</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">No SPK</th>
                                        <th class="border-bottom-0">Type SPK</th>
                                        <th class="border-bottom-0">Pemesan</th>
                                        <th class="border-bottom-0">Order</th>
                                        <th class="border-bottom-0">No Po</th>
                                        <th class="border-bottom-0">Style</th>
                                        <th class="border-bottom-0">TGL Masuk</th>
                                        <th class="border-bottom-0">TGL Kirim</th>
                                        <th class="border-bottom-0">Total Qty</th>
                                        <th class="border-bottom-0">Price</th>
                                        <th class="border-bottom-0">Follow Up</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_qty = 0;
                                    @endphp
                                    @foreach ($instructionData as $key => $instruction)
                                    <tr>
                                        <td>
                                            {{ $instruction->spk_number }}
                                            @if($instruction->spk_number_fsc)
                                                <span class="tag tag-border">{{ $instruction->spk_number_fsc }}</span>
                                            @endif
        
                                            @if($instruction->group_id)
                                                <button class="btn btn-icon btn-sm btn-info" wire:click="modalInstructionDetailsGroup({{ $instruction->group_id }})">Group-{{ $instruction->group_id }}</button>
                                            @endif
                                        </td>
                                        <td>{{ $instruction->spk_type }}</td>
                                        <td>{{ $instruction->customer_name }}</td>
                                        <td>{{ $instruction->order_name }}</td>
                                        <td>{{ $instruction->customer_number }}</td>
                                        <td>{{ $instruction->code_style }}</td>
                                        <td>{{ $instruction->order_date }}</td>
                                        <td>{{ $instruction->shipping_date }}</td>
                                        <td>{{ currency_idr($instruction->quantity - $instruction->stock) }}</td>
                                        <td>{{ $instruction->price }}</td>
                                        <td>{{ $instruction->follow_up }}</td>
                                        <td>
                                            <div class="btn-list">         
                                                <button class="btn btn-icon btn-sm btn-dark" wire:click="modalInstructionDetails({{ $instruction->id }})"><i class="fe fe-eye"></i></button>
                                            </div>
                                        </td>
                                        @php
                                            $total_qty += $instruction->quantity - $instruction->stock;
                                        @endphp
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total Qty</strong></td>
                                        <td><strong>{{ currency_idr($total_qty) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW-1 Contoh Gambar-->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Contoh Gambar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex text-center">
                            <ul>
                                @if ($contohData)
                                    @foreach ($contohData as $file)
                                        <li class="mb-3">
                                            <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <p>No files found.</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="update">
        @foreach ($layoutSettings as $indexSetting => $setting)
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            <h3 class="card-title">Layout Setting - {{ $indexSetting }}</h3>
                            <div class="col-lg-3 col-md-3 col-xl-3">
                                <select wire:model="layoutSettings.{{ $indexSetting }}.state"
                                    class="form-control form-select" data-bs-placeholder="Pilih View">
                                    <option label="-- Pilih View --"></option>
                                    <option value="depan/belakang">Depan/Belakang</option>
                                    <option value="depan">Depan</option>
                                    <option value="tengah">Tengah</option>
                                    <option value="belakang">Belakang</option>
                                </select>
                                
                            </div>
                            @error('layoutSettings.' . $indexSetting .'.state')
                                    <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="card-options">
                                <div class="btn-list">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeFormSetting({{ $indexSetting }})"><i class="fe fe-minus"></i>
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
                                                    onclick="addRectangleSetting({{ $indexSetting }})">Rectangle</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="addTextSetting({{ $indexSetting }})">Text</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="addLineSetting({{ $indexSetting }})">Line</button>
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
                                                    onclick="copySetting({{ $indexSetting }})">Copy</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="pasteSetting({{ $indexSetting }})">Paste</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="deleteObjectsSetting({{ $indexSetting }})">Delete</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-success save-canvas-setting"
                                                    onclick="exportCanvasSetting({{ $indexSetting }})"
                                                    style="display: none;">Export</button>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="addCanvasSetting({{ $indexSetting }})">Create & Edit Canvas</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="canvas-wrapper-setting-{{ $indexSetting }}" wire:ignore></div>
                            @error('layoutSettings.' . $indexSetting . '.dataURL')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('layoutSettings.' . $indexSetting . '.dataJSON')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" wire:model="layoutSettings.{{ $indexSetting }}.dataURL"
                                id="dataURL-{{ $indexSetting }}">
                            <input type="hidden" wire:model="layoutSettings.{{ $indexSetting }}.dataJSON"
                                id="dataJSON-{{ $indexSetting }}">
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="text-wrap">
                                            <div class="example">
                                                <h3 class="card-title">Details Layout Setting - {{ $indexSetting }}</h3>
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
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.panjang_barang_jadi">
                                                                    @error('layoutSettings.' . $indexSetting .
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
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.lebar_barang_jadi">
                                                                    @error('layoutSettings.' . $indexSetting .
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
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.panjang_bahan_cetak">
                                                                    @error('layoutSettings.' . $indexSetting .
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
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.lebar_bahan_cetak">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.lebar_bahan_cetak')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Panjang Naik</label>
                                                            <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Panjang Naik"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.panjang_naik">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.panjang_naik')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Lebar Naik</label>
                                                            <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Lebar Naik"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.lebar_naik">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.lebar_naik')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jarak Panjang (cm)</label>
                                                            <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Jarak Panjang"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.jarak_panjang">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.jarak_panjang')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jarak Lebar (cm)</label>
                                                            <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Jarak Lebar"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.jarak_lebar">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.jarak_lebar')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Sisi Atas & Bawah
                                                                (cm)</label>
                                                            <div class="row">
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Sisi Atas"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.sisi_atas">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.sisi_atas')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <label class="form-label text-center">&</label>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Sisi Bawah"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.sisi_bawah">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.sisi_bawah')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Sisi Kiri & Kanan
                                                                (cm)</label>
                                                            <div class="row">
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Sisi Kiri"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.sisi_kiri">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.sisi_kiri')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <label class="form-label text-center">&</label>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Sisi Kanan"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.sisi_kanan">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.sisi_kanan')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Jarak Tambahan (Vertical & Horizontal)
                                                                (cm)</label>
                                                            <div class="row">
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Jarak Tambahan Vertical"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.jarak_tambahan_vertical">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.jarak_tambahan_vertical')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <label class="form-label text-center">&</label>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <input type="text" autocomplete="off"
                                                                        class="form-control" placeholder="Jarak Tambahan Horizontal"
                                                                        wire:model="layoutSettings.{{ $indexSetting }}.jarak_tambahan_horizontal">
                                                                    @error('layoutSettings.' . $indexSetting .
                                                                        '.jarak_tambahan_horizontal')
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
                            @if(!isset($stateWorkStepCetakLabel))
                            <h3 class="card-title">Form Keterangan Bahan - {{ $keteranganIndex }}</h3>
                            @else
                            <h3 class="card-title">Form Keterangan Bahan Label - {{ $keteranganIndex }}</h3>
                            @endif
                            <div class="card-options">
                                <div class="btn-list">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeFormKeterangan({{ $keteranganIndex }})"><i
                                            class="fe fe-minus"></i> Delete Form Keterangan Bahan</button>
                                    <button type="button" class="btn btn-sm btn-success"
                                        wire:click="addFormKeterangan({{ $keteranganIndex }})"><i class="fe fe-plus"></i>
                                        Add Form Keterangan Bahan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                @if(isset($stateWorkStepPlate) && !isset($stateWorkStepCetakLabel))
                                <div class="col-lg-6 mb-3">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Plate</h3>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.0.state_plate"
                                                            class="custom-switch-input" value="baru" {{ data_get($keterangans, $keteranganIndex . '.plate.0.state_plate') === 'baru' ? 'checked' : '' }}>
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.0.state_plate')) ? 'disabled' : '' }}>
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.0.state_plate')) ? 'disabled' : '' }}>
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
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.1.state_plate"
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.1.state_plate')) ? 'disabled' : '' }}>
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.1.state_plate')) ? 'disabled' : '' }}>
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
                                                            wire:model="keterangans.{{ $keteranganIndex }}.plate.2.state_plate"
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.2.state_plate')) ? 'disabled' : '' }}>
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.plate.2.state_plate')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.plate.2.ukuran_plate')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @error('keterangans.' . $keteranganIndex .'.plate')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($stateWorkStepSablon) && !isset($stateWorkStepCetakLabel))
                                <div class="col-lg-6 mb-3">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Screen</h3>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.0.state_screen"
                                                            class="custom-switch-input" value="baru">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Baru</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.0.jumlah_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.0.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.0.jumlah_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.0.ukuran_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.0.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.0.ukuran_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.1.state_screen"
                                                            class="custom-switch-input" value="repeat">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Repeat</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.1.jumlah_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.1.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.1.jumlah_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.1.ukuran_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.1.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.1.ukuran_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.2.state_screen"
                                                            class="custom-switch-input" value="sample">
                                                        <span
                                                            class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                        <span class="custom-switch-description">Sample</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Jumlah screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.2.jumlah_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.2.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.2.jumlah_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" autocomplete="off" class="form-control"
                                                            placeholder="Ukuran screen"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.screen.2.ukuran_screen"
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.screen.2.state_screen')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.screen.2.ukuran_screen')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @error('keterangans.' . $keteranganIndex .'.screen')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($stateWorkStepPond) && !isset($stateWorkStepCetakLabel))
                                <div class="col-lg-6 mb-3">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Pond</h3>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="custom-switch form-switch me-5">
                                                        <input type="checkbox"
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.0.state_pisau"
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.0.state_pisau')) ? 'disabled' : '' }}>
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
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.1.state_pisau"
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.1.state_pisau')) ? 'disabled' : '' }}>
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
                                                            wire:model="keterangans.{{ $keteranganIndex }}.pond.2.state_pisau"
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
                                                            {{ empty(data_get($keterangans, $keteranganIndex . '.pond.2.state_pisau')) ? 'disabled' : '' }}>
                                                        @error('keterangans.' . $keteranganIndex .
                                                            '.pond.2.jumlah_pisau')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @error('keterangans.' . $keteranganIndex .'.pond')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">File Rincian</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <x-forms.filepond
                                                            wire:model="keterangans.{{ $keteranganIndex }}.fileRincian"
                                                            multiple allowImagePreview imagePreviewMaxHeight="200"
                                                            allowFileTypeValidation allowFileSizeValidation
                                                            acceptedFileTypes="['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']"
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
                                <div class="col-lg-6">
                                    <div class="table-responsive">
                                        <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">Nama File</th>
                                                    <th class="border-bottom-0">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($keterangan['fileRincianLast'] as $key => $file)
                                                        <tr wire:key="file-{{ $file['file_name'] }}">
                                                            <td>{{ $file['file_name'] }}</td>
                                                            <td>
                                                                <div class="btn-list">
                                                                    <button type="button" class="btn btn-icon btn-sm btn-danger"
                                                                            wire:click="deleteFileRincian('{{ $file['file_name'] }}', {{ $key }}, {{ $keteranganIndex }})"
                                                                            wire:loading.attr="disabled"
                                                                            wire:target="deleteFileRincian('{{ $file['file_name'] }}', {{ $key }}, {{ $keteranganIndex }})">
                                                                        <i class="fe fe-x"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2">No Data!</td>
                                                        </tr>
                                                    @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                                                        @foreach ($keterangan['rincianPlate'] ?? [] as $rincianIndexPlate => $rincian)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <select
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.state"
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.plate">
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.jumlah_lembar_cetak">
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianPlate.{{ $rincianIndexPlate }}.waste">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianPlate.' . $rincianIndexPlate . '.waste')
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

                            @if(isset($stateWorkStepSablon) && !isset($stateWorkStepCetakLabel))
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <div class="row">
                                                <div class="col">
                                                    <h3 class="card-title">Rincian Screen</h3>
                                                </div>
                                                <div class="col d-flex justify-content-end">
                                                    <button class="btn btn-sm btn-success" type="button"
                                                        wire:click="addRincianScreen({{ $keteranganIndex }})">Add
                                                        Rincian Screen</button>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="table-responsive">
                                                <table
                                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Keterangan Screen</th>
                                                            <th>Screen</th>
                                                            <th>Jumlah Lembar Cetak</th>
                                                            <th>Waste</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($keterangan['rincianScreen'] ?? [] as $rincianIndexScreen => $rincian)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <select
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianScreen.{{ $rincianIndexScreen }}.state"
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
                                                                            '.rincianScreen.' . $rincianIndexScreen . '.state')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" autocomplete="off"
                                                                            class="form-control" placeholder="Screen"
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianScreen.{{ $rincianIndexScreen }}.screen">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianScreen.' . $rincianIndexScreen . '.screen')
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianScreen.{{ $rincianIndexScreen }}.jumlah_lembar_cetak">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianScreen.' . $rincianIndexScreen .
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
                                                                            wire:model="keterangans.{{ $keteranganIndex }}.rincianScreen.{{ $rincianIndexScreen }}.waste">
                                                                        @error('keterangans.' . $keteranganIndex .
                                                                            '.rincianScreen.' . $rincianIndexScreen . '.waste')
                                                                            <p class="mt-2 text-sm text-danger">
                                                                                {{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group input-group control-group">
                                                                        <button class="btn btn-primary" type="button"
                                                                            wire:click="removeRincianScreen({{ $keteranganIndex }}, {{ $rincianIndexScreen }})"><i
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

        @foreach ($layoutBahans as $indexBahan => $bahan)
            <!-- ROW-2-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                        <div class="card-header">
                            <h3 class="card-title">Layout Bahan - {{ $indexBahan }}</h3>
                            <div class="col-lg-3 col-md-3 col-xl-3">
                                <select wire:model="layoutBahans.{{ $indexBahan }}.state"
                                    class="form-control form-select" data-bs-placeholder="Pilih View">
                                    <option label="-- Pilih View --"></option>
                                    <option value="depan/belakang">Depan/Belakang</option>
                                    <option value="depan">Depan</option>
                                    <option value="tengah">Tengah</option>
                                    <option value="belakang">Belakang</option>
                                </select>
                            </div>
                            @error('layoutBahans.' . $indexBahan .'.state')
                                    <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="col-xl-2">
                                <label class="custom-switch form-switch me-5">
                                    <input type="checkbox"
                                        wire:model="layoutBahans.{{ $indexBahan }}.include_belakang"
                                        class="custom-switch-input" value="Include Belakang">
                                    <span
                                        class="custom-switch-indicator custom-switch-indicator-md"></span>
                                    <span class="custom-switch-description">Include Belakang</span>
                                </label>
                            </div>
                            @error('layoutBahans.' . $indexBahan .'.include_belakang')
                                    <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="card-options">
                                <div class="btn-list">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        wire:click="removeFormBahan({{ $indexBahan }})"><i class="fe fe-minus"></i>
                                        Delete Form Layout Bahan</button>
                                    <button type="button" class="btn btn-sm btn-success" wire:click="addFormBahan"
                                        wire:loading.attr="disabled"><i class="fe fe-plus"></i> Add Form Layout
                                        Bahan</button>
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
                                                    onclick="addRectangleBahan({{ $indexBahan }})">Rectangle</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="addTextBahan({{ $indexBahan }})">Text</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="addLineBahan({{ $indexBahan }})">Line</button>
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
                                                    onclick="copyBahan({{ $indexBahan }})">Copy</button>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="pasteBahan({{ $indexBahan }})">Paste</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="deleteObjectsBahan({{ $indexBahan }})">Delete</button>
                                                <button type="button"
                                                    class="btn btn-sm btn-success save-canvas-bahan"
                                                    onclick="exportCanvasBahan({{ $indexBahan }})"
                                                    style="display: none;">Export</button>
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="addCanvasBahan({{ $indexBahan }})">Create & Edit Canvas</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="canvas-wrapper-bahan-{{ $indexBahan }}" wire:ignore></div>
                            @error('layoutBahans.' . $indexBahan . '.dataURL')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('layoutBahans.' . $indexBahan . '.dataJSON')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <input type="hidden" wire:model="layoutBahans.{{ $indexBahan }}.dataURL"
                                id="dataURL-{{ $indexBahan }}">
                            <input type="hidden" wire:model="layoutBahans.{{ $indexBahan }}.dataJSON"
                                id="dataJSON-{{ $indexBahan }}">
                            
                            @if(isset($bahan['layout_custom_file_name']))
                            <div class="d-flex text-center mt-3">
                                <ul>
                                    @if ($bahan['layout_custom_file_name'])
                                    <li class="mb-3">
                                        <div class="expanel expanel-default">
                                            <div class="expanel-body">
                                                Layout Custom |
                                            <button type="button" class="btn btn-icon btn-sm btn-danger"
                                                wire:click="deleteFileCustomLayout('{{ $bahan['layout_custom_file_name'] }}', {{ $indexBahan }})"
                                                wire:loading.attr="disabled"
                                                wire:target="deleteFileCustomLayout('{{ $bahan['layout_custom_file_name'] }}', {{ $indexBahan }})">
                                                <i class="fe fe-x"></i> Hapus Layout Custom
                                            </button>
                                            </div>
                                        </div>
                                        <div class="expanel expanel-default">
                                            <div class="expanel-body">
                                                <img class="img-responsive" src="{{ asset(Storage::url($bahan['layout_custom_path'].'/'.$bahan['layout_custom_file_name'])) }}" alt="File Contoh">
                                            </div>
                                        </div>
                                        <div class="expanel expanel-default">
                                            <div class="expanel-body">
                                                <a href="{{ asset(Storage::url($bahan['layout_custom_path'].'/'.$bahan['layout_custom_file_name'])) }}" download>{{ $bahan['layout_custom_file_name'] }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                        <p>No files found.</p>
                                    @endif
                                </ul>
                            </div>
                            @endif

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="text-wrap">
                                        <div class="example">
                                            <h3 class="card-title">Details Layout Bahan - {{ $indexBahan }}</h3>
                                            <div class="form-row">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Ukuran Plano (P x L)
                                                            (cm)
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Panjang"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.panjang_plano">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.panjang_plano')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label class="form-label text-center">X</label>
                                                            </div>
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Lebar"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.lebar_plano">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.lebar_plano')
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
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.panjang_bahan_cetak">
                                                                @error('layoutBahans.' . $indexBahan .
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
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.lebar_bahan_cetak">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.lebar_bahan_cetak')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Bahan</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Jenis Bahan"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.jenis_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.jenis_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Gramasi (gr)</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Gramasi"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.gramasi">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.gramasi')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">1 Plano</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="1 Plano"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.one_plano">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.one_plano')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <h3 class="card-title mt-3">Form Hitung Bahan - {{ $indexBahan }}</h3>
                                            <div class="form-row">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Sumber Bahan</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Sumber Bahan"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.sumber_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.sumber_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Merk Bahan</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Merk Bahan"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.merk_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.merk_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Supplier</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Supplier"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.supplier">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.supplier')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Lembar Cetak</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Jumlah Lembar Cetak"
                                                                    wire:model.defer="layoutBahans.{{ $indexBahan }}.jumlah_lembar_cetak" wire:change="calculateTotalLembarCetak({{ $indexBahan }})">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.jumlah_lembar_cetak')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Incit</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Jumlah Incit"
                                                                    wire:model.defer="layoutBahans.{{ $indexBahan }}.jumlah_incit" wire:change="calculateTotalLembarCetak({{ $indexBahan }})">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.jumlah_incit')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Total Lembar Cetak</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Total Lembar Cetak"
                                                                    wire:model.defer="layoutBahans.{{ $indexBahan }}.total_lembar_cetak">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.total_lembar_cetak')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Harga Bahan</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Harga Bahan"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.harga_bahan" type-currency="IDR">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.harga_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jumlah Bahan</label>
                                                        <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Jumlah Bahan"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.jumlah_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.jumlah_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Sisa Bahan (P x L)
                                                            (cm)</label>
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Panjang"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.panjang_sisa_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.panjang_sisa_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label class="form-label text-center">X</label>
                                                            </div>
                                                            <div class="col-sm">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control" placeholder="Lebar"
                                                                    wire:model="layoutBahans.{{ $indexBahan }}.lebar_sisa_bahan">
                                                                @error('layoutBahans.' . $indexBahan .
                                                                    '.lebar_sisa_bahan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Layout Custom</label>
                                                            <x-forms.filepond
                                                            wire:model="layoutBahans.{{ $indexBahan }}.fileLayoutCustom"
                                                            allowImagePreview imagePreviewMaxHeight="200"
                                                            allowFileTypeValidation allowFileSizeValidation
                                                            acceptedFileTypes="['image/png', 'image/jpg', 'image/jpeg']"
                                                            maxFileSize="1024mb" />

                                                        @error('layoutBahans.' . $indexBahan . '.fileLayoutCustom')
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
            <!-- ROW-2 END -->
        @endforeach



        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Catatan</h3>
                    </div>
                    <div class="card-body">
                        <div class="expanel expanel-default">
                            <div class="expanel-body">
                                <div class="form-group">
                                    <label class="form-label mb-3">Catatan</label>
                                    <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i class="fe fe-plus"></i>Tambah Catatan</button>
                                </div>
        
                                @foreach ($notes as $index => $note)
                                <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            <div class="input-group control-group" style="padding-top: 5px;">
                                                <select class="form-control form-select" data-bs-placeholder="Pilih Tujuan Catatan" wire:model.defer="notes.{{ $index }}.tujuan" required>
                                                    <option label="Pilih Tujuan Catatan"></option>
                                                    @foreach ($workSteps as $key)
                                                        <option value="{{ $key['work_step_list_id'] }}">{{ $key['workStepList']['name']  }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                                <button class="btn btn-danger" type="button" wire:click="removeNote({{ $index }})"><i class="fe fe-x"></i></button>
                                            </div>
                                            <div class="input-group control-group" style="padding-top: 5px;">
                                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model.defer="notes.{{ $index }}.catatan" required></textarea>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach
        
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0" id="submitBtn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">NO. SPK</th>
                                            <th class="border-bottom-0">PEMESAN</th>
                                            <th class="border-bottom-0">NO. PO</th>
                                            <th class="border-bottom-0">ORDER</th>
                                            <th class="border-bottom-0">CODE STYLE</th>
                                            <th class="border-bottom-0">TGL. PO MASUK</th>
                                            <th class="border-bottom-0">TGL. DIKIRIM</th>
                                            <th class="border-bottom-0">QTY</th>
                                            <th class="border-bottom-0">STOCK</th>
                                            <th class="border-bottom-0">HARGA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($selectedInstruction)
                                        <tr>
                                            <td>{{ $selectedInstruction->spk_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->customer_name ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->customer_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->order_name ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->code_style ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->order_date ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->shipping_date ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->quantity ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->stock ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->price ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">FOLLOW UP</th>
                                            <th class="border-bottom-0">TYPE SPK</th>
                                            <th class="border-bottom-0">PAJAK</th>
                                            <th class="border-bottom-0">MASTER SPK</th>
                                            <th class="border-bottom-0">SUB SPK</th>
                                            <th class="border-bottom-0">GROUP</th>
                                            <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                            <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                            <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($selectedInstruction)
                                        <tr>
                                            <td>{{ $selectedInstruction->follow_up ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_type ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->taxes_type ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_parent ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->sub_spk ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->group_id ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_layout_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_sample_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->shipping_date_first ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>LANGKAH KERJA</th>
                                            <th>TARGET SELESAI</th>
                                            <th>DIJADWALKAN</th>
                                            <th>TARGET JAM</th>
                                            <th>OPERATOR/REKANAN</th>
                                            <th>MACHINE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($selectedWorkStep)
                                            @foreach ($selectedWorkStep as $workstep)
                                                <tr>
                                                    <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                    <td>{{ $workstep->target_date ?? '-' }}</td>
                                                    <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                    <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                    <td>{{ $workstep->user->name ?? '-' }}</td>
                                                    <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- file --}}
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Contoh <hr>
                                    <div class="d-flex text-center">
                                        <ul>
                                            @if ($selectedFileContoh)
                                                @foreach ($selectedFileContoh as $file)
                                                    <li class="mb-3">
                                                        <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <p>No files found.</p>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Arsip <hr>
                                    <ul class="list-group no-margin">
                                        @if ($selectedFileArsip)
                                            @foreach ($selectedFileArsip as $file)
                                            <li class="list-group-item d-flex ps-3">
                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                            </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <p>No files found.</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            File Sample <hr>
                                            <ul class="list-group no-margin">
                                                @if ($selectedFileSample)
                                                    @foreach ($selectedFileSample as $file)
                                                    <li class="list-group-item d-flex ps-3">
                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                    </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <p>No files found.</p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Accounting<hr>
                                    <ul class="list-group no-margin">
                                        @if ($selectedFileAccounting)
                                            @foreach ($selectedFileAccounting as $file)
                                            <li class="list-group-item d-flex ps-3">
                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                            </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <p>No files found.</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            File Layout <hr>
                                            <ul class="list-group no-margin">
                                                @if ($selectedFileLayout)
                                                    @foreach ($selectedFileLayout as $file)
                                                    <li class="list-group-item d-flex ps-3">
                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                    </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <p>No files found.</p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Group-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModalGroup" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction Group</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default active">
                            <div class="panel-heading " role="tab" id="headingOne1">
                                <h4 class="panel-title">
                                    <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            {{ $selectedGroupParent->spk_number ?? '-' }} <span class="tag tag-blue">Parent</span>
                                        </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                                <div class="panel-body">
                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">NO. SPK</th>
                                                            <th class="border-bottom-0">PEMESAN</th>
                                                            <th class="border-bottom-0">NO. PO</th>
                                                            <th class="border-bottom-0">ORDER</th>
                                                            <th class="border-bottom-0">CODE STYLE</th>
                                                            <th class="border-bottom-0">TGL. PO MASUK</th>
                                                            <th class="border-bottom-0">TGL. DIKIRIM</th>
                                                            <th class="border-bottom-0">QTY</th>
                                                            <th class="border-bottom-0">STOCK</th>
                                                            <th class="border-bottom-0">HARGA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->spk_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->code_style ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->quantity ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->stock ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->price ?? '-' }}</td>
                                                        </tr>
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">FOLLOW UP</th>
                                                            <th class="border-bottom-0">TYPE SPK</th>
                                                            <th class="border-bottom-0">PAJAK</th>
                                                            <th class="border-bottom-0">MASTER SPK</th>
                                                            <th class="border-bottom-0">SUB SPK</th>
                                                            <th class="border-bottom-0">GROUP</th>
                                                            <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                                            <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                                            <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->follow_up ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->taxes_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_parent ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->sub_spk ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->group_id ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_layout_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_sample_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date_first ?? '-' }}</td>
                                                        </tr>
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>LANGKAH KERJA</th>
                                                            <th>TARGET SELESAI</th>
                                                            <th>DIJADWALKAN</th>
                                                            <th>TARGET JAM</th>
                                                            <th>OPERATOR/REKANAN</th>
                                                            <th>MACHINE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($selectedWorkStepParent)
                                                            @foreach ($selectedWorkStepParent as $workstep)
                                                                <tr>
                                                                    <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                                    <td>{{ $workstep->target_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                                    <td>{{ $workstep->user->name ?? '-' }}</td>
                                                                    <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- file --}}
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Contoh <hr>
                                                    <div class="d-flex text-center">
                                                        <ul>
                                                            @if ($selectedFileContohParent)
                                                                @foreach ($selectedFileContohParent as $file)
                                                                    <li class="mb-3">
                                                                        <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                        <div class="expanel expanel-default">
                                                                            <div class="expanel-body">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <p>No files found.</p>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Arsip <hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileArsipParent)
                                                            @foreach ($selectedFileArsipParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                            </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <p>No files found.</p>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Sample <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileSampleParent)
                                                                    @foreach ($selectedFileSampleParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Accounting<hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileAccountingParent)
                                                            @foreach ($selectedFileAccountingParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                            </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <p>No files found.</p>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Layout <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileLayoutParent)
                                                                    @foreach ($selectedFileLayoutParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $no = 2; ?>
                        @if($selectedInstructionChild)
                            @foreach ($selectedInstructionChild as $index => $data)
                            <?php $no++; ?>
                            <div class="panel panel-default mt-2">
                                <div class="panel-heading" role="tab" id="headingTwo2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse{{ $no }}" aria-expanded="false" aria-controls="collapse{{ $no }}">
    
                                                {{ $data->spk_number ?? '-' }} <span class="tag tag-red">Child</span>
                                            </a>
                                    </h4>
                                </div>
                                <div id="collapse{{ $no }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
                                        <!-- Row -->
                                        <div class="row mb-3">
                                            <div class="col-xl-12">
                                                <div class="table-responsive">
                                                    <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">NO. SPK</th>
                                                                <th class="border-bottom-0">PEMESAN</th>
                                                                <th class="border-bottom-0">NO. PO</th>
                                                                <th class="border-bottom-0">ORDER</th>
                                                                <th class="border-bottom-0">CODE STYLE</th>
                                                                <th class="border-bottom-0">TGL. PO MASUK</th>
                                                                <th class="border-bottom-0">TGL. DIKIRIM</th>
                                                                <th class="border-bottom-0">QTY</th>
                                                                <th class="border-bottom-0">STOCK</th>
                                                                <th class="border-bottom-0">HARGA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data)
                                                            <tr>
                                                                <td>{{ $data->spk_number ?? '-' }}</td>
                                                                <td>{{ $data->customer_name ?? '-' }}</td>
                                                                <td>{{ $data->customer_number ?? '-' }}</td>
                                                                <td>{{ $data->order_name ?? '-' }}</td>
                                                                <td>{{ $data->code_style ?? '-' }}</td>
                                                                <td>{{ $data->order_date ?? '-' }}</td>
                                                                <td>{{ $data->shipping_date ?? '-' }}</td>
                                                                <td>{{ $data->quantity ?? '-' }}</td>
                                                                <td>{{ $data->stock ?? '-' }}</td>
                                                                <td>{{ $data->price ?? '-' }}</td>
                                                            </tr>
                                                            @endif
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Row -->
                                        <div class="row mb-3">
                                            <div class="col-xl-12">
                                                <div class="table-responsive">
                                                    <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0">FOLLOW UP</th>
                                                                <th class="border-bottom-0">TYPE SPK</th>
                                                                <th class="border-bottom-0">PAJAK</th>
                                                                <th class="border-bottom-0">MASTER SPK</th>
                                                                <th class="border-bottom-0">SUB SPK</th>
                                                                <th class="border-bottom-0">GROUP</th>
                                                                <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                                                <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                                                <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data)
                                                            <tr>
                                                                <td>{{ $data->follow_up ?? '-' }}</td>
                                                                <td>{{ $data->spk_type ?? '-' }}</td>
                                                                <td>{{ $data->taxes_type ?? '-' }}</td>
                                                                <td>{{ $data->spk_parent ?? '-' }}</td>
                                                                <td>{{ $data->sub_spk ?? '-' }}</td>
                                                                <td>{{ $data->group_id ?? '-' }}</td>
                                                                <td>{{ $data->spk_layout_number ?? '-' }}</td>
                                                                <td>{{ $data->spk_sample_number ?? '-' }}</td>
                                                                <td>{{ $data->shipping_date_first ?? '-' }}</td>
                                                            </tr>
                                                            @endif
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Row -->
                                        <div class="row mb-3">
                                            <div class="col-xl-12">
                                                <div class="table-responsive">
                                                    <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>LANGKAH KERJA</th>
                                                                <th>TARGET SELESAI</th>
                                                                <th>DIJADWALKAN</th>
                                                                <th>TARGET JAM</th>
                                                                <th>OPERATOR/REKANAN</th>
                                                                <th>MACHINE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data->workstep)
                                                                @foreach ($data->workstep as $workstep)
                                                                    <tr>
                                                                        <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                                        <td>{{ $workstep->target_date ?? '-' }}</td>
                                                                        <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                                        <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                                        <td>{{ $workstep->user->name ?? '-' }}</td>
                                                                        <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- file --}}
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Contoh <hr>
                                                        <div class="d-flex text-center">
                                                            <ul>
                                                                @if ($data->fileArsip)
                                                                    @foreach ($data->fileArsip as $file)
                                                                    @if($file->type_file == 'contoh')
                                                                        <li class="mb-3">
                                                                            <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                            <div class="expanel expanel-default">
                                                                                <div class="expanel-body">
                                                                                    <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    <p>No files found.</p>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Arsip <hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'arsip')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    <p>No files found.</p>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                File Sample <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'sample')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                        @endforeach
                                                                    @else
                                                                        <li>
                                                                            <p>No files found.</p>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Accounting<hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'accounting')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                    </li>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <li>
                                                                    <p>No files found.</p>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                File Layout <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'layout')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                        @endforeach
                                                                    @else
                                                                        <li>
                                                                            <p>No files found.</p>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- PANEL-GROUP -->
                            @endforeach
                        @endif
                    </div>   
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/fabricjs/fabric.js') }}"></script>
    <script src="{{ asset('assets/plugins/fabricjs/centering_guidelines.js') }}"></script>
    <script src="{{ asset('assets/plugins/fabricjs/aligning_guidelines.js') }}"></script>


    <script>
        //   var canvasId = 0;
        var canvasesSetting = {};

        function addCanvasSetting(index) {
            var canvasContainer = document.createElement('div');
            canvasContainer.id = 'canvas-container-setting-' + index;
            canvasContainer.classList.add('canvas-container');

            var canvasWrapper = document.getElementById('canvas-wrapper-setting-' + index);
            canvasWrapper.appendChild(canvasContainer);

            // Buat elemen <canvas> baru
            var canvasElement = document.createElement('canvas');
            canvasElement.id = 'canvas-setting-' + index;
            canvasElement.width = canvasWrapper.offsetWidth; // Atur lebar sesuai dengan lebar canvas-wrapper
            canvasElement.height = canvasWrapper.offsetWidth / 1.5; // Atur tinggi sesuai kebutuhan

            // Tambahkan elemen <canvas> ke dalam wrapper
            // canvasWrapper.appendChild(canvasElement);
            canvasContainer.appendChild(canvasElement);

            // Inisialisasi objek canvas menggunakan Fabric.js
            var canvas = new fabric.Canvas('canvas-setting-' + index, {
                snapAngle: 45,
                guidelines: true,
                snapToGrid: 10,
                snapToObjects: true
            });

            // Tambahkan kode logika lainnya di sini, seperti menambahkan objek atau event listener

            console.log('Canvas created:', canvas);
            var dataJSON = @this.layoutSettings[index].dataJSON;
            if(dataJSON){
                canvas.loadFromJSON(JSON.parse(dataJSON), function () {
                canvas.renderAll();
            });
            canvasesSetting[canvasContainer.id] = canvas;
            initCenteringGuidelines(canvas);
            initAligningGuidelines(canvas);
            }else{
            canvasesSetting[canvasContainer.id] = canvas;
            initCenteringGuidelines(canvas);
            initAligningGuidelines(canvas);
            }
        }

        function addRectangleSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
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

        function addTextSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
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

        function addLineSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
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

        function copySetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
            var activeObject = currentCanvas.getActiveObject();
            if (activeObject) {
                activeObject.clone(function(cloned) {
                    currentCanvas.clipboard = cloned;
                });
            }
        }

        function pasteSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
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

        function deleteObjectsSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
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

        function exportCanvasSetting(index) {
            var currentCanvas = getCurrentCanvasSetting(index);
            if (currentCanvas) {
                var dataURL = currentCanvas.toDataURL();
                var dataJSON = currentCanvas.toJSON();
                delete dataJSON.version;
                var dataJSON = JSON.stringify(dataJSON);
                @this.set('layoutSettings.' + index + '.dataURL', dataURL);
                @this.set('layoutSettings.' + index + '.dataJSON', dataJSON);
            }
        }

        function getCurrentCanvasSetting(index) {
            var currentCanvasId = 'canvas-container-setting-' + index;
            return canvasesSetting[currentCanvasId];
        }
        
    </script>

    <script>
        var canvasesBahan = {};

        function addCanvasBahan(indexBahan) {
            var canvasContainer = document.createElement('div');
            canvasContainer.id = 'canvas-container-bahan-' + indexBahan;
            canvasContainer.classList.add('canvas-container');

            var canvasWrapper = document.getElementById('canvas-wrapper-bahan-' + indexBahan);
            canvasWrapper.appendChild(canvasContainer);

            // Buat elemen <canvas> baru
            var canvasElement = document.createElement('canvas');
            canvasElement.id = 'canvas-bahan-' + indexBahan;
            canvasElement.width = canvasWrapper.offsetWidth; // Atur lebar sesuai dengan lebar canvas-wrapper
            canvasElement.height = canvasWrapper.offsetWidth / 1.5; // Atur tinggi sesuai kebutuhan

            // Tambahkan elemen <canvas> ke dalam wrapper
            // canvasWrapper.appendChild(canvasElement);
            canvasContainer.appendChild(canvasElement);

            // Inisialisasi objek canvas menggunakan Fabric.js
            var canvas = new fabric.Canvas('canvas-bahan-' + indexBahan, {
                snapAngle: 45,
                guidelines: true,
                snapToGrid: 10,
                snapToObjects: true
            });

            // Tambahkan kode logika lainnya di sini, seperti menambahkan objek atau event listener

            console.log('Canvas created:', canvas);
            var dataJSON = @this.layoutBahans[indexBahan].dataJSON;
            if(dataJSON){
                canvas.loadFromJSON(JSON.parse(dataJSON), function () {
                canvas.renderAll();
            });
            canvasesBahan[canvasContainer.id] = canvas;
            initCenteringGuidelines(canvas);
            initAligningGuidelines(canvas);
            }else{
            canvasesBahan[canvasContainer.id] = canvas;
            initCenteringGuidelines(canvas);
            initAligningGuidelines(canvas);
            }
        }

        function addRectangleBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
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

        function addTextBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
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

        function addLineBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
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

        function copyBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
            var activeObject = currentCanvas.getActiveObject();
            if (activeObject) {
                activeObject.clone(function(cloned) {
                    currentCanvas.clipboard = cloned;
                });
            }
        }

        function pasteBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
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

        function deleteObjectsBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
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

        function exportCanvasBahan(indexBahan) {
            var currentCanvas = getCurrentCanvasBahan(indexBahan);
            if (currentCanvas) {
                var dataURL = currentCanvas.toDataURL();
                var dataJSON = currentCanvas.toJSON();
                delete dataJSON.version;
                var dataJSON = JSON.stringify(dataJSON);
                @this.set('layoutBahans.' + indexBahan + '.dataURL', dataURL);
                @this.set('layoutBahans.' + indexBahan + '.dataJSON', dataJSON);
            }
        }

        function getCurrentCanvasBahan(indexBahan) {
            var currentCanvasId = 'canvas-container-bahan-' + indexBahan;
            return canvasesBahan[currentCanvasId];
        }

    </script>

    
    <script>
        document.getElementById("submitBtn").addEventListener("click", function(event) {
            var allCanvasButtons = document.querySelectorAll(".save-canvas-setting");
            allCanvasButtons.forEach(function(button) {
                button.click();
            });

            var allCanvasButtonsBahan = document.querySelectorAll(".save-canvas-bahan");
            allCanvasButtonsBahan.forEach(function(button) {
                button.click();
            });

            // // Submit form after all buttons are clicked
            // document.getElementById("the-form").submit();
        });
    </script>

    <script>
        window.addEventListener('close-modal', event =>{
            $('#detailInstructionModal').modal('hide');
        });

        window.addEventListener('show-detail-instruction-modal', event =>{
            $('#detailInstructionModal').modal('show');
        });

        window.addEventListener('show-detail-instruction-modal-group', event =>{
            $('#detailInstructionModalGroup').modal('show');
        });
    </script>
@endpush
