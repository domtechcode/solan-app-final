<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
            <select id="" name="" class="form-control form-select w-auto" wire:model="paginateAll">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="searchAll">
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
                            <th class="border-bottom-0">Type SPK</th>
                            <th class="border-bottom-0">Pemesan</th>
                            <th class="border-bottom-0">Order</th>
                            <th class="border-bottom-0">No Po</th>
                            <th class="border-bottom-0">Style</th>
                            <th class="border-bottom-0">Ukuran Barang</th>
                            <th class="border-bottom-0">Permintaan Kirim</th>
                            <th class="border-bottom-0">Total Qty</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($instructionsAll as $key => $dataInstruction)
                            <tr wire:key="{{ $dataInstruction->instruction->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $dataInstruction->instruction->spk_number }}
                                    @if ($dataInstruction->instruction->spk_number_fsc)
                                        <span
                                            class="tag tag-border">{{ $dataInstruction->instruction->spk_number_fsc }}</span>
                                    @endif

                                    @if ($dataInstruction->instruction->group_id)
                                        <button class="btn btn-icon btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#openModalGroupAll"
                                            wire:click="modalInstructionDetailsGroupAll({{ $dataInstruction->instruction->group_id }})"
                                            wire:key="modalInstructionDetailsGroupAll({{ $dataInstruction->instruction->group_id }})">Group-{{ $dataInstruction->instruction->group_id }}</button>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->spk_type }}
                                    @if ($dataInstruction->instruction->spk_type !== 'production' && $dataInstruction->instruction->count !== null)
                                        - <span class="tag tag-border">{{ $dataInstruction->instruction->count }}</span>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->customer_name }}</td>
                                <td>{{ $dataInstruction->instruction->order_name }}</td>
                                <td>{{ $dataInstruction->instruction->customer_number }}</td>
                                <td>{{ $dataInstruction->instruction->code_style }}</td>
                                <td>{{ $dataInstruction->instruction->ukuran_barang }}</td>
                                <td>{{ $dataInstruction->instruction->shipping_date }}</td>
                                <td>{{ currency_idr($dataInstruction->instruction->quantity - $dataInstruction->instruction->stock) }}
                                </td>
                                @if (in_array($dataInstruction->status_id, [1, 8]))
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                    </td>
                                @elseif(in_array($dataInstruction->status_id, [2, 9, 10, 11, 20, 23]))
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-info rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                    </td>
                                @elseif(in_array($dataInstruction->status_id, [3, 5, 17, 18, 19, 21, 22, 24, 25, 26, 27]))
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                    </td>
                                @elseif(in_array($dataInstruction->status_id, [7, 13, 14, 16]))
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                    </td>
                                    <td>
                                        @if ($dataInstruction->spk_status != 'Running')
                                            <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                        @endif
                                        <span
                                            class="badge bg-success rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#openModalAll"
                                            wire:click="modalInstructionDetailsAll({{ $dataInstruction->instruction->id }})"
                                            wire:key="modalInstructionDetailsAll({{ $dataInstruction->instruction->id }})"><i
                                                class="fe fe-eye"></i></button>
                                    </div>
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
            {{ $instructionsAll->links() }}
        </div>
    </div>

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="openModalAll" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if (isset($catatanSpk))
                        @foreach ($catatanSpk as $datanote)
                            @if (isset($datanote))
                                <div class="row row-sm mb-5">
                                    <div class="text-wrap">
                                        <div class="">
                                            <div class="alert alert-info">
                                                <span class=""><svg xmlns="http://www.w3.org/2000/svg"
                                                        height="40" width="40" viewBox="0 0 24 24">
                                                        <path fill="#70a9ee"
                                                            d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                                        <circle cx="12" cy="17" r="1" fill="#1170e4" />
                                                        <path fill="#1170e4"
                                                            d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                                    </svg></span>
                                                <strong>Catatan Dari Operator : {{ $datanote->user->name }}</strong>
                                                <hr class="message-inner-separator">
                                                <p>{{ $datanote->catatan }}</p>
                                                <div class="d-flex justify-content-end">
                                                    <small>{{ $datanote->created_at }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">NO. SPK</th>
                                            <th class="border-bottom-0">PEMESAN</th>
                                            <th class="border-bottom-0">NO. PO</th>
                                            <th class="border-bottom-0">ORDER</th>
                                            <th class="border-bottom-0">CODE STYLE</th>
                                            <th class="border-bottom-0">TGL. PO MASUK</th>
                                            <th class="border-bottom-0">PERMINTAAN KIRIM</th>
                                            <th class="border-bottom-0">QTY</th>
                                            <th class="border-bottom-0">STOCK</th>
                                            <th class="border-bottom-0">HARGA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $selectedInstruction->spk_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->customer_name ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->customer_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->order_name ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->code_style ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->order_date ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->shipping_date ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->quantity ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->stock ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->price ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row mb-3">
                        <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">FOLLOW UP</th>
                                            <th class="border-bottom-0">TYPE SPK</th>
                                            <th class="border-bottom-0">PAJAK</th>
                                            <th class="border-bottom-0">MASTER SPK</th>
                                            <th class="border-bottom-0">SUB SPK</th>
                                            <th class="border-bottom-0">GROUP</th>
                                            <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                            <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                            <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $selectedInstruction->follow_up ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_type ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->taxes_type ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_parent ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->sub_spk ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->group_id ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_layout_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->spk_sample_number ?? '-' }}</td>
                                            <td>{{ $selectedInstruction->shipping_date_first ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    <ul class="notification">
                                        @if (isset($selectedWorkStep))
                                            @forelse ($selectedWorkStep as $workstep)
                                                @if ($workstep->status_task == 'Pending Approved')
                                                    <?php
                                                    $border = 'border-secondary';
                                                    $bg_badge = 'bg-secondary';
                                                    ?>
                                                @elseif($workstep->status_task == 'Process')
                                                    <?php
                                                    $border = 'border-info';
                                                    $bg_badge = 'bg-info';
                                                    ?>
                                                @elseif($workstep->status_task == 'Complete' || $workstep->status_task == 'Selesai')
                                                    <?php
                                                    $border = 'border-success';
                                                    $bg_badge = 'bg-success';
                                                    ?>
                                                @elseif($workstep->status_task == 'Reject' || $workstep->status_task == 'Reject Requirements')
                                                    <?php
                                                    $border = 'border-primary';
                                                    $bg_badge = 'bg-primary';
                                                    ?>
                                                @else
                                                    <?php
                                                    $border = '';
                                                    $bg_badge = '';
                                                    ?>
                                                @endif
                                                <li>
                                                    <div class="notification-time">
                                                        <span class="ms-2">{{ $workstep->selesai ?? '-' }}</span>
                                                    </div>
                                                    <div class="notification-icon">
                                                        <a href="javascript:void(0);"></a>
                                                    </div>
                                                    <div
                                                        class="notification-body border {{ $border }} p-5 br-5">
                                                        <div class="media mt-0">
                                                            <div class="main-avatar avatar-md online">
                                                                <img alt="avatar" class="br-7"
                                                                    src="{{ asset('assets/images/users/1.jpg') }}">
                                                            </div>
                                                            <div class="media-body ms-3 d-flex">
                                                                <div class="">
                                                                    <p class="fs-15 text-dark fw-bold mb-0">
                                                                        {{ $workstep->workStepList->name ?? '-' }}</p>
                                                                    <p class="mb-0 fs-13 text-dark">
                                                                        {{ $workstep->user->name ?? '-' }}</p>
                                                                    <p class="mb-0 fs-13 text-dark">Dijadwalkan :
                                                                        {{ $workstep->schedule_date ?? '-' }}</p>
                                                                </div>
                                                                <div class="notify-time">
                                                                    <span
                                                                        class="badge {{ $bg_badge }} rounded-pill text-white p-2 px-3">{{ $workstep->status_task }}</span></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <p>No files found.</p>
                                            @endforelse
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- file --}}
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Contoh
                                    <hr>
                                    <div class="d-flex text-center">
                                        <ul>
                                            @if (isset($selectedFileContoh))
                                                @forelse ($selectedFileContoh as $file)
                                                    <li class="mb-3">
                                                        <img class="img-responsive"
                                                            src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                            alt="File Contoh">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                    download>{{ $file->file_name }}</a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <p>No files found.</p>
                                                @endforelse
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Arsip
                                    <hr>
                                    <ul class="list-group no-margin">
                                        @if (isset($selectedFileArsip))
                                            @forelse ($selectedFileArsip as $file)
                                                <li class="list-group-item d-flex ps-3">
                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                        download>{{ $file->file_name }}</a>
                                                </li>
                                            @empty
                                                <p>No files found.</p>
                                            @endforelse
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            File Sample
                                            <hr>
                                            <ul class="list-group no-margin">
                                                @if (isset($selectedFileSample))
                                                    @forelse ($selectedFileSample as $file)
                                                        <li class="list-group-item d-flex ps-3">
                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                download>{{ $file->file_name }}</a>
                                                        </li>
                                                    @empty
                                                        <p>No files found.</p>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Accounting
                                    <hr>
                                    <ul class="list-group no-margin">
                                        @if (isset($selectedFileAccounting))
                                            @forelse ($selectedFileAccounting as $file)
                                                <li class="list-group-item d-flex ps-3">
                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                        download>{{ $file->file_name }}</a>
                                                </li>
                                            @empty
                                                <p>No files found.</p>
                                            @endforelse
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            File Layout
                                            <hr>
                                            <ul class="list-group no-margin">
                                                @if (isset($selectedFileLayout))
                                                    @forelse ($selectedFileLayout as $file)
                                                        <li class="list-group-item d-flex ps-3">
                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                download>{{ $file->file_name }}</a>
                                                        </li>
                                                    @empty
                                                        <p>No files found.</p>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (Auth()->user()->role == 'Follow Up')
                        <button class="btn btn-icon btn-primary" wire:click="deleteSpk({{ $instructionSelectedId }})"
                            wire:key="deleteSpk({{ $instructionSelectedId }})"><i class="fe fe-trash"></i>
                            Delete</button>
                        <button class="btn btn-danger" wire:click="holdSpk({{ $instructionSelectedId }})"
                            wire:key="holdSpk({{ $instructionSelectedId }})">Hold</button>
                        <button class="btn btn-warning" wire:click="cancelSpk({{ $instructionSelectedId }})"
                            wire:key="cancelSpk({{ $instructionSelectedId }})"><i class="fe fe-warning"></i>
                            Cancel</button>
                        @if (isset($instructionSelectedId))
                            <a class="btn btn-info"
                                href="{{ route('followUp.reorderInstruction', ['instructionId' => $instructionSelectedId]) }}">Reorder</a>
                        @endif
                    @endif
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Group-->
    <div wire:ignore.self class="modal fade" id="openModalGroupAll" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction Group</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default active">
                            <div class="panel-heading " role="tab" id="headingOne1">
                                <h4 class="panel-title">
                                    <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion"
                                        href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                        {{ $selectedGroupParent->spk_number ?? '-' }} <span
                                            class="tag tag-blue">Parent</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" role="tabpanel"
                                aria-labelledby="headingOne1">
                                <div class="panel-body">
                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">NO. SPK</th>
                                                            <th class="border-bottom-0">PEMESAN</th>
                                                            <th class="border-bottom-0">NO. PO</th>
                                                            <th class="border-bottom-0">ORDER</th>
                                                            <th class="border-bottom-0">CODE STYLE</th>
                                                            <th class="border-bottom-0">TGL. PO MASUK</th>
                                                            <th class="border-bottom-0">PERMINTAAN KIRIM</th>
                                                            <th class="border-bottom-0">QTY</th>
                                                            <th class="border-bottom-0">STOCK</th>
                                                            <th class="border-bottom-0">HARGA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->spk_number ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->customer_name ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->customer_number ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->order_name ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->code_style ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->order_date ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->shipping_date ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->quantity ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->stock ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->price ?? '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">FOLLOW UP</th>
                                                            <th class="border-bottom-0">TYPE SPK</th>
                                                            <th class="border-bottom-0">PAJAK</th>
                                                            <th class="border-bottom-0">MASTER SPK</th>
                                                            <th class="border-bottom-0">SUB SPK</th>
                                                            <th class="border-bottom-0">GROUP</th>
                                                            <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                                            <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                                            <th class="border-bottom-0">TGL AWAL PERMINTAAN KIRIM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->follow_up ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->taxes_type ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->spk_parent ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->sub_spk ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->group_id ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_layout_number ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->spk_sample_number ?? '-' }}
                                                            </td>
                                                            <td>{{ $selectedInstructionParent->shipping_date_first ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row -->
                                    <div class="row mb-3">
                                        <div class="col-xl-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>LANGKAH KERJA</th>
                                                            <th>TARGET SELESAI</th>
                                                            <th>DIJADWALKAN</th>
                                                            <th>TARGET JAM</th>
                                                            <th>OPERATOR/REKANAN</th>
                                                            <th>MACHINE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($selectedWorkStepParent))
                                                            @foreach ($selectedWorkStepParent as $workstep)
                                                                <tr>
                                                                    <td>{{ $workstep->workStepList->name ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $workstep->target_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                                    <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                                    <td>{{ $workstep->user->name ?? '-' }}</td>
                                                                    <td>{{ $workstep->machine->machine_identity ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- file --}}
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Contoh
                                                    <hr>
                                                    <div class="d-flex text-center">
                                                        <ul>
                                                            @if (isset($selectedFileContohParent))
                                                                @forelse ($selectedFileContohParent as $file)
                                                                    <li class="mb-3">
                                                                        <img class="img-responsive"
                                                                            src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                            alt="File Contoh Parent">
                                                                        <div class="expanel expanel-default">
                                                                            <div class="expanel-body">
                                                                                <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                    download>{{ $file->file_name }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @empty
                                                                    <p>No files found.</p>
                                                                @endforelse
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Arsip
                                                    <hr>
                                                    <ul class="list-group no-margin">
                                                        @if (isset($selectedFileArsipParent))
                                                            @forelse ($selectedFileArsipParent as $file)
                                                                <li class="list-group-item d-flex ps-3">
                                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                        download>{{ $file->file_name }}</a>
                                                                </li>
                                                            @empty
                                                                <p>No files found.</p>
                                                            @endforelse
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Sample
                                                            <hr>
                                                            <ul class="list-group no-margin">
                                                                @if (isset($selectedFileSampleParent))
                                                                    @forelse ($selectedFileSampleParent as $file)
                                                                        <li class="list-group-item d-flex ps-3">
                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                download>{{ $file->file_name }}</a>
                                                                        </li>
                                                                    @empty
                                                                        <p>No files found.</p>
                                                                    @endforelse
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Accounting
                                                    <hr>
                                                    <ul class="list-group no-margin">
                                                        @if (isset($selectedFileAccountingParent))
                                                            @forelse ($selectedFileAccountingParent as $file)
                                                                <li class="list-group-item d-flex ps-3">
                                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                        download>{{ $file->file_name }}</a>
                                                                </li>
                                                            @empty
                                                                <p>No files found.</p>
                                                            @endforelse
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Layout
                                                            <hr>
                                                            <ul class="list-group no-margin">
                                                                @if (isset($selectedFileLayoutParent))
                                                                    @forelse ($selectedFileLayoutParent as $file)
                                                                        <li class="list-group-item d-flex ps-3">
                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                download>{{ $file->file_name }}</a>
                                                                        </li>
                                                                    @empty
                                                                        <p>No files found.</p>
                                                                    @endforelse
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $no = 2; ?>
                        @if ($selectedInstructionChild)
                            @foreach ($selectedInstructionChild as $index => $data)
                                <?php $no++; ?>
                                <div class="panel panel-default mt-2">
                                    <div class="panel-heading" role="tab" id="headingTwo2">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-bs-toggle="collapse"
                                                data-bs-parent="#accordion" href="#collapse{{ $no }}"
                                                aria-expanded="false" aria-controls="collapse{{ $no }}">

                                                {{ $data->spk_number ?? '-' }} <span class="tag tag-red">Child</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{ $no }}" class="panel-collapse collapse"
                                        role="tabpanel" aria-labelledby="headingTwo2">
                                        <div class="panel-body">
                                            <!-- Row -->
                                            <div class="row mb-3">
                                                <div class="col-xl-12">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">NO. SPK</th>
                                                                    <th class="border-bottom-0">PEMESAN</th>
                                                                    <th class="border-bottom-0">NO. PO</th>
                                                                    <th class="border-bottom-0">ORDER</th>
                                                                    <th class="border-bottom-0">CODE STYLE</th>
                                                                    <th class="border-bottom-0">TGL. PO MASUK</th>
                                                                    <th class="border-bottom-0">PERMINTAAN KIRIM</th>
                                                                    <th class="border-bottom-0">QTY</th>
                                                                    <th class="border-bottom-0">STOCK</th>
                                                                    <th class="border-bottom-0">HARGA</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $data->spk_number ?? '-' }}</td>
                                                                    <td>{{ $data->customer_name ?? '-' }}</td>
                                                                    <td>{{ $data->customer_number ?? '-' }}</td>
                                                                    <td>{{ $data->order_name ?? '-' }}</td>
                                                                    <td>{{ $data->code_style ?? '-' }}</td>
                                                                    <td>{{ $data->order_date ?? '-' }}</td>
                                                                    <td>{{ $data->shipping_date ?? '-' }}</td>
                                                                    <td>{{ $data->quantity ?? '-' }}</td>
                                                                    <td>{{ $data->stock ?? '-' }}</td>
                                                                    <td>{{ $data->price ?? '-' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Row -->
                                            <div class="row mb-3">
                                                <div class="col-xl-12">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">FOLLOW UP</th>
                                                                    <th class="border-bottom-0">TYPE SPK</th>
                                                                    <th class="border-bottom-0">PAJAK</th>
                                                                    <th class="border-bottom-0">MASTER SPK</th>
                                                                    <th class="border-bottom-0">SUB SPK</th>
                                                                    <th class="border-bottom-0">GROUP</th>
                                                                    <th class="border-bottom-0">NO. SPK LAYOUT</th>
                                                                    <th class="border-bottom-0">NO. SPK SAMPLE</th>
                                                                    <th class="border-bottom-0">TGL AWAL PERMINTAAN
                                                                        KIRIM</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $data->follow_up ?? '-' }}</td>
                                                                    <td>{{ $data->spk_type ?? '-' }}</td>
                                                                    <td>{{ $data->taxes_type ?? '-' }}</td>
                                                                    <td>{{ $data->spk_parent ?? '-' }}</td>
                                                                    <td>{{ $data->sub_spk ?? '-' }}</td>
                                                                    <td>{{ $data->group_id ?? '-' }}</td>
                                                                    <td>{{ $data->spk_layout_number ?? '-' }}</td>
                                                                    <td>{{ $data->spk_sample_number ?? '-' }}</td>
                                                                    <td>{{ $data->shipping_date_first ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Row -->
                                            <div class="row mb-3">
                                                <div class="col-xl-12">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>LANGKAH KERJA</th>
                                                                    <th>TARGET SELESAI</th>
                                                                    <th>OPERATOR SUBMIT</th>
                                                                    <th>STATUS</th>
                                                                    <th>TARGET JAM</th>
                                                                    <th>OPERATOR/REKANAN</th>
                                                                    <th>MACHINE</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (isset($data->workstep))
                                                                    @foreach ($data->workstep as $workstep)
                                                                        <tr>
                                                                            <td>{{ $workstep->workStepList->name ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->target_date ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->selesai ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->status_task ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->spk_parent ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->user->name ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->machine->machine_identity ?? '-' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- file --}}
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Contoh
                                                            <hr>
                                                            <div class="d-flex text-center">
                                                                <ul>
                                                                    @if (isset($data->fileArsip))
                                                                        @forelse ($data->fileArsip as $file)
                                                                            @if ($file->type_file == 'contoh')
                                                                                <li class="mb-3">
                                                                                    <img class="img-responsive"
                                                                                        src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                        alt="File Contoh Parent">
                                                                                    <div
                                                                                        class="expanel expanel-default">
                                                                                        <div class="expanel-body">
                                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                                download>{{ $file->file_name }}</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endif
                                                                        @empty
                                                                            <p>No files found.</p>
                                                                        @endforelse
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Arsip
                                                            <hr>
                                                            <ul class="list-group no-margin">
                                                                @if (isset($data->fileArsip))
                                                                    @forelse ($data->fileArsip as $file)
                                                                        @if ($file->type_file == 'arsip')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                    download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @empty
                                                                        <p>No files found.</p>
                                                                    @endforelse
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="expanel expanel-default">
                                                                <div class="expanel-body">
                                                                    File Sample
                                                                    <hr>
                                                                    <ul class="list-group no-margin">
                                                                        @if (isset($data->fileArsip))
                                                                            @forelse ($data->fileArsip as $file)
                                                                                @if ($file->type_file == 'sample')
                                                                                    <li
                                                                                        class="list-group-item d-flex ps-3">
                                                                                        <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                            download>{{ $file->file_name }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            @empty
                                                                                <p>No files found.</p>
                                                                            @endforelse
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Accounting
                                                            <hr>
                                                            <ul class="list-group no-margin">
                                                                @if (isset($data->fileArsip))
                                                                    @forelse ($data->fileArsip as $file)
                                                                        @if ($file->type_file == 'accounting')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                    download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @empty
                                                                        <p>No files found.</p>
                                                                    @endforelse
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="expanel expanel-default">
                                                                <div class="expanel-body">
                                                                    File Layout
                                                                    <hr>
                                                                    <ul class="list-group no-margin">
                                                                        @if (isset($data->fileArsip))
                                                                            @forelse ($data->fileArsip as $file)
                                                                                @if ($file->type_file == 'layout')
                                                                                    <li
                                                                                        class="list-group-item d-flex ps-3">
                                                                                        <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                            download>{{ $file->file_name }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            @empty
                                                                                <p>No files found.</p>
                                                                            @endforelse
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PANEL-GROUP -->
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-delete-all', event => {
            $('#openModalAll').modal('hide');
        });
        window.addEventListener('close-modal-hold-all', event => {
            $('#openModalAll').modal('hide');
        });
        window.addEventListener('close-modal-cancel-all', event => {
            $('#openModalAll').modal('hide');
        });
    </script>
@endpush
