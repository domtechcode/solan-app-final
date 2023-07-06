<div>
    {{-- The Master doesn't talk, he acts. --}}
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
                            {{-- <th class="border-bottom-0">Type SPK</th>
                            <th class="border-bottom-0">Pemesan</th>
                            <th class="border-bottom-0">Order</th>
                            <th class="border-bottom-0">No Po</th>
                            <th class="border-bottom-0">Style</th>
                            <th class="border-bottom-0">TGL Kirim</th>
                            <th class="border-bottom-0">Total Qty</th> --}}
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Pekerjaan</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        @foreach ($instructions as $instruction)
                        <?php $no++; ?>
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $instruction->name }}</td>
                            <td>
                                <div class="mt-sm-1 d-block">
                                    <span class="badge bg-info rounded-pill text-white p-2 px-3">Process</span>
                                </div>
                            </td>
                            <td>
                                <div class="mt-sm-1 d-block">
                                    <span class="badge bg-info rounded-pill text-white p-2 px-3">Follow Up</span>
                                </div>
                            </td>
                            <td>
                                <div class="btn-list">         
                                    <button class="btn btn-icon btn-sm btn-dark" href=""><i class="fe fe-eye"></i></button>
                                    <button class="btn btn-icon btn-sm btn-primary" href=""><i class="fe fe-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

            </div>
            
        </div>
        <div class="col d-flex justify-content-end mt-3">
            {{ $instructions->links() }}
        </div>
    </div>
    
</div>
