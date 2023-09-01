<!-- resources/views/livewire/timer-component.blade.php -->
<div>
    <div class="row" wire:ignore>
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Data</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Nama</th>
                                            <th class="border-bottom-0">Langkah Kerja</th>
                                            <th class="border-bottom-0">Timer</th>
                                            <th class="border-bottom-0">Dikerjakan</th>
                                            <th class="border-bottom-0">Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $workStepData->user->name ?? '-' }}</td>
                                            <td>{{ $workStepData->workStepList->name ?? '-' }}</td>
                                            <td>{{ $workStepData->timer ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $dikerjakanData = json_decode($workStepData->dikerjakan);
                                                @endphp

                                                @if (is_array($dikerjakanData))
                                                    <ul>
                                                        @foreach ($dikerjakanData as $item)
                                                            <li>-> {{ $item }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $workStepData->selesai }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
