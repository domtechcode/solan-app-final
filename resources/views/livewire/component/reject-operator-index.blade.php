<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Reject</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-lg-12">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <div class="form-group">
                                        <label class="form-label mb-3">Tujuan Reject</label>
                                        <select class="form-control form-select" data-bs-placeholder="Pilih Tujuan Reject" wire:model="tujuanReject">
                                            <option label="Pilih Tujuan Reject"></option>
                                            @foreach ($operatorReject as $operator)
                                                <option value="{{ $operator['id'] }}">{{ $operator->workStepList->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('tujuanReject') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-3">Keterangan Reject</label>
                                        <div class="input-group control-group" style="padding-top: 5px;">
                                            <textarea class="form-control mb-4" placeholder="Alasan Reject" wire:model.defer="keteranganReject" rows="4" required></textarea>
                                        </div>
                                        @error('keteranganReject') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
                                    <button class="btn btn-info" wire:click="rejectWorkStep('{{ $tujuanReject }}', '{{ $keteranganReject }}')">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

