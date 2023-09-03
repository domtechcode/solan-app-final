<div>
    {{-- Do your work, then step back. --}}
    @if ($dataInstruction->spk_type == 'layout')
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form Checker</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
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

                            <div class="col-sm-12 col-md-12 mb-3">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Revisi</th>
                                            <th class="border-bottom-0">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($historyRevisi as $item)
                                            <tr>
                                                <td>
                                                    {{ $item['catatan'] }}
                                                </td>
                                                <td>
                                                    {{ $item['created_at'] }}
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form Checker</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Form Untuk Upload File Film</th>
                                            <th class="border-bottom-0">Keperluan</th>
                                            <th class="border-bottom-0">Ukuran Film</th>
                                            <th class="border-bottom-0">Jumlah Film</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($fileFilmData as $file)
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

                            <div class="col-sm-12 col-md-12 mb-3">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">History Revisi</th>
                                            <th class="border-bottom-0">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($historyRevisi as $item)
                                            <tr>
                                                <td>
                                                    {{ $item['catatan'] }}
                                                </td>
                                                <td>
                                                    {{ $item['created_at'] }}
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
    @endif
</div>
