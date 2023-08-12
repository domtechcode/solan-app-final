<div>
    {{-- In work, do what you enjoy. --}}
    <form wire:submit.prevent="save">
        <!-- ROW-2-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form Pengajuan Barang Personal</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Nama Barang</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="nama_barang" id="nama_barang"
                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                            autocomplete="off" placeholder="Nama Barang">
                                    </div>
                                    @error('nama_barang')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Quantity</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="qty_barang" id="qty_barang"
                                            class="form-control @error('qty_barang') is-invalid @enderror"
                                            autocomplete="off" placeholder="Quantity">
                                    </div>
                                    @error('qty_barang')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Target Barang Tersedia <span
                                            class="text-red">*</span></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="tgl_target_datang" id="tgl_target_datang"
                                            class="form-control @error('tgl_target_datang') is-invalid @enderror">
                                    </div>
                                    @error('tgl_target_datang')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Keterangan/Catatan</label>
                                    <div class="input-group">
                                        <textarea wire:model="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                            autocomplete="off" placeholder="Keterangan/Catatan" rows="4"></textarea>
                                    </div>
                                    @error('keterangan')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-2 END -->
    </form>
</div>
