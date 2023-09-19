<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="expanel expanel-default">
                <div class="expanel-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <label class="form-label mb-3">Langkah Kerja</label>
                            <div class="form-group">
                                <div wire:ignore>
                                    <select class="form-control" data-clear data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}" data-placeholder="Select Langkah Kerja"
                                        wire:model="worksteplistSelected" id="worksteplistSelected" style="width: 100%;">
                                        <option label>Select Langkah Kerja</option>
                                        @foreach ($dataWorkStepList as $dataworksteplist)
                                            <option value="{{ $dataworksteplist->id }}">{{ $dataworksteplist->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <label class="form-label mb-3">Dijadwalkan</label>
                            <div class="form_group">
                                <div class="input-group">
                                    <input type="date" wire:model="dijadwalkanSelected" id="dijadwalkanSelected"
                                        class="form-control @error('dijadwalkanSelected') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <label class="form-label mb-3">Target
                                Selesai</label>
                            <div class="form_group">
                                <div class="input-group">
                                    <input type="date" wire:model="targetSelesaiSelected" id="targetSelesaiSelected"
                                        class="form-control @error('targetSelesaiSelected') is-invalid @enderror">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <label class="form-label mb-3">User/Operator</label>
                            <div class="form-group">
                                <div wire:ignore>
                                    <select class="form-control" data-clear data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}" data-placeholder="Select User/Operator"
                                        wire:model="userSelected" id="userSelected" style="width: 100%;">
                                        <option label>Select User/Operator</option>
                                        <option value="all">All
                                        </option>
                                        @foreach ($dataUser as $datauser)
                                            <option value="{{ $datauser->id }}">{{ $datauser->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">No SPK</th>
                            <th class="border-bottom-0">Order</th>
                            <th class="border-bottom-0">No Po</th>
                            <th class="border-bottom-0">Dijadwalkan</th>
                            <th class="border-bottom-0">Target</th>
                            <th class="border-bottom-0">Machine</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataDetailWorkStep as $key => $dataInstruction)
                            <tr wire:key="{{ $dataInstruction->instruction->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $dataInstruction->instruction->spk_number }}
                                    @if ($dataInstruction->instruction->spk_number_fsc)
                                        <span
                                            class="tag tag-border">{{ $dataInstruction->instruction->spk_number_fsc }}</span>
                                    @endif

                                    @if ($dataInstruction->instruction->group_id)
                                        <button
                                            class="btn btn-icon btn-sm btn-info">Group-{{ $dataInstruction->instruction->group_id }}</button>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->spk_type }}
                                    @if ($dataInstruction->instruction->spk_type !== 'production' && $dataInstruction->instruction->count !== null)
                                        - <span class="tag tag-border">{{ $dataInstruction->instruction->count }}</span>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->order_name }}</td>
                                <td>{{ $dataInstruction->instruction->customer_number }}</td>
                                <td>{{ $dataInstruction->schedule_date }}</td>
                                <td>{{ $dataInstruction->target_date }}</td>
                                <td>
                                    @if ($dataInstruction->machine_id !== null)
                                        {{ $dataInstruction->machine->machine_identity }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    -
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">
                                    No Data!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
        <div class="col d-flex justify-content-end mt-3">
            {{ $dataDetailWorkStep->links() }}
        </div>
    </div>
</div>
