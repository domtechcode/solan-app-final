<div>
    {{-- Do your work, then step back. --}}

    @if (isset($collectStep))
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Hasil Langkah Kerja - {{ $collectStep }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Hasil Akhir</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="collectHasilAkhir" id="collectHasilAkhir"
                                            class="form-control" autocomplete="off" placeholder="Hasil Akhir" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @endif

    @if ($anggotaGroupSpk)
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Keluar</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">No Spk</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Keluar</th>
                                            <th class="border-bottom-0">QTY Keluar</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPengajuan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['instruction_id'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['bentuk_maklun'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['rekanan'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['tgl_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['qty_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['satuan_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['catatan'] }}
                                                </td>
                                                <td>
                                                    {{ $data['status'] }}
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
        </div>
        <!-- ROW-2 END -->

        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Kembali</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">No Spk</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Kembali</th>
                                            <th class="border-bottom-0">QTY Kembali</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPenerimaan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['instruction_id'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['bentuk_maklun'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['rekanan'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['tgl_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['qty_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['satuan_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['catatan'] }}
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
        </div>
        <!-- ROW-2 END -->
    @else
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Keluar</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Keluar</th>
                                            <th class="border-bottom-0">QTY Keluar</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                            <th class="border-bottom-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPengajuan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['bentuk_maklun'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['rekanan'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['tgl_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['qty_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['satuan_keluar'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPengajuan[$index]['catatan'] }}
                                                </td>
                                                <td>
                                                    {{ $data['status'] }}
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
        </div>
        <!-- ROW-2 END -->

        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }} - Kembali</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">Bentuk Maklun</th>
                                            <th class="border-bottom-0">Rekanan</th>
                                            <th class="border-bottom-0">Tgl Kembali</th>
                                            <th class="border-bottom-0">QTY Kembali</th>
                                            <th class="border-bottom-0">Satuan</th>
                                            <th class="border-bottom-0">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        ?>
                                        @foreach ($maklunPenerimaan as $index => $data)
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['bentuk_maklun'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['rekanan'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['tgl_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['qty_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['satuan_kembali'] }}
                                                </td>
                                                <td>
                                                    {{ $maklunPenerimaan[$index]['catatan'] }}
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
        </div>
        <!-- ROW-2 END -->
    @endif

</div>
