@push('styles')
    <style>
        .canvas-container {
            border: 1px solid #000;
            /* margin-bottom: 20px; */
        }
    </style>
@endpush
<div>
    {{-- Do your work, then step back. --}}

    @foreach ($note as $datanote)
        @if (isset($datanote))
            <div class="row row-sm mb-5">
                <div class="text-wrap">
                    <div class="">
                        <div class="alert alert-info">
                            <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40"
                                    viewBox="0 0 24 24">
                                    <path fill="#70a9ee"
                                        d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                    <circle cx="12" cy="17" r="1" fill="#1170e4" />
                                    <path fill="#1170e4" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
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

    @foreach ($notereject as $datanotereject)
        @if (isset($datanotereject))
            <div class="row row-sm mb-5">
                <div class="text-wrap">
                    <div class="">
                        <div class="alert alert-danger">
                            <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40"
                                    viewBox="0 0 24 24">
                                    <path fill="#f07f8f"
                                        d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                    <circle cx="12" cy="17" r="1" fill="#e62a45" />
                                    <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                </svg></span>
                            <strong>Catatan Reject Dari Operator : {{ $datanotereject->user->name }}</strong>
                            <hr class="message-inner-separator">
                            <p>{{ $datanotereject->catatan }}</p>
                            <div class="d-flex justify-content-end">
                                <small>{{ $datanotereject->created_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @foreach ($noterevisi as $datanoterevisi)
        @if (isset($datanoterevisi))
            <div class="row row-sm mb-5">
                <div class="text-wrap">
                    <div class="">
                        <div class="alert alert-danger">
                            <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40"
                                    viewBox="0 0 24 24">
                                    <path fill="#f07f8f"
                                        d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z" />
                                    <circle cx="12" cy="17" r="1" fill="#e62a45" />
                                    <path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z" />
                                </svg></span>
                            <strong>Revisi Dari Operator : {{ $datanoterevisi->user->name }}</strong>
                            <hr class="message-inner-separator">
                            <p>{{ $datanoterevisi->catatan }}</p>
                            <div class="d-flex justify-content-end">
                                <small>{{ $datanoterevisi->created_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <!-- ROW-1 Data Order-->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Data Order</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">No SPK</th>
                                        <th class="border-bottom-0">Type SPK</th>
                                        <th class="border-bottom-0">Pemesan</th>
                                        <th class="border-bottom-0">Order</th>
                                        <th class="border-bottom-0">No Po</th>
                                        <th class="border-bottom-0">Style</th>
                                        <th class="border-bottom-0">TGL Masuk</th>
                                        <th class="border-bottom-0">TGL Kirim</th>
                                        <th class="border-bottom-0">Permintaan Qty</th>
                                        <th class="border-bottom-0">Stock</th>
                                        <th class="border-bottom-0">Follow Up</th>
                                        <th class="border-bottom-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $spk_type = '';
                                        $total_qty = 0;
                                    @endphp
                                    @foreach ($instructionData as $key => $instruction)
                                        <tr>
                                            <td>
                                                {{ $instruction->spk_number }}
                                                @if ($instruction->spk_number_fsc)
                                                    <span
                                                        class="tag tag-border">{{ $instruction->spk_number_fsc }}</span>
                                                @endif

                                                @if ($instruction->group_id)
                                                    <button class="btn btn-icon btn-sm btn-info"
                                                        wire:click="modalInstructionDetailsGroup({{ $instruction->group_id }})">Group-{{ $instruction->group_id }}</button>
                                                @endif
                                            </td>
                                            <td>{{ $instruction->spk_type }}</td>
                                            <td>{{ $instruction->customer_name }}</td>
                                            <td>{{ $instruction->order_name }}</td>
                                            <td>{{ $instruction->customer_number }}</td>
                                            <td>{{ $instruction->code_style }}</td>
                                            <td>{{ $instruction->order_date }}</td>
                                            <td>{{ $instruction->shipping_date }}</td>
                                            <td>{{ $instruction->quantity }}</td>
                                            <td>{{ $instruction->stock }}</td>
                                            <td>{{ $instruction->follow_up }}</td>
                                            <td>
                                                <div class="btn-list">
                                                    <button class="btn btn-icon btn-sm btn-dark"
                                                        wire:click="modalInstructionDetails({{ $instruction->id }})"><i
                                                            class="fe fe-eye"></i></button>
                                                </div>
                                            </td>
                                            @php
                                                $spk_type = $instruction->spk_type;
                                                $total_qty += $instruction->quantity - $instruction->stock;
                                            @endphp

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><strong>Total Qty</strong></td>
                                        <td><strong>{{ currency_idr($total_qty) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW-1 Contoh Gambar-->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Contoh Gambar</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex text-center">
                            <ul>
                                @if ($contohData)
                                    @foreach ($contohData as $file)
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
                                    @endforeach
                                @else
                                    <p>No files found.</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($spk_type != 'layout')
        @if(isset($fileCheckerData))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                    <div class="card-header">
                        <h3 class="card-title">File Approved Checker</h3>
                    </div>
                    <div class="card-body" style="height: 100%;">
                        <div class="row">
                            <div class="col-sm-12" style="height: 100%;">
                                @forelse ($fileCheckerData as $file)
                                <iframe width="100%" height="900" src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"></iframe>
                            @empty
                                No Data !!!
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Instruction</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                            <th class="border-bottom-0">TGL. DIKIRIM</th>
                                            <th class="border-bottom-0">QTY</th>
                                            <th class="border-bottom-0">STOCK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($selectedInstruction)
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
                                            </tr>
                                        @endif

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
                                        @if ($selectedInstruction)
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
                                        @endif

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
                                            <th>LANGKAH KERJA</th>
                                            <th>TARGET SELESAI</th>
                                            <th>DIJADWALKAN</th>
                                            <th>TARGET JAM</th>
                                            <th>OPERATOR/REKANAN</th>
                                            <th>MACHINE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($selectedWorkStep)
                                            @foreach ($selectedWorkStep as $workstep)
                                                <tr>
                                                    <td>{{ $workstep->workStepList->name ?? '-' }}</td>
                                                    <td>{{ $workstep->target_date ?? '-' }}</td>
                                                    <td>{{ $workstep->schedule_date ?? '-' }}</td>
                                                    <td>{{ $workstep->spk_parent ?? '-' }}</td>
                                                    <td>{{ $workstep->user->name ?? '-' }}</td>
                                                    <td>{{ $workstep->machine->machine_identity ?? '-' }}</td>
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
                                            @if ($selectedFileContoh)
                                                @foreach ($selectedFileContoh as $file)
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
                                                @endforeach
                                            @else
                                                <p>No files found.</p>
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
                                        @if ($selectedFileArsip)
                                            @foreach ($selectedFileArsip as $file)
                                                <li class="list-group-item d-flex ps-3">
                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                        download>{{ $file->file_name }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <p>No files found.</p>
                                            </li>
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
                                                @if ($selectedFileSample)
                                                    @foreach ($selectedFileSample as $file)
                                                        <li class="list-group-item d-flex ps-3">
                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                download>{{ $file->file_name }}</a>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <p>No files found.</p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="expanel expanel-default">
                                        <div class="expanel-body">
                                            File Layout
                                            <hr>
                                            <ul class="list-group no-margin">
                                                @if ($selectedFileLayout)
                                                    @foreach ($selectedFileLayout as $file)
                                                        <li class="list-group-item d-flex ps-3">
                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                download>{{ $file->file_name }}</a>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <p>No files found.</p>
                                                    </li>
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
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Group-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModalGroup" tabindex="-1" role="dialog">
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
                                                            <th class="border-bottom-0">TGL. DIKIRIM</th>
                                                            <th class="border-bottom-0">QTY</th>
                                                            <th class="border-bottom-0">STOCK</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($selectedInstructionParent)
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
                                                                <td>{{ $selectedInstructionParent->quantity ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->stock ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif

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
                                                        @if ($selectedInstructionParent)
                                                            <tr>
                                                                <td>{{ $selectedInstructionParent->follow_up ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->spk_type ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->taxes_type ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->spk_parent ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->sub_spk ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->group_id ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->spk_layout_number ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->spk_sample_number ?? '-' }}
                                                                </td>
                                                                <td>{{ $selectedInstructionParent->shipping_date_first ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        @endif

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
                                                        @if ($selectedWorkStepParent)
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
                                                            @if ($selectedFileContohParent)
                                                                @foreach ($selectedFileContohParent as $file)
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
                                                                @endforeach
                                                            @else
                                                                <p>No files found.</p>
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
                                                        @if ($selectedFileArsipParent)
                                                            @foreach ($selectedFileArsipParent as $file)
                                                                <li class="list-group-item d-flex ps-3">
                                                                    <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                        download>{{ $file->file_name }}</a>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li>
                                                                <p>No files found.</p>
                                                            </li>
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
                                                                @if ($selectedFileSampleParent)
                                                                    @foreach ($selectedFileSampleParent as $file)
                                                                        <li class="list-group-item d-flex ps-3">
                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                download>{{ $file->file_name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-body">
                                                            File Layout
                                                            <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileLayoutParent)
                                                                    @foreach ($selectedFileLayoutParent as $file)
                                                                        <li class="list-group-item d-flex ps-3">
                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                download>{{ $file->file_name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
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

                                                {{ $data->spk_number ?? '-' }} <span
                                                    class="tag tag-red">Child</span>
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
                                                                    <th class="border-bottom-0">TGL. DIKIRIM</th>
                                                                    <th class="border-bottom-0">QTY</th>
                                                                    <th class="border-bottom-0">STOCK</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($data)
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
                                                                    </tr>
                                                                @endif

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
                                                                @if ($data)
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
                                                                @endif

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
                                                                @if ($data->workstep)
                                                                    @foreach ($data->workstep as $workstep)
                                                                        <tr>
                                                                            <td>{{ $workstep->workStepList->name ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->target_date ?? '-' }}
                                                                            </td>
                                                                            <td>{{ $workstep->schedule_date ?? '-' }}
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
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                            @if ($file->type_file == 'contoh')
                                                                                <li class="mb-3">
                                                                                    <img class="img-responsive"
                                                                                        src="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                        alt="File Contoh">
                                                                                    <div
                                                                                        class="expanel expanel-default">
                                                                                        <div class="expanel-body">
                                                                                            <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                                download>{{ $file->file_name }}</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <p>No files found.</p>
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
                                                                @if ($data->fileArsip)
                                                                    @foreach ($data->fileArsip as $file)
                                                                        @if ($file->type_file == 'arsip')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                    download>{{ $file->file_name }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <li>
                                                                        <p>No files found.</p>
                                                                    </li>
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
                                                                        @if ($data->fileArsip)
                                                                            @foreach ($data->fileArsip as $file)
                                                                                @if ($file->type_file == 'sample')
                                                                                    <li
                                                                                        class="list-group-item d-flex ps-3">
                                                                                        <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                            download>{{ $file->file_name }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <li>
                                                                                <p>No files found.</p>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="expanel expanel-default">
                                                                <div class="expanel-body">
                                                                    File Layout
                                                                    <hr>
                                                                    <ul class="list-group no-margin">
                                                                        @if ($data->fileArsip)
                                                                            @foreach ($data->fileArsip as $file)
                                                                                @if ($file->type_file == 'layout')
                                                                                    <li
                                                                                        class="list-group-item d-flex ps-3">
                                                                                        <a href="{{ asset(Storage::url($file->file_path . '/' . $file->file_name)) }}"
                                                                                            download>{{ $file->file_name }}</a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        @else
                                                                            <li>
                                                                                <p>No files found.</p>
                                                                            </li>
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
        window.addEventListener('close-modal', event => {
            $('#detailInstructionModal').modal('hide');
        });

        window.addEventListener('show-detail-instruction-modal', event => {
            $('#detailInstructionModal').modal('show');
        });

        window.addEventListener('show-detail-instruction-modal-group', event => {
            $('#detailInstructionModalGroup').modal('show');
        });
    </script>
@endpush
