<div>
    {{-- Do your work, then step back. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Pond</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Hasil Akhir Pond</label>
                                <div class="input-group">
                                    <input type="text" wire:model="hasil_akhir_pond" id="hasil_akhir_pond" class="form-control" autocomplete="off" placeholder="Hasil Akhir Pond">
                                </div>
                                @error('hasil_akhir_pond') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Nama Pisau</label>
                                <div class="input-group">
                                    <input type="text" wire:model="nama_pisau" id="nama_pisau" class="form-control" autocomplete="off" placeholder="Nama Pisau">
                                </div>
                                @error('nama_pisau') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Lokasi Pisau</label>
                                <div class="input-group">
                                    <input type="text" wire:model="lokasi_pisau" id="lokasi_pisau" class="form-control" autocomplete="off" placeholder="Lokasi Pisau">
                                </div>
                                @error('lokasi_pisau') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Status Pisau</label>
                                <div class="input-group">
                                    <select wire:model="status_pisau" id="type_ppn" class="form-control form-select" data-bs-placeholder="Pilih Status Pisau">
                                        <option label="-- Pilih Status Pisau --"></option>
                                        <option value="Baru">Baru</option>
                                        <option value="Repeat">Repeat</option>
                                    </select>
                                </div>
                                @error('status_pisau') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Nama Matress</label>
                                <div class="input-group">
                                    <input type="text" wire:model="nama_matress" id="nama_matress" class="form-control" autocomplete="off" placeholder="Nama Matress">
                                </div>
                                @error('nama_matress') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Lokasi Matress</label>
                                <div class="input-group">
                                    <input type="text" wire:model="lokasi_matress" id="lokasi_matress" class="form-control" autocomplete="off" placeholder="Lokasi Matress">
                                </div>
                                @error('lokasi_matress') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Status Matress</label>
                                <div class="input-group">
                                    <select wire:model="status_matress" id="type_ppn" class="form-control form-select" data-bs-placeholder="Pilih Status Matress">
                                        <option label="-- Pilih Status Pisau --"></option>
                                        <option value="Baru">Baru</option>
                                        <option value="Repeat">Repeat</option>
                                    </select>
                                </div>
                                @error('status_matress') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
