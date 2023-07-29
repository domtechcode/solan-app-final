<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form {{ $jenis_pekerjaan }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <div class="input-group">
                                    <input type="text" wire:model="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control" autocomplete="off" placeholder="Jenis Pekerjaan">
                                </div>
                                @error('jenis_pekerjaan') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Hasil Akhir</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir" id="hasil_akhir" class="form-control" autocomplete="off" placeholder="Hasil Akhir">
                                </div>
                                @error('hasil_akhir') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Lem Terpakai</label>
                                <div class="input-group">
                                    <input type="text" wire:model="lem_terpakai" id="lem_terpakai" class="form-control" autocomplete="off" placeholder="Lem Terpakai">
                                </div>
                                @error('lem_terpakai') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Catatan Proses Pengerjaan</label>
                            <div class="input-group control-group" style="padding-top: 5px;">
                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" style="display: none;" class="btn btn-success mt-4 mb-0 submitBtn" wire:click="save" wire:ignore.self>Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
</div>
