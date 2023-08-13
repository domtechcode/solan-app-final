<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Plate</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Lokasi penyimpanan plate</label>
                                <div class="input-group">
                                    <input type="text" wire:model="tempat_plate" id="tempat_plate"
                                        class="form-control" autocomplete="off" placeholder="Lokasi penyimpanan plate">
                                </div>
                                @error('tempat_plate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Plate Gagal</label>
                                <div class="input-group">
                                    <input type="text" wire:model="plate_gagal" id="plate_gagal" class="form-control"
                                        autocomplete="off" placeholder="Plate Gagal">
                                </div>
                                @error('plate_gagal')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
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
                                                    <div class="input-group control-group" style="padding-top: 5px;">
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

                                                    <div class="input-group control-group" style="padding-top: 5px;">
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

                    <button type="button" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn"
                        wire:click="save" wire:ignore.self>Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
