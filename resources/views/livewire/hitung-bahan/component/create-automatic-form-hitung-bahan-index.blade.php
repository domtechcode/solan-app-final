<div>

    @foreach ($note as $datanote)
        @if (isset($datanote))
            <div class="row row-sm mb-5">
                <div class="text-wrap">
                    <div class="">
                        <div class="alert alert-info">
                            <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40"
                                    viewBox="0 0 24 24">
                                    <path fill="#70a9ee"
                                        d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                    <circle cx="12" cy="17" r="1" fill="#1170e4" />
                                    <path fill="#1170e4" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                </svg></span>
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
                            <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40"
                                    viewBox="0 0 24 24">
                                    <path fill="#f07f8f"
                                        d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                    <circle cx="12" cy="17" r="1" fill="#e62a45" />
                                    <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                </svg></span>
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

    <div class="row mb-3">
        <div class="col-sm-12">
            <button type="button" class="btn btn-dark" wire:click="backBtn" wire:loading.attr="disabled"><i
                    class="fe fe-arrow-left"></i> Kembali</button>
        </div>
    </div>

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
                                        <th class="border-bottom-0">QTY Permintaan</th>
                                        <th class="border-bottom-0">Stock</th>
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
                                                @if ($instruction->spk_number_fsc)
                                                    <span
                                                        class="tag tag-border">{{ $instruction->spk_number_fsc }}</span>
                                                @endif

                                                @if ($instruction->group_id)
                                                    <button class="btn btn-icon btn-sm btn-info"
                                                        wire:click="modalInstructionDetailsGroup({{ $instruction->group_id }})">Group-{{ $instruction->group_id }}</button>
                                                @endif
                                            </td>
                                            <td>{{ $instruction->spk_type }}</td>
                                            <td>{{ $instruction->customer_name }}</td>
                                            <td>{{ $instruction->order_name }}</td>
                                            <td>{{ $instruction->customer_number }}</td>
                                            <td>{{ $instruction->code_style }}</td>
                                            <td>{{ $instruction->order_date }}</td>
                                            <td>{{ $instruction->shipping_date }}</td>
                                            <td>{{ currency_idr($instruction->quantity) }}</td>
                                            <td>{{ currency_idr($instruction->stock) }}</td>
                                            <td>{{ currency_idr($instruction->quantity - $instruction->stock) }}</td>
                                            <td>{{ $instruction->price }}</td>
                                            <td>{{ $instruction->follow_up }}</td>
                                            <td>
                                                <div class="btn-list">
                                                    <button class="btn btn-icon btn-sm btn-dark"
                                                        wire:click="modalInstructionDetails({{ $instruction->id }})"><i
                                                            class="fe fe-eye"></i></button>
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
                                            <img class="img-responsive"
                                                src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                alt="File Contoh">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                        download>{{ $file->file_name }}</a>
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Hitung</h3>
                </div>
                <div class="card-body">
                    <div class="example">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Panjang Barang Jadi</label>
                                    <div class="input-group">
                                        <input type="text" wire:model.defer="panjangBarangJadi"
                                            id="panjangBarangJadi"
                                            class="form-control @error('panjangBarangJadi') is-invalid @enderror"
                                            autocomplete="off" placeholder="Panjang Barang Jadi">
                                    </div>
                                    @error('panjangBarangJadi')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Lebar Barang Jadi</label>
                                    <div class="input-group">
                                        <input type="text" wire:model.defer="lebarBarangJadi" id="lebarBarangJadi"
                                            class="form-control @error('lebarBarangJadi') is-invalid @enderror"
                                            autocomplete="off" placeholder="Lebar Barang Jadi">
                                    </div>
                                    @error('lebarBarangJadi')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Qty</label>
                                    <div class="input-group">
                                        <input type="text" wire:model.defer="qtyPermintaan" id="qtyPermintaan"
                                            class="form-control @error('qtyPermintaan') is-invalid @enderror"
                                            autocomplete="off" placeholder="Qty">
                                    </div>
                                    @error('qtyPermintaan')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Mesin</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select wire:model.defer="mesin"
                                            class="form-control form-select @error('mesin') is-invalid @enderror"
                                            data-bs-placeholder="Pilih Mesin">
                                            <option label="-- Pilih Mesin --"></option>
                                            @foreach ($machineData as $data)
                                                <option value="{{ $data->id }}">{{ $data->machine_identity }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @error('mesin')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <label class="form-label">Pond</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="pond" name="pond"
                                                    class="custom-switch-input @error('pond') is-invalid @enderror"
                                                    value="Y">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="pond" name="pond"
                                                    class="custom-switch-input @error('pond') is-invalid @enderror"
                                                    value="N">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('pond')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <label class="form-label">Potong Jadi</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="potongJadi" name="potongJadi"
                                                    class="custom-switch-input @error('potongJadi') is-invalid @enderror"
                                                    value="Y">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="potongJadi" name="potongJadi"
                                                    class="custom-switch-input @error('potongJadi') is-invalid @enderror"
                                                    value="N">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('potongJadi')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <label class="form-label">Jarak Potong Jadi</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="jarakPotongJadi"
                                                    name="jarakPotongJadi"
                                                    class="custom-switch-input @error('jarakPotongJadi') is-invalid @enderror"
                                                    value="Y">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="jarakPotongJadi"
                                                    name="jarakPotongJadi"
                                                    class="custom-switch-input @error('jarakPotongJadi') is-invalid @enderror"
                                                    value="N">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('jarakPotongJadi')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <label class="form-label">Layout Setting</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="layoutSettingType"
                                                    name="layoutSettingType"
                                                    class="custom-switch-input @error('layoutSettingType') is-invalid @enderror"
                                                    value="Y">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Potrait</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="layoutSettingType"
                                                    name="layoutSettingType"
                                                    class="custom-switch-input @error('layoutSettingType') is-invalid @enderror"
                                                    value="N">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Landscape</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('layoutSettingType')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-8 col-md-8">
                                <label class="form-label">Layout Bahan</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="layoutBahanType"
                                                    name="layoutBahanType"
                                                    class="custom-switch-input @error('layoutBahanType') is-invalid @enderror"
                                                    value="Potrait">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Potrait</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="layoutBahanType"
                                                    name="layoutBahanType"
                                                    class="custom-switch-input @error('layoutBahanType') is-invalid @enderror"
                                                    value="Landscape">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Landscape</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model.defer="layoutBahanType"
                                                    name="layoutBahanType"
                                                    class="custom-switch-input @error('layoutBahanType') is-invalid @enderror"
                                                    value="Combination">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Potrait + Landscape</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('layoutBahanType')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-4 mb-0"
                                wire:click="generate">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-status bg-primary br-te-7 br-ts-7"></div>
            <div class="card-header">
                <h3 class="card-title">Preview</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="example">
                            <table>
                                <tr>
                                    <td><b>Landscape Layout Setting</b></td>
                                </tr>
                                <tr>
                                    <td>Panjang Barang Jadi</td>
                                    <td>= {{ $panjangBarangJadi }} cm</td>
                                </tr>
                                <tr>
                                    <td>Lebar Barang Jadi</td>
                                    <td>= {{ $lebarBarangJadi }} cm</td>
                                </tr>
                                <tr>
                                    <td>Jarak Panjang Antar Barang </td>
                                    <td>= {{ $jarakPanjangAntarBarang }} cm</td>
                                </tr>
                                <tr>
                                    <td>Panjang Naik (column count)</td>
                                    <td>= {{ $panjangNaikLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Lebar Naik (row count)</td>
                                    <td>= {{ $lebarNaikLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Ukuran Panjang Lembar Cetak</td>
                                    <td>= {{ $ukuranPanjangLembarCetakLandscape }} cm</td>
                                </tr>
                                <tr>
                                    <td>Ukuran Lebar Lembar Cetak</td>
                                    <td>= {{ $ukuranLebarLembarCetakLandscape }} cm</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="example">
                            <b>Layout Setting</b>
                            <div class="fabric-canvas-wrapper-setting">
                                <canvas id="canvasSetting"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 mt-3">
                        <div class="example">
                            <table>
                                <tr>
                                    <td>Landscape Layout Bahan</td>
                                </tr>
                                <tr>
                                    <td>Panjang Naik (column count)</td>
                                    <td>= {{ $panjangNaikBahanLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Lebar Naik (row count)</td>
                                    <td>= {{ $lebarNaikBahanLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Panjang Sisa Bahan (P)</td>
                                    <td>= {{ $panjangSisaBahanLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Lebar Sisa Bahan (L)</td>
                                    <td>= {{ $lebarBahan }}</td>
                                </tr>
                                <tr>
                                    <td>Panjang Naik Sisa Bahan Panjang</td>
                                    <td>= {{ $panjangNaikSisaBahanPanjangLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Lebar Naik Sisa Bahan Panjang</td>
                                    <td>= {{ $lebarNaikSisaBahanPanjangLandscape }}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Lebar Sisa Bahan</td>
                                    <td>= {{ $lebarSisaBahanLandscape }}</td>
                                </tr>
                                <tr>
                                    <td>Lebar Naik Sisa Bahan</td>
                                    <td>= {{ $lebarNaikSisaBahanLandscape }}</td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="example">
                            <b>Layout Bahan</b>

                            <div class="fabric-canvas-wrapper-bahan">
                                <canvas id="canvasBahan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/fabricjs/fabric.js') }}"></script>
    <script>
        Livewire.on('updateCanvasSettingLandscape', (ukuranPanjangLembarCetakLandscape, ukuranLebarLembarCetakLandscape,
            panjangBarangJadi,
            lebarBarangJadi, jarakPanjangAntarBarang, lebarNaikLandscape, panjangNaikLandscape, jarakSisiKiri,
            jarakAtas) => {
            function resizeCanvas() {
                const outerCanvasContainer = $('.fabric-canvas-wrapper-setting')[0];

                const ratio = canvas.getWidth() / canvas.getHeight();
                const containerWidth = outerCanvasContainer.clientWidth;
                const containerHeight = outerCanvasContainer.clientHeight;

                const scale = containerWidth / canvas.getWidth();
                const zoom = canvas.getZoom() * scale;
                canvas.setDimensions({
                    width: containerWidth,
                    height: containerWidth / ratio
                });
                canvas.setViewportTransform([zoom, 0, 0, zoom, 0, 0]);
            }

            $(window).resize(resizeCanvas);

            var canvas = new fabric.Canvas('canvasSetting');
            var canvasWidth = ukuranPanjangLembarCetakLandscape * 12; // Lebar canvas dalam mm
            var canvasHeight = ukuranLebarLembarCetakLandscape * 12; // Tinggi canvas dalam mm

            var panjangLembarCetak = ukuranPanjangLembarCetakLandscape * 10; // Lebar canvas dalam mm
            var lebarLembarCetak = ukuranLebarLembarCetakLandscape * 10; // Tinggi canvas dalam mm

            // Ukuran sel tabel dalam mm
            var cellWidth = panjangBarangJadi * 10; // Mengubah dari cm ke mm
            var cellHeight = lebarBarangJadi * 10; // Mengubah dari cm ke mm
            var cellSpacing = jarakPanjangAntarBarang * 10; // Mengubah dari cm ke mm
            var rowCount = lebarNaikLandscape;
            var columnCount = panjangNaikLandscape;

            var jarakSisiKiri = jarakSisiKiri;
            var jarakAtas = jarakAtas;


            // Menghitung ukuran tabel berdasarkan ukuran sel dan jarak antar sel
            var tableWidth = columnCount * cellWidth + (columnCount - 1) * cellSpacing;
            var tableHeight = rowCount * cellHeight + (rowCount - 1) * cellSpacing;

            // Mengatur ukuran canvas sesuai dengan ukuran yang diinginkan
            canvas.setWidth(canvasWidth);
            canvas.setHeight(canvasHeight);

            // Fungsi untuk membuat kotak dengan ukuran seluruh canvas dan keterangan tulisan
            function createCanvasSizeBox() {
                var box = new fabric.Rect({
                    left: 0,
                    top: 0,
                    width: panjangLembarCetak,
                    height: lebarLembarCetak,
                    fill: 'transparent',
                    stroke: 'red',
                    strokeWidth: 1,
                });

                // Tambahkan keterangan tulisan dengan ukuran lebih kecil
                var fontSize = 1.5 * 12; // Ukuran font kecil (sesuaikan sesuai keinginan)
                var textPanjang = new fabric.IText('Panjang: ' + (panjangLembarCetak / 10), {
                    left: 0,
                    top: box.height, // Geser sedikit ke atas
                    textAlign: 'center',
                    fontSize: fontSize,
                });


                var textLebar = new fabric.IText('Lebar: ' + (lebarLembarCetak / 10), {
                    left: box.width, // Geser sedikit ke kiri
                    top: lebarLembarCetak,
                    angle: -90,
                    textAlign: 'center',
                    fontSize: fontSize,
                });

                var textJarak = new fabric.IText('Jarak: ' + (jarakPanjangAntarBarang), {
                    left: 0,
                    top: box.height + fontSize, // Geser sedikit ke atas
                    textAlign: 'center',
                    fontSize: fontSize,
                });

                // Tambahkan kotak dan teks ke kanvas
                canvas.add(box);
                canvas.add(textPanjang);
                canvas.add(textLebar);
                canvas.add(textJarak);
            }

            // Fungsi untuk membuat sel tabel
            function createTableCell(x, y) {
                var cell = new fabric.Rect({
                    left: x + jarakSisiKiri * 10,
                    top: y + jarakAtas * 10,
                    width: cellWidth,
                    height: cellHeight,
                    fill: 'transparent',
                    stroke: 'black',
                    strokeWidth: 1,
                });

                var fontSize = 1.5 * 12;
                var textPanjang = new fabric.IText((cellWidth / 10) + '', {
                    left: cell.left + (cell.width / 2) - 10,
                    top: cell.top,
                    textAlign: 'center',
                    fontSize: fontSize,
                });

                var textLebar = new fabric.IText((cellHeight / 10) + '', {
                    left: cell.left + 5,
                    top: cell.top + (cell.height / 2) - 10,
                    textAlign: 'center',
                    fontSize: fontSize,
                    // angle: 0,
                });

                canvas.add(textPanjang);
                canvas.add(textLebar);
                return cell;
            }

            // Fungsi untuk membuat tabel
            function createTable() {
                for (var i = 0; i < rowCount; i++) {
                    for (var j = 0; j < columnCount; j++) {
                        var x = j * (cellWidth + cellSpacing);
                        var y = i * (cellHeight + cellSpacing);
                        var cell = createTableCell(x, y);
                        canvas.add(cell);
                    }
                }
            }
            createCanvasSizeBox();
            createTable();
            resizeCanvas();
        });
    </script>
    <script>
        Livewire.on('updateCanvasBahanLandscape', (ukuranPanjangLembarCetakLandscape, ukuranLebarLembarCetakLandscape,
            panjangBahan,
            lebarBahan, lebarNaikBahanLandscape, panjangNaikBahanLandscape, panjangNaikSisaBahanPanjangLandscape,
            lebarNaikSisaBahanPanjangLandscape) => {

            function resizeCanvas() {
                const outerCanvasContainer = $('.fabric-canvas-wrapper-bahan')[0];

                const ratio = canvas.getWidth() / canvas.getHeight();
                const containerWidth = outerCanvasContainer.clientWidth;
                const containerHeight = outerCanvasContainer.clientHeight;

                const scale = containerWidth / canvas.getWidth();
                const zoom = canvas.getZoom() * scale;
                canvas.setDimensions({
                    width: containerWidth,
                    height: containerWidth / ratio
                });
                canvas.setViewportTransform([zoom, 0, 0, zoom, 0, 0]);
            }

            $(window).resize(resizeCanvas);

            var canvas = new fabric.Canvas('canvasBahan');
            var canvasWidth = panjangBahan * 12; // Lebar canvas dalam mm
            var canvasHeight = lebarBahan * 12; // Tinggi canvas dalam mm

            var panjangBahan = panjangBahan * 10; // Lebar canvas dalam mm
            var lebarBahan = lebarBahan * 10; // Tinggi canvas dalam mm

            // Ukuran sel tabel dalam mm
            var cellWidth = ukuranPanjangLembarCetakLandscape * 10; // Mengubah dari cm ke mm
            var cellHeight = ukuranLebarLembarCetakLandscape * 10; // Mengubah dari cm ke mm
            var cellSpacing = 0; // Mengubah dari cm ke mm
            var rowCount = lebarNaikBahanLandscape;
            var columnCount = panjangNaikBahanLandscape;

            var sisaColumnPanjang = panjangNaikSisaBahanPanjangLandscape;
            var sisaRowPanjang = lebarNaikSisaBahanPanjangLandscape;

            var sisaColumnLebar = 2;
            var sisaRowLebar = 1;

            // Menghitung ukuran tabel berdasarkan ukuran sel dan jarak antar sel
            var tableWidth = columnCount * cellWidth + (columnCount - 1) * cellSpacing;
            var tableHeight = rowCount * cellHeight + (rowCount - 1) * cellSpacing;

            // Mengatur ukuran canvas sesuai dengan ukuran yang diinginkan
            canvas.setWidth(canvasWidth);
            canvas.setHeight(canvasHeight);

            // Fungsi untuk membuat kotak dengan ukuran seluruh canvas dan keterangan tulisan
            function createCanvasSizeBox() {
                var box = new fabric.Rect({
                    left: 0,
                    top: 0,
                    width: panjangBahan,
                    height: lebarBahan,
                    fill: 'transparent',
                    stroke: 'blue',
                    strokeWidth: 2,
                });
                // Tambahkan keterangan tulisan dengan ukuran lebih kecil
                var fontSize = 3 * 12; // Ukuran font kecil (sesuaikan sesuai keinginan)
                var textPanjang = new fabric.IText('Panjang: ' + panjangBahan / 10 + '', {
                    left: 0,
                    top: box.height, // Geser sedikit ke atas
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                var textLebar = new fabric.IText('Lebar: ' + lebarBahan / 10 + '', {
                    left: box.width, // Geser sedikit ke kiri
                    top: box.height,
                    angle: -90,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                // Tambahkan kotak dan teks ke kanvas
                canvas.add(box);
                canvas.add(textPanjang);
                canvas.add(textLebar);
            }
            // Fungsi untuk membuat sel tabel
            function createTableCell(x, y) {
                var cell = new fabric.Rect({
                    left: x,
                    top: y,
                    width: cellWidth,
                    height: cellHeight,
                    fill: 'transparent',
                    stroke: 'red',
                    strokeWidth: 1,
                });
                var fontSize = 3 * 12;
                var textPanjang = new fabric.IText((cellWidth / 10) + '', {
                    left: cell.left + (cell.width / 2) - 10,
                    top: cell.top,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                var textLebar = new fabric.IText((cellHeight / 10) + '', {
                    left: cell.left,
                    top: cell.top + (cell.height / 2) - 10,
                    textAlign: 'center',
                    fontSize: fontSize,
                    // angle: -90,
                });
                canvas.add(textPanjang);
                canvas.add(textLebar);
                return cell;
            }

            function createTableCellSisaPanjang(x, y, offsetX) {
                // console.log(y);
                var cell = new fabric.Rect({
                    left: x + offsetX,
                    top: y,
                    width: cellHeight,
                    height: cellWidth,
                    fill: 'transparent',
                    stroke: 'red',
                    strokeWidth: 1,
                });
                var fontSize = 3 * 12;
                var textPanjang = new fabric.IText((cellHeight / 10) + '', {
                    left: cell.left + (cell.width / 2) - 10,
                    top: cell.top,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                var textLebar = new fabric.IText((cellWidth / 10) + '', {
                    left: cell.left,
                    top: cell.top + (cell.height / 2) - 10,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                canvas.add(textPanjang);
                canvas.add(textLebar);
                canvas.add(cell);
                return cell;
            }

            function createTableCellSisaLebar(x, y, offsetY) {
                // console.log(y);
                var cell = new fabric.Rect({
                    left: x,
                    top: y + offsetY,
                    width: cellHeight,
                    height: cellWidth,
                    fill: 'transparent',
                    stroke: 'red',
                    strokeWidth: 1,
                });
                var fontSize = 3 * 12;
                var textPanjang = new fabric.IText((cellHeight / 10) + '', {
                    left: cell.left + (cell.width / 2) - 10,
                    top: cell.top,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                var textLebar = new fabric.IText((cellWidth / 10) + '', {
                    left: cell.left,
                    top: cell.top + (cell.height / 2) - 10,
                    textAlign: 'center',
                    fontSize: fontSize,
                });
                canvas.add(textPanjang);
                canvas.add(textLebar);
                canvas.add(cell);
                return cell;
            }

            // Fungsi untuk membuat tabel
            function createTable() {
                for (var i = 0; i < rowCount; i++) {
                    for (var j = 0; j < columnCount; j++) {
                        var x = j * (cellWidth + cellSpacing);
                        var y = i * (cellHeight + cellSpacing);
                        var cell = createTableCell(x, y);
                        canvas.add(cell);
                    }
                }

                // Jika sisaColumnPanjang lebih besar dari 0, tambahkan rectangle setelah tabel
                if (sisaColumnPanjang > 0) {
                    // Menambahkan 2 kolom
                    for (var i = 0; i < sisaColumnPanjang; i++) {
                        for (var j = 0; j < sisaRowPanjang; j++) {
                            var x = i* (cellHeight + cellSpacing);
                            var y = j * (cellWidth + cellSpacing);
                            var offsetX = cellWidth * columnCount;
                            createTableCellSisaPanjang(x, y, offsetX);
                        }
                    }

                }

                if (sisaColumnLebar > 0) {
                    // Menambahkan 2 kolom
                    for (var i = 0; i < sisaColumnLebar; i++) {
                        for (var j = 0; j < sisaRowLebar; j++) {
                            var x = i * (cellHeight + cellSpacing);
                            var y = j * (cellWidth + cellSpacing);
                            var offsetY = cellHeight * rowCount;
                            createTableCellSisaLebar(x, y, offsetY);
                        }
                    }

                }

            }
            createCanvasSizeBox();
            createTable();
            resizeCanvas();
        });
    </script>
@endpush
