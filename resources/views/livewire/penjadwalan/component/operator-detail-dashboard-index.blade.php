<div>
    {{-- The Master doesn't talk, he acts. --}}
    {{-- <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto" wire:model="paginateNewSpk">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="searchNewSpk">
        </div>
    </div> --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">No SPK</th>
                            <th class="border-bottom-0">Type SPK</th>
                            <th class="border-bottom-0">Order</th>
                            <th class="border-bottom-0">No Po</th>
                            <th class="border-bottom-0">Total Lembar Cetak</th>
                            <th class="border-bottom-0">Machine</th>
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
                                        <button class="btn btn-icon btn-sm btn-info">Group-{{ $dataInstruction->instruction->group_id }}</button>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->spk_type }}
                                    @if ($dataInstruction->instruction->spk_type !== 'production' && $dataInstruction->instruction->count !== null)
                                        - <span class="tag tag-border">{{ $dataInstruction->instruction->count }}</span>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->order_name }}</td>
                                <td>{{ $dataInstruction->instruction->customer_number }}</td>
                                <?php
                                $totalLembarCetak = 0;
                                ?>

                                @foreach ($dataInstruction->instruction->layoutBahan as $data)
                                    <?php
                                    $totalLembarCetak += $data->total_lembar_cetak;
                                    ?>
                                @endforeach

                                <td>{{ currency_idr($totalLembarCetak) }}</td>
                                <td>
                                    @if ($dataInstruction->machine_id !== null)
                                        {{ $dataInstruction->machine->machine_identity }}
                                    @else
                                        -
                                    @endif
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
