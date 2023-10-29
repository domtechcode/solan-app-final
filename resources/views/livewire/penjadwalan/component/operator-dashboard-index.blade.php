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
                                        wire:model="worksteplistSelected" id="worksteplistSelected"
                                        style="width: 100%;">
                                        <option label="Select Langkah Kerja"></option>
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
                                        <option label="Select User/Operator"></option>
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
                <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                    <thead>
                        <tr>
                            <!-- Kolom pengguna -->
                            @foreach ($dataDetailWorkStep->unique('user_id') as $user)
                                <th class="border-bottom-0">{{ $user->user->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @foreach ($dataDetailWorkStep->unique('user_id') as $user)
                                        <td>
                                            <div class="panel-group" id="accordion" role="tablist"
                                                aria-multiselectable="true">
                                                @foreach ($dataDetailWorkStep as $key => $dataInstruction)
                                                    @if ($dataInstruction->user_id == $user->user_id)
                                                        <div class="panel panel-default mt-2">
                                                            <div class="panel-heading " role="tab"
                                                                id="headingOne{{ $dataInstruction->id }}">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-bs-toggle="collapse"
                                                                        data-bs-parent="#accordion"
                                                                        href="#collapse{{ $dataInstruction->id }}"
                                                                        aria-expanded="true"
                                                                        aria-controls="collapse{{ $dataInstruction->id }}">

                                                                        {{ $dataInstruction->instruction->spk_number }} - <?php
                                                                        $totalLembarCetak = 0;
                                                                        ?>

                                                                        @foreach ($dataInstruction->instruction->layoutBahan as $data)
                                                                            <?php
                                                                            $totalLembarCetak += $data->total_lembar_cetak;
                                                                            ?>
                                                                        @endforeach

                                                                    [ {{ currency_idr($totalLembarCetak) }} LC ]
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapse{{ $dataInstruction->id }}"
                                                                class="panel-collapse collapse" role="tabpanel"
                                                                aria-labelledby="headingOne{{ $dataInstruction->id }}">
                                                                <div class="panel-body">
                                                                    {{ $dataInstruction->instruction->order_name }} - [
                                                                    {{ $dataInstruction->state_task }} ]
                                                                    <div class="row" wire:ignore>
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">User
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div wire:ignore>
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label"></label>
                                                                                                <div wire:ignore>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        data-clear
                                                                                                        data-pharaonic="select2"
                                                                                                        data-component-id="{{ $this->id }}"
                                                                                                        data-placeholder="Select User"
                                                                                                        wire:model.defer="changeTo.{{ $key }}.user_id"
                                                                                                        id="changeTo"
                                                                                                        style="width: 100%;">
                                                                                                        <option
                                                                                                            label='Select User'>
                                                                                                        </option>
                                                                                                        @foreach ($dataUser as $datauser)
                                                                                                            <option
                                                                                                                value="{{ $datauser->id }}">
                                                                                                                {{ $datauser->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                @error('changeTo.' .
                                                                                                    $key . '.user_id')
                                                                                                    <div><span
                                                                                                            class="text-danger">{{ $message }}</span>
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="form-label">Dijadwalkan
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div class="input-group">
                                                                                            <input type="date"
                                                                                                wire:model.defer="changeTo.{{ $key }}.schedule_date"
                                                                                                id="schedule_date"
                                                                                                class="form-control @error('changeTo.' . $key . '.schedule_date') is-invalid @enderror"
                                                                                                >
                                                                                        </div>
                                                                                        @error('changeTo.' . $key .
                                                                                            '.schedule_date')
                                                                                            <div><span
                                                                                                    class="text-danger">{{ $message }}</span>
                                                                                            </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="form-label">Target
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div class="input-group">
                                                                                            <input type="date"
                                                                                                wire:model.defer="changeTo.{{ $key }}.target_date"
                                                                                                id="target_date"
                                                                                                class="form-control @error('changeTo.' . $key . '.target_date') is-invalid @enderror"
                                                                                                >
                                                                                        </div>
                                                                                        @error('changeTo.' . $key .
                                                                                            '.target_date')
                                                                                            <div><span
                                                                                                    class="text-danger">{{ $message }}</span>
                                                                                            </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="btn btn-success btn-sm mt-2"
                                                                                wire:click="pindahOperator({{ $dataInstruction->id }}, {{ $key }})"
                                                                                wire:key="pindahOperator({{ $dataInstruction->id }})">Move</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- </div> --}}
                                                    @endif
                                                @endforeach
                                            </div>
                                </div>
                                </td>
                                @endforeach
                            </div>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
        <div class="col d-flex justify-content-end mt-3">
            {{-- {{ $dataDetailWorkStep->links() }} --}}
        </div>
    </div>
    {{-- <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                    <thead>
                        <tr>
                            <!-- Kolom pengguna -->
                            @foreach ($dataDetailWorkStepComplete->unique('user_id') as $user)
                                <th class="border-bottom-0">{{ $user->user->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    @foreach ($dataDetailWorkStepComplete->unique('user_id') as $user)
                                        <td>
                                            <div class="panel-group" id="accordion" role="tablist"
                                                aria-multiselectable="true">
                                                @foreach ($dataDetailWorkStepComplete as $key => $dataInstruction)
                                                    @if ($dataInstruction->user_id == $user->user_id)
                                                        <div class="panel panel-default mt-2">
                                                            <div class="panel-heading" style="background-color: #4ecc48 ;" role="tab"
                                                                id="headingOne{{ $dataInstruction->id }}">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-bs-toggle="collapse"
                                                                        data-bs-parent="#accordion"
                                                                        href="#collapse{{ $dataInstruction->id }}"
                                                                        aria-expanded="true"
                                                                        aria-controls="collapse{{ $dataInstruction->id }}">

                                                                        {{ $dataInstruction->instruction->spk_number }} - <?php
                                                                        $totalLembarCetak = 0;
                                                                        ?>

                                                                        @foreach ($dataInstruction->instruction->layoutBahan as $data)
                                                                            <?php
                                                                            $totalLembarCetak += $data->total_lembar_cetak;
                                                                            ?>
                                                                        @endforeach

                                                                    [ {{ currency_idr($totalLembarCetak) }} LC ]
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapse{{ $dataInstruction->id }}"
                                                                class="panel-collapse collapse" role="tabpanel"
                                                                aria-labelledby="headingOne{{ $dataInstruction->id }}">
                                                                <div class="panel-body">
                                                                    {{ $dataInstruction->instruction->order_name }} - [
                                                                    {{ $dataInstruction->state_task }} ]
                                                                    <div class="row" wire:ignore>
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label class="form-label">User
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div wire:ignore>
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    class="form-label"></label>
                                                                                                <div wire:ignore>
                                                                                                    <select
                                                                                                        class="form-control"
                                                                                                        data-clear
                                                                                                        data-pharaonic="select2"
                                                                                                        data-component-id="{{ $this->id }}"
                                                                                                        data-placeholder="Select User"
                                                                                                        wire:model.defer="changeTo.{{ $key }}.user_id"
                                                                                                        id="changeTo"
                                                                                                        style="width: 100%;">
                                                                                                        <option
                                                                                                            label='Select User'>
                                                                                                        </option>
                                                                                                        @foreach ($dataUser as $datauser)
                                                                                                            <option
                                                                                                                value="{{ $datauser->id }}">
                                                                                                                {{ $datauser->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                                @error('changeTo.' .
                                                                                                    $key . '.user_id')
                                                                                                    <div><span
                                                                                                            class="text-danger">{{ $message }}</span>
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="form-label">Dijadwalkan
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div class="input-group">
                                                                                            <input type="date"
                                                                                                wire:model.defer="changeTo.{{ $key }}.schedule_date"
                                                                                                id="schedule_date"
                                                                                                class="form-control @error('changeTo.' . $key . '.schedule_date') is-invalid @enderror"
                                                                                                >
                                                                                        </div>
                                                                                        @error('changeTo.' . $key .
                                                                                            '.schedule_date')
                                                                                            <div><span
                                                                                                    class="text-danger">{{ $message }}</span>
                                                                                            </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            class="form-label">Target
                                                                                            <span
                                                                                                class="text-red">*</span></label>
                                                                                        <div class="input-group">
                                                                                            <input type="date"
                                                                                                wire:model.defer="changeTo.{{ $key }}.target_date"
                                                                                                id="target_date"
                                                                                                class="form-control @error('changeTo.' . $key . '.target_date') is-invalid @enderror"
                                                                                                >
                                                                                        </div>
                                                                                        @error('changeTo.' . $key .
                                                                                            '.target_date')
                                                                                            <div><span
                                                                                                    class="text-danger">{{ $message }}</span>
                                                                                            </div>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="btn btn-success btn-sm mt-2"
                                                                                wire:click="pindahOperator({{ $dataInstruction->id }}, {{ $key }})"
                                                                                wire:key="pindahOperator({{ $dataInstruction->id }})">Move</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                </div>
                                </td>
                                @endforeach
                            </div>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
        <div class="col d-flex justify-content-end mt-3">
        </div>
    </div> --}}
</div>
