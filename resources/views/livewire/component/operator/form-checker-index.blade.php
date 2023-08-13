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

                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Revisi</label>
                                <div class="input-group control-group" style="padding-top: 5px;">
                                    <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanRevisi"></textarea>
                                </div>
                                @error('catatanRevisi')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Catatan Proses Pengerjaan</label>
                                <div class="input-group control-group" style="padding-top: 5px;">
                                    <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-12">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        <div class="form-group">
                                            <label class="form-label mb-3">Catatan</label>
                                            <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i
                                                    class="fe fe-plus"></i>Tambah
                                                Catatan</button>
                                        </div>

                                        @foreach ($notes as $index => $note)
                                            <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <select class="form-control form-select"
                                                                data-bs-placeholder="Pilih Tujuan Catatan"
                                                                wire:model="notes.{{ $index }}.tujuan">
                                                                <option label="Pilih Tujuan Catatan"></option>
                                                                @foreach ($workSteps as $key)
                                                                    <option value="{{ $key['work_step_list_id'] }}">
                                                                        {{ $key['workStepList']['name'] }}</option>
                                                                @endforeach

                                                            </select>
                                                            <button class="btn btn-danger" type="button"
                                                                wire:click="removeNote({{ $index }})"><i
                                                                    class="fe fe-x"></i></button>
                                                        </div>
                                                        @error('notes.' . $index . '.tujuan')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}
                                                            </p>
                                                        @enderror

                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="notes.{{ $index }}.catatan"
                                                                required></textarea>
                                                        </div>
                                                        @error('notes.' . $index . '.catatan')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" style="display: none;" class="btn btn-primary mt-4 mb-0 submitBtn"
                            wire:click="revisiSetting" wire:ignore.self>Revisi</button>
                        <button type="button" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn"
                            wire:click="saveLayout" wire:ignore.self>Submit & Approve</button>
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
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">File Approve Checker</label>
                                    <x-forms.filepond wire:model="fileChecker" multiple allowImagePreview
                                        imagePreviewMaxHeight="200" allowFileTypeValidation allowFileSizeValidation
                                        acceptedFileTypes="['application/pdf']" maxFileSize="1024mb" />

                                    @error('fileChecker')
                                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
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

                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Revisi</label>
                                <div class="input-group control-group" style="padding-top: 5px;">
                                    <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanRevisi"></textarea>
                                </div>
                                @error('catatanRevisi')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Catatan Proses Pengerjaan</label>
                                <div class="input-group control-group" style="padding-top: 5px;">
                                    <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-12">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        <div class="form-group">
                                            <label class="form-label mb-3">Catatan</label>
                                            <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i
                                                    class="fe fe-plus"></i>Tambah
                                                Catatan</button>
                                        </div>

                                        @foreach ($notes as $index => $note)
                                            <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <select class="form-control form-select"
                                                                data-bs-placeholder="Pilih Tujuan Catatan"
                                                                wire:model="notes.{{ $index }}.tujuan">
                                                                <option label="Pilih Tujuan Catatan"></option>
                                                                @foreach ($workSteps as $key)
                                                                    <option value="{{ $key['work_step_list_id'] }}">
                                                                        {{ $key['workStepList']['name'] }}</option>
                                                                @endforeach

                                                            </select>
                                                            <button class="btn btn-danger" type="button"
                                                                wire:click="removeNote({{ $index }})"><i
                                                                    class="fe fe-x"></i></button>
                                                        </div>
                                                        @error('notes.' . $index . '.tujuan')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}
                                                            </p>
                                                        @enderror

                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                                wire:model="notes.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                        @error('notes.' . $index . '.catatan')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" style="display: none;" class="btn btn-primary mt-4 mb-0 submitBtn"
                            wire:click="revisiSetting" wire:ignore.self>Revisi</button>
                        <button type="button" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn"
                            wire:click="saveProductionAndSample" wire:ignore.self>Submit & Approve</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    @endif
</div>
