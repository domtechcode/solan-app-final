<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form {{ $dataWorkSteps->workStepList->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-5">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">Driver</th>
                                        <th class="border-bottom-0">Kernet</th>
                                        <th class="border-bottom-0">Qty</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($anggota as $index => $data)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select wire:model="anggota.{{ $index }}.driver" class="form-control form-select" data-bs-placeholder="Pilih Nama Driver">
                                                            <option label="-- Pilih Nama Driver --"></option>
                                                            @foreach ($dataDriver as $data)
                                                                <option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('anggota.'.$index.'.driver') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select wire:model="anggota.{{ $index }}.kernet" class="form-control form-select" data-bs-placeholder="Pilih Nama Kernet">
                                                            <option label="-- Pilih Nama Kernet --"></option>
                                                            @foreach ($dataDriver as $data)
                                                                <option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('anggota.'.$index.'.kernet') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" wire:model="anggota.{{ $index }}.qty" class="form-control" autocomplete="off" placeholder="QTY">
                                                    </div>
                                                    @error('anggota.'.$index.'.qty') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                wire:click="removeAnggota({{ $index }})"><i class="fe fe-x"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center">
                                                <button type="button" class="btn btn-success mb-0" wire:click="addAnggota">Tambah Anggota</button>
                                            </div>
                                        </td>
                                    </tr>
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
                    <button type="button" class="btn btn-info mt-4 mb-0" wire:click="update" wire:ignore.self>Update Pengiriman</button>
                    <button type="button" class="btn btn-success mt-4 mb-0" wire:click="save" wire:ignore.self>Pengiriman Selesai</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
