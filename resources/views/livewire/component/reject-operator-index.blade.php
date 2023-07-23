<!-- resources/views/livewire/timer-component.blade.php -->

<div>
    <div class="row" wire:ignore.self>
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Reject</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div wire:ignore class="col-lg-12">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <div class="form-group">
                                        <label class="form-label mb-3">Tujuan Reject</label>
                                        <select class="form-control form-select" data-bs-placeholder="Pilih Tujuan Reject" wire:model.defer="tujuanReject" required>
                                            <option label="Pilih Tujuan Reject"></option>
                                            @foreach ($operatorReject as $operator)
                                                <option value="{{ $operator['id'] }}">{{ $operator->workStepList->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-3">Keterangan Reject</label>
                                        <div class="input-group control-group" style="padding-top: 5px;">
                                            <textarea class="form-control mb-4" placeholder="Alasan Reject" wire:model.defer="keteranganReject" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-info" wire:click="rejectWorkStep('{{ $tujuanReject }}', '{{ $keteranganReject }}')">Submit</button>

                                </div>
                            </div>
                            {{-- <button wire:click="save">asdas</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

