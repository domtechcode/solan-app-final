<div>
    <form wire:submit.prevent="save">
        {{-- In work, do what you enjoy. --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">Form RAB</h3>
                        <div class="card-options">
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-dark" wire:click="backBtn"
                                    wire:loading.attr="disabled"><i class="fe fe-arrow-left"></i> Kembali</button>
                                <button type="button" class="btn btn-sm btn-warning" wire:click="closePoBtn"
                                    wire:loading.attr="disabled"> Close Po</button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="holdRAB"
                                    wire:loading.attr="disabled"><i class="fe fe-danger"></i> Hold RAB</button>
                                <button type="button" class="btn btn-sm btn-primary" wire:click="holdQC"
                                    wire:loading.attr="disabled"><i class="fe fe-danger"></i> Hold QC</button>
                                <button type="button" class="btn btn-sm btn-success" wire:click="addRAB"
                                    wire:loading.attr="disabled"><i class="fe fe-plus"></i> Add RAB</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table
                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">No SPK</th>
                                                <th class="border-bottom-0">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($instructionItems as $key => $instructions)
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                wire:model="instructionItems.{{ $key }}.spk_number"
                                                                class="form-control" placeholder="SPK Number" readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                wire:model="instructionItems.{{ $key }}.price"
                                                                class="form-control" placeholder="Price"
                                                                type-currency="IDR">
                                                        </div>
                                                        @error('instructionItems.' . $key . '.price')
                                                            <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="table-responsive">
                                    <table
                                        class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">Jenis Pengeluaran</th>
                                                <th class="border-bottom-0">RAB</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rabItems as $index => $rabItem)
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <select
                                                                wire:model="rabItems.{{ $index }}.jenisPengeluaran"
                                                                class="form-control form-select"
                                                                data-bs-placeholder="Pilih Jenis Pengeluaran">
                                                                <option label="-- Pilih Jenis Pengeluaran --"></option>
                                                                <option value="Bahan Baku">Bahan Baku</option>
                                                                <option value="Plate">Plate</option>
                                                                <option value="Film">Film</option>
                                                                <option value="UV/WB/Laminating">UV/WB/Laminating
                                                                </option>
                                                                <option value="Spot UV">Spot UV</option>
                                                                <option value="Pisau Pon">Pisau Pon</option>
                                                                <option value="Blok Lem">Blok Lem</option>
                                                                <option value="Lem Lainnya">Lem Lainnya</option>
                                                                <option value="Matress Foil/Emboss">Matress Foil/Emboss
                                                                </option>
                                                                <option value="Mata Itik + Pasang">Mata Itik + Pasang
                                                                </option>
                                                                <option value="Tali + Pasang">Tali + Pasang</option>
                                                                <option value="Jasa Maklun">Jasa Maklun</option>
                                                                <option value="Biaya Packing">Biaya Packing</option>
                                                                <option value="Biaya Pengiriman">Biaya Pengiriman
                                                                </option>
                                                                <option value="Biaya Lainnya">Biaya Lainnya</option>
                                                            </select>
                                                            @error('rabItems.' . $index . '.jenisPengeluaran')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" autocomplete="off"
                                                                wire:model="rabItems.{{ $index }}.rab"
                                                                class="form-control" placeholder="RAB"
                                                                type-currency="IDR">
                                                            @error('rabItems.' . $index . '.rab')
                                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="removeRAB({{ $index }})"><i
                                                                class="fe fe-trash-2"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="expanel expanel-default">
                                    <div class="expanel-body">
                                        <div class="form-group">
                                            <label class="form-label mb-3">Catatan</label>
                                            <button class="btn btn-info" type="button" wire:click="addEmptyNote"><i
                                                    class="fe fe-plus"></i>Tambah Catatan</button>
                                        </div>

                                        @foreach ($notes as $index => $note)
                                            <div class="col-sm-12 col-md-12" wire:key="note-{{ $index }}">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <select class="form-control form-select"
                                                                data-bs-placeholder="Pilih Tujuan Catatan"
                                                                wire:model="notes.{{ $index }}.tujuan" required>
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
                                                        <div class="input-group control-group"
                                                            style="padding-top: 5px;">
                                                            <textarea class="form-control mb-4" placeholder="Catatan" rows="4"
                                                                wire:model="notes.{{ $index }}.catatan" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="form-label">Keterangan Reject</label>
                                <div class="input-group control-group" style="padding-top: 5px;">
                                    <textarea class="form-control mb-4" placeholder="Keterangan Reject" rows="4" wire:model="keteranganReject"></textarea>
                                </div>
                                @error('keteranganReject')
                                    <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mt-4 mb-0"
                            wire:click="rejectRAB">Reject</button>
                        <button type="submit" class="btn btn-success mt-4 mb-0">Submit & Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
