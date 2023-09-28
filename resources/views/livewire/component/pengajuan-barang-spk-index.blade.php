<div>
    {{-- In work, do what you enjoy. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Pengajuan Barang Personal</h3>
                </div>
                <div class="card-body">


                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>NO SPK</th>
                                            <th>NAMA BARANG</th>
                                            <th>TARGET TERSEDIA</th>
                                            <th>QTY</th>
                                            <th>FILE FILM/LAIN LAIN (Upload File)</th>
                                            <th>KETERANGAN</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($pengajuanBarang))
                                            @foreach ($pengajuanBarang as $key => $dataPengajuan)
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                {{-- <div wire:ignore> --}}
                                                                <div class="form-group">
                                                                    <select class="form-control" style="width: 100%;"
                                                                        data-clear data-pharaonic="select2"
                                                                        data-component-id="{{ $this->id }}"
                                                                        wire:model="pengajuanBarang.{{ $key }}.instruction_id"
                                                                        id="spk_number-{{ $key }}"
                                                                        data-placeholder="Choose one">
                                                                        <option label>Choose one</option>
                                                                        @foreach ($dataSpkNumber as $data)
                                                                            <option value="{{ $data->id }}">
                                                                                {{ $data->spk_number }} -
                                                                                {{ $data->order_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @error('pengajuanBarang.' . $key . '.instruction_id')
                                                                    <div><span
                                                                            class="text-danger">{{ $message }}</span>
                                                                    </div>
                                                                @enderror
                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text"
                                                                wire:model="pengajuanBarang.{{ $key }}.nama_barang"
                                                                placeholder="Nama Barang" class="form-control">
                                                            @error('pengajuanBarang.' . $key . '.nama_barang')
                                                                <div><span class="text-danger">{{ $message }}</span>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="date" autocomplete="off"
                                                                wire:model="pengajuanBarang.{{ $key }}.tgl_target_datang"
                                                                id="pengajuanBarang.{{ $key }}.tgl_target_datang"
                                                                placeholder="Target Tersedia" class="form-control">
                                                            @error('pengajuanBarang.' . $key . '.tgl_target_datang')
                                                                <div><span class="text-danger">{{ $message }}</span>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text"
                                                                wire:model="pengajuanBarang.{{ $key }}.qty_barang"
                                                                class="form-control" placeholder="QTY">
                                                            @error('pengajuanBarang.' . $key . '.qty_barang')
                                                                <div><span class="text-danger">{{ $message }}</span>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <x-forms.filepond
                                                                        wire:model="pengajuanBarang.{{ $key }}.file_barang"
                                                                        multiple allowImagePreview imagePreviewMaxHeight="200"
                                                                        allowFileTypeValidation allowFileSizeValidation
                                                                        maxFileSize="1024mb" />
                                                                    @error('pengajuanBarang.' . $key . '.file_barang')
                                                                        <div><span class="text-danger">{{ $message }}</span>
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group control-group">
                                                            <textarea class="form-control" placeholder="Keterangan" rows="1"
                                                                wire:model="pengajuanBarang.{{ $key }}.keterangan"></textarea>
                                                        </div>
                                                        @error('pengajuanBarang.' . $key . '.keterangan')
                                                            <div><span class="text-danger">{{ $message }}</span>
                                                            </div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <div class="btn-list">
                                                            <button type="button" class="btn btn-icon btn-sm btn-info"
                                                                wire:click="addPengajuanBarang({{ $key }})"><i
                                                                    class="fe fe-plus"></i></button>
                                                            <button type="button"
                                                                class="btn btn-icon btn-sm btn-danger"
                                                                wire:click="removePengajuanBarang({{ $key }})"><i
                                                                    class="fe fe-x"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button type="button" wire:click="ajukanBarang" class="btn btn-primary mt-4 mb-0">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
