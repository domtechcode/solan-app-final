<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
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
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No</th>
                            <th class="border-bottom-0">Customer Name</th>
                            <th class="border-bottom-0">Type Taxes</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->taxes }}</td>
                                <td>
                                    <div class="btn-list">
                                        <button class="btn btn-icon btn-sm btn-primary"
                                            wire:click="modalCustomerEdit({{ $data->id }})"><i
                                                class="fe fe-edit"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            No Data !!!
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col d-flex justify-content-end mt-3">
            {{ $customers->links() }}
        </div>
    </div>


    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="modalCustomerEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Customer</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Row -->
                    @if (isset($name) && isset($taxes))
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Nama Customer</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror" autocomplete="off"
                                            placeholder="Nama Customer" readonly>
                                    </div>
                                    @error('name')
                                        <div><span class="text-danger">{{ $message }}</span></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Taxes Type <span class="text-red">*</span></label>
                                    <div class="row">
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="taxes"
                                                    class="custom-switch-input @error('taxes') is-invalid @enderror"
                                                    value="pajak">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Pajak</span>
                                            </label>
                                        </div>
                                        <div class="col-auto">
                                            <label class="custom-switch form-switch me-5">
                                                <input type="radio" wire:model="taxes"
                                                    class="custom-switch-input @error('taxes') is-invalid @enderror"
                                                    value="nonpajak">
                                                <span class="custom-switch-indicator custom-switch-indicator-md"></span>
                                                <span class="custom-switch-description">Non Pajak</span>
                                            </label>
                                        </div>
                                        @error('taxes')
                                            <div><span class="text-danger">{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" wire:click="update">Submit & Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-detail-customer-edit', event =>{
            $('#modalCustomerEdit').modal('hide');
        });

        window.addEventListener('show-detail-customer-edit', event =>{
            $('#modalCustomerEdit').modal('show');
        });
    </script>
@endpush