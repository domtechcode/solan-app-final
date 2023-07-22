<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col">
                {{-- <label class="form-label">Customize Select</label> --}}
                <select id="" name="" class="form-control form-select w-auto" wire:model="paginate">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
        </div>
        <div class="col d-flex justify-content-end">
            <input type="text" class="form-control w-auto" placeholder="Search" wire:model="search">
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
                            <th class="border-bottom-0">TGL Kirim</th>
                            <th class="border-bottom-0">Total Qty</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($instructions) }} --}}
                        @forelse ($instructions as $key => $dataInstruction)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $dataInstruction->instruction->spk_number }}
                                    @if($dataInstruction->instruction->spk_number_fsc)
                                        <span class="tag tag-border">{{ $dataInstruction->instruction->spk_number_fsc }}</span>
                                    @endif

                                    @if($dataInstruction->instruction->group_id)
                                        <button class="btn btn-icon btn-sm btn-info" wire:click="modalInstructionDetailsGroupNewSpk({{ $dataInstruction->instruction->group_id }})">Group-{{ $dataInstruction->instruction->group_id }}</button>
                                    @endif
                                </td>
                                <td>{{ $dataInstruction->instruction->spk_type }}</td>
                                <td>{{ $dataInstruction->instruction->customer_name }}</td>
                                <td>{{ $dataInstruction->instruction->order_name }}</td>
                                <td>{{ $dataInstruction->instruction->customer_number }}</td>
                                <td>{{ $dataInstruction->instruction->code_style }}</td>
                                <td>{{ $dataInstruction->instruction->shipping_date }}</td>
                                <td>{{ $dataInstruction->instruction->quantity - $dataInstruction->instruction->stock }}</td>
                                @if(in_array($dataInstruction->status_id, [1, 8]))
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                </td>
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-secondary rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                </td>
                                @elseif(in_array($dataInstruction->status_id, [2, 9, 10, 11, 20, 23]))
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                </td>
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-info rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                </td>
                                @elseif(in_array($dataInstruction->status_id, [3, 17, 18, 22, 24]))
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $dataInstruction->status->desc_status }}</span>
                                </td>
                                <td>
                                    @if($dataInstruction->spk_status != 'Running')
                                        <span class="tag tag-border">{{ $dataInstruction->spk_status }}</span>
                                    @endif
                                    <span class="badge bg-primary rounded-pill text-white p-2 px-3">{{ $dataInstruction->job->desc_job }}</span>
                                </td>
                                @endif
                                <td>
                                    <div class="btn-list">         
                                        <button class="btn btn-icon btn-sm btn-dark" wire:click="modalInstructionDetailsNewSpk({{ $dataInstruction->instruction->id }})"><i class="fe fe-eye"></i></button>
                                        {{-- <a class="btn btn-icon btn-sm btn-primary" href="{{ route('followUp.updateInstruction', ['instructionId' =>  $dataInstruction->instruction->id]) }}"><i class="fe fe-edit"></i></a> --}}
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
            {{ $instructions->links() }}
        </div>
    </div>
    
    
    <form wire:submit.prevent="save">
    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModalNewSpk" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" role="document">
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
                                            <th class="border-bottom-0">HARGA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($selectedInstruction)
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
                                        @if($selectedInstruction)
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
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($workSteps as $key => $dataWork)
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div wire:ignore>
                                                                <div class="form-group">
                                                                    <select style="width: 100%;" class="form-control work_step_list_id-{{ $key }}" data-clear data-pharaonic="select2" data-parent="#detailInstructionModalNewSpk" data-component-id="{{ $this->id }}" data-placeholder="Select Langkah Kerja" wire:model.defer="workSteps.{{ $key }}.work_step_list_id" id="work_step_list_id-{{ $key }}" required>
                                                                        <option label="Select Langkah Kerja"></option>
                                                                        @foreach ($dataWorkSteps as $dataWorkStep)
                                                                            <option value="{{ $dataWorkStep->id }}">{{ $dataWorkStep->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="date" wire:model="workSteps.{{ $key }}.target_date" id="workSteps.{{ $key }}.target_date" class="form-control" required>
                                                        @error('workSteps.{{ $key }}.target_date') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="date" wire:model="workSteps.{{ $key }}.schedule_date" id="workSteps.{{ $key }}.schedule_date" class="form-control" required>
                                                        @error('workSteps.{{ $key }}.schedule_date') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" wire:model="workSteps.{{ $key }}.target_time" id="workSteps.{{ $key }}.target_time" placeholder="Target Jam" class="form-control">
                                                        @error('workSteps.{{ $key }}.target_time') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div wire:ignore>
                                                                <div class="form-group">
                                                                    <select style="width: 100%;" class="form-control user_id" data-clear data-pharaonic="select2" data-parent="#detailInstructionModalNewSpk" data-component-id="{{ $this->id }}" data-placeholder="Select User" wire:model.defer="workSteps.{{ $key }}.user_id" id="user_id-{{ $key }}" required>
                                                                        <option label="Select User"></option>
                                                                        @foreach ($dataUsers as $dataUser)
                                                                        <option value="{{ $dataUser->id }}">{{ $dataUser->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div wire:ignore>
                                                                <div class="form-group">
                                                                    <select style="width: 100%;" class="form-control machine_id" data-clear data-pharaonic="select2" data-parent="#detailInstructionModalNewSpk" data-component-id="{{ $this->id }}" data-placeholder="Select Machine" wire:model.defer="workSteps.{{ $key }}.machine_id" id="machine_id-{{ $key }}">
                                                                        <option label="Select Machine"></option>
                                                                        @foreach ($dataMachines as $dataMachine)
                                                                        <option value="{{ $dataMachine->id }}">{{ $dataMachine->machine_identity }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-list">         
                                                        <button type="button" class="btn btn-icon btn-sm btn-success" wire:click="addField({{ $key }})"><i class="fe fe-plus"></i></button>
                                                        <button type="button" class="btn btn-icon btn-sm btn-danger" wire:click="removeField({{ $key }})"><i class="fe fe-x"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                    File Contoh <hr>
                                    <div class="d-flex text-center">
                                        <ul>
                                            @if ($selectedFileContoh)
                                                @foreach ($selectedFileContoh as $file)
                                                    <li class="mb-3">
                                                        <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                        <div class="expanel expanel-default">
                                                            <div class="expanel-body">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                    File Arsip <hr>
                                    <ul class="list-group no-margin">
                                        @if ($selectedFileArsip)
                                            @foreach ($selectedFileArsip as $file)
                                            <li class="list-group-item d-flex ps-3">
                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                            File Sample <hr>
                                            <ul class="list-group no-margin">
                                                @if ($selectedFileSample)
                                                    @foreach ($selectedFileSample as $file)
                                                    <li class="list-group-item d-flex ps-3">
                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                            <div class="expanel expanel-default">
                                <div class="expanel-body">
                                    File Accounting<hr>
                                    <ul class="list-group no-margin">
                                        @if ($selectedFileAccounting)
                                            @foreach ($selectedFileAccounting as $file)
                                            <li class="list-group-item d-flex ps-3">
                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                            File Layout <hr>
                                            <ul class="list-group no-margin">
                                                @if ($selectedFileLayout)
                                                    @foreach ($selectedFileLayout as $file)
                                                    <li class="list-group-item d-flex ps-3">
                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {{-- <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>
    </form>

    <!-- Modal Group-->
    <div wire:ignore.self class="modal fade" id="detailInstructionModalGroupNewSpk" tabindex="-1" role="dialog">
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
                                    <a role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                            {{ $selectedGroupParent->spk_number ?? '-' }} <span class="tag tag-blue">Parent</span>
                                        </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                                <div class="panel-body">
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
                                                            <th class="border-bottom-0">HARGA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->spk_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->customer_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_name ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->code_style ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->order_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->quantity ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->stock ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->price ?? '-' }}</td>
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
                                                        @if($selectedInstructionParent)
                                                        <tr>
                                                            <td>{{ $selectedInstructionParent->follow_up ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->taxes_type ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_parent ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->sub_spk ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->group_id ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_layout_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->spk_sample_number ?? '-' }}</td>
                                                            <td>{{ $selectedInstructionParent->shipping_date_first ?? '-' }}</td>
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
                                                        @if ($selectedWorkStepParent)
                                                            @foreach ($selectedWorkStepParent as $workstep)
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
                                                    File Contoh <hr>
                                                    <div class="d-flex text-center">
                                                        <ul>
                                                            @if ($selectedFileContohParent)
                                                                @foreach ($selectedFileContohParent as $file)
                                                                    <li class="mb-3">
                                                                        <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                        <div class="expanel expanel-default">
                                                                            <div class="expanel-body">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                    File Arsip <hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileArsipParent)
                                                            @foreach ($selectedFileArsipParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                            File Sample <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileSampleParent)
                                                                    @foreach ($selectedFileSampleParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                            <div class="expanel expanel-default">
                                                <div class="expanel-body">
                                                    File Accounting<hr>
                                                    <ul class="list-group no-margin">
                                                        @if ($selectedFileAccountingParent)
                                                            @foreach ($selectedFileAccountingParent as $file)
                                                            <li class="list-group-item d-flex ps-3">
                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                            File Layout <hr>
                                                            <ul class="list-group no-margin">
                                                                @if ($selectedFileLayoutParent)
                                                                    @foreach ($selectedFileLayoutParent as $file)
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                        @if($selectedInstructionChild)
                            @foreach ($selectedInstructionChild as $index => $data)
                            <?php $no++; ?>
                            <div class="panel panel-default mt-2">
                                <div class="panel-heading" role="tab" id="headingTwo2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse{{ $no }}" aria-expanded="false" aria-controls="collapse{{ $no }}">
    
                                                {{ $data->spk_number ?? '-' }} <span class="tag tag-red">Child</span>
                                            </a>
                                    </h4>
                                </div>
                                <div id="collapse{{ $no }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo2">
                                    <div class="panel-body">
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
                                                                <th class="border-bottom-0">HARGA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($data)
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
                                                            @if($data)
                                                            <tr>
                                                                <td>{{ $data->follow_up ?? '-' }}</td>
                                                                <td>{{ $data->spk_type ?? '-' }}</td>
                                                                <td>{{ $data->taxes_type ?? '-' }}</td>
                                                                <td>{{ $data->spk_parent ?? '-' }}</td>
                                                                <td>{{ $data->sub_spk ?? '-' }}</td>
                                                                <td>{{ $data->group_id ?? '-' }}</td>
                                                                <td>{{ $data->spk_layout_number ?? '-' }}</td>
                                                                <td>{{ $data->spk_sample_number ?? '-' }}</td>
                                                                <td>{{ $data->shipping_date_first ?? '-' }}</td>
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
                                                            @if($data->workstep)
                                                                @foreach ($data->workstep as $workstep)
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
                                                        File Contoh <hr>
                                                        <div class="d-flex text-center">
                                                            <ul>
                                                                @if ($data->fileArsip)
                                                                    @foreach ($data->fileArsip as $file)
                                                                    @if($file->type_file == 'contoh')
                                                                        <li class="mb-3">
                                                                            <img class="img-responsive" src="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" alt="File Contoh">
                                                                            <div class="expanel expanel-default">
                                                                                <div class="expanel-body">
                                                                                    <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                        File Arsip <hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'arsip')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                                File Sample <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'sample')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-body">
                                                        File Accounting<hr>
                                                        <ul class="list-group no-margin">
                                                            @if ($data->fileArsip)
                                                                @foreach ($data->fileArsip as $file)
                                                                @if($file->type_file == 'accounting')
                                                                    <li class="list-group-item d-flex ps-3">
                                                                        <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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
                                                                File Layout <hr>
                                                                <ul class="list-group no-margin">
                                                                    @if ($data->fileArsip)
                                                                        @foreach ($data->fileArsip as $file)
                                                                        @if($file->type_file == 'layout')
                                                                            <li class="list-group-item d-flex ps-3">
                                                                                <a href="{{ asset(Storage::url($file->file_path.'/'.$file->file_name)) }}" download>{{ $file->file_name }}</a>
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

    {{-- @livewire('component.detail-instruction') --}}
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-new-spk', event =>{
            $('#detailInstructionModalNewSpk').modal('hide');
            $('#detailInstructionModalGroupNewSpk').modal('hide');
        });

        window.addEventListener('show-detail-instruction-modal-new-spk', event =>{
            $('#detailInstructionModalNewSpk').modal('show');
        });

        window.addEventListener('show-detail-instruction-modal-group-new-spk', event =>{
            $('#detailInstructionModalGroupNewSpk').modal('show');
        });
    </script>
@endpush