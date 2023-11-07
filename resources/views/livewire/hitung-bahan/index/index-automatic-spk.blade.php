<div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Landscape</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="example">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Panjang Barang Jadi</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="order_name" id="order_name"
                                            class="form-control @error('order_name') is-invalid @enderror"
                                            autocomplete="off" placeholder="Panjang Barang Jadi">
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Lebar Barang Jadi</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="order_name" id="order_name"
                                            class="form-control @error('order_name') is-invalid @enderror"
                                            autocomplete="off" placeholder="Lebar Barang Jadi">
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Qty</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="order_name" id="order_name"
                                            class="form-control @error('order_name') is-invalid @enderror"
                                            autocomplete="off" placeholder="Qty">
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Pond</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="layout">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="sample">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Potong Jadi</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="layout">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="sample">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Jarak Potong Jadi</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="layout">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Ya</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="spk_type"
                                                    class="custom-switch-input @error('spk_type') is-invalid @enderror"
                                                    value="sample">
                                                <span
                                                    class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Tidak</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Mesin</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select wire:model="fsc_type" class="form-control form-select"
                                            data-bs-placeholder="Pilih Mesin">
                                            <option label="-- Pilih Mesin --"></option>
                                            <option value="FS">46</option>
                                            <option value="FM">52</option>
                                            <option value="FR">58</option>
                                        </select>
                                        @error('fsc_type')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                    @error('order_name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mt-4 mb-0">Generate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Landscape</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
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

                        <div class="col-sm-12 col-md-12">
                            <div class="example">
                                <b>Layout Setting</b>
                                <div class="fabric-canvas-wrapper-setting">
                                    <canvas id="canvasSetting"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12 mt-3">
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
                                        <td>Panjang Sisa Bahan</td>
                                        <td>= {{ $panjangSisaBahanLandscape }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lebar Sisa Bahan</td>
                                        <td>= {{ $lebarSisaBahanLandscape }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
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
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/fabricjs/fabric.js') }}"></script>
    <script>
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
        var canvasWidth = {{ $ukuranPanjangLembarCetakLandscape * 12 }}; // Lebar canvas dalam mm
        var canvasHeight = {{ $ukuranLebarLembarCetakLandscape * 12 }}; // Tinggi canvas dalam mm

        var panjangLembarCetak = {{ $ukuranPanjangLembarCetakLandscape * 10 }}; // Lebar canvas dalam mm
        var lebarLembarCetak = {{ $ukuranLebarLembarCetakLandscape * 10 }}; // Tinggi canvas dalam mm

        // Ukuran sel tabel dalam mm
        var cellWidth = {{ $panjangBarangJadi * 10 }}; // Mengubah dari cm ke mm
        var cellHeight = {{ $lebarBarangJadi * 10 }}; // Mengubah dari cm ke mm
        var cellSpacing = {{ $jarakPanjangAntarBarang * 10 }}; // Mengubah dari cm ke mm
        var rowCount = {{ $lebarNaikLandscape }};
        var columnCount = {{ $panjangNaikLandscape }};

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

            // Tambahkan kotak dan teks ke kanvas
            canvas.add(box);
            canvas.add(textPanjang);
            canvas.add(textLebar);
        }

        // Fungsi untuk membuat sel tabel
        function createTableCell(x, y) {
            var cell = new fabric.Rect({
                left: x + {{ $jarakSisiKiri * 10 }},
                top: y + {{ $jarakAtas * 10 }},
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
    </script>
    <script>
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
        var canvasWidth = {{ $panjangBahan * 12 }}; // Lebar canvas dalam mm
        var canvasHeight = {{ $lebarBahan * 12 }}; // Tinggi canvas dalam mm

        var panjangBahan = {{ $panjangBahan * 10 }}; // Lebar canvas dalam mm
        var lebarBahan = {{ $lebarBahan * 10 }}; // Tinggi canvas dalam mm

        // Ukuran sel tabel dalam mm
        var cellWidth = {{ $ukuranPanjangLembarCetakLandscape * 10 }}; // Mengubah dari cm ke mm
        var cellHeight = {{ $ukuranLebarLembarCetakLandscape * 10 }}; // Mengubah dari cm ke mm
        var cellSpacing = 0; // Mengubah dari cm ke mm
        var rowCount = {{ $lebarNaikBahanLandscape }};
        var columnCount = {{ $panjangNaikBahanLandscape }};

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
                top: lebarLembarCetak,
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
                top: cell.top + (cell.height / 2) + 10,
                textAlign: 'center',
                fontSize: fontSize,
                angle: -90,
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
    </script>
@endpush
