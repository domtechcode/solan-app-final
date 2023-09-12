<div>
    {{-- In work, do what you enjoy. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form User</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama User</label>
                                <div class="input-group">
                                    <input type="text" wire:model="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" autocomplete="off"
                                        placeholder="Nama User">
                                </div>
                                @error('name')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <div class="input-group">
                                    <select wire:model="role" id="role"
                                        class="form-control form-select @error('role') is-invalid @enderror"
                                        data-bs-placeholder="Pilih Role">
                                        <option label="-- Pilih Role --"></option>
                                        <option value="Admin">Admin</option>
                                        <option value="Follow Up">Follow Up</option>
                                        <option value="Hitung Bahan">Hitung Bahan</option>
                                        <option value="RAB">RAB</option>
                                        <option value="Stock">Stock</option>
                                        <option value="Operator">Operator</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Accounting">Accounting</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Job Desk</label>
                                <div class="input-group">
                                    <select wire:model="jobdesk" id="jobdesk"
                                        class="form-control form-select @error('jobdesk') is-invalid @enderror"
                                        data-bs-placeholder="Pilih Jobdesk">
                                        <option label="-- Pilih Jobdesk --"></option>
                                        <option value="Admin">Admin</option>
                                        <option value="Follow Up">Follow Up</option>
                                        <option value="Hitung Bahan">Hitung Bahan</option>
                                        <option value="RAB">RAB</option>
                                        <option value="Stock">Stock</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Team Finishing">Team Finishing</option>
                                        <option value="Team Qc Packing">Team Qc Packing</option>
                                        @foreach ($dataJobDesk as $data)
                                            <option value="{{ $data->desc_job }}">{{ $data->desc_job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jobdesk')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <input type="text" wire:model="username" id="username"
                                        class="form-control @error('username') is-invalid @enderror" autocomplete="off"
                                        placeholder="Username">
                                </div>
                                @error('username')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" wire:model="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" autocomplete="off"
                                        placeholder="Password">
                                </div>
                                @error('password')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-4 mb-0" wire:click="save"
                        wire:key="save">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->

    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Data User</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <select id="" name="" class="form-control form-select w-auto"
                                wire:model="paginateUser">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <input type="text" class="form-control w-auto" placeholder="Search"
                                wire:model="searchUser">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">No</th>
                                            <th class="border-bottom-0">Name</th>
                                            <th class="border-bottom-0">Username</th>
                                            <th class="border-bottom-0">Role</th>
                                            <th class="border-bottom-0">Job Desk</th>
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataUser as $key => $user)
                                            <tr wire:key="{{ $user->id }}">
                                                <td>{{ $key + 1 }}</td>

                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>{{ $user->jobdesk }}</td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button type="button" class="btn btn-icon btn-sm btn-dark"
                                                            data-bs-toggle="modal" data-bs-target="#openModalUser"
                                                            wire:click="modalDetailsUser({{ $user->id }})"
                                                            wire:key="modalDetailsUser({{ $user->id }})"><i
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
                            {{ $dataUser->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="openModalUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail User</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama User</label>
                                <div class="input-group">
                                    <input type="text" wire:model="nameUpdate" id="nameUpdate"
                                        class="form-control @error('nameUpdate') is-invalid @enderror"
                                        autocomplete="off" placeholder="Nama User">
                                </div>
                                @error('nameUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Role</label>
                                <div class="input-group">
                                    <select wire:model="roleUpdate" id="roleUpdate"
                                        class="form-control form-select @error('roleUpdate') is-invalid @enderror"
                                        data-bs-placeholder="Pilih Role">
                                        <option label="-- Pilih Role --"></option>
                                        <option value="Admin">Admin</option>
                                        <option value="Follow Up">Follow Up</option>
                                        <option value="Hitung Bahan">Hitung Bahan</option>
                                        <option value="RAB">RAB</option>
                                        <option value="Stock">Stock</option>
                                        <option value="Operator">Operator</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Accounting">Accounting</option>
                                    </select>
                                </div>
                                @error('roleUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Job Desk</label>
                                <div class="input-group">
                                    <select wire:model="jobdeskUpdate" id="jobdeskUpdate"
                                        class="form-control form-select @error('jobdeskUpdate') is-invalid @enderror"
                                        data-bs-placeholder="Pilih Jobdesk">
                                        <option label="-- Pilih Jobdesk --"></option>
                                        <option value="Admin">Admin</option>
                                        <option value="Follow Up">Follow Up</option>
                                        <option value="Hitung Bahan">Hitung Bahan</option>
                                        <option value="RAB">RAB</option>
                                        <option value="Stock">Stock</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Team Finishing">Team Finishing</option>
                                        <option value="Team Qc Packing">Team Qc Packing</option>
                                        @foreach ($dataJobDesk as $data)
                                            <option value="{{ $data->desc_job }}">{{ $data->desc_job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jobdeskUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <input type="text" wire:model="usernameUpdate" id="usernameUpdate"
                                        class="form-control @error('usernameUpdate') is-invalid @enderror"
                                        autocomplete="off" placeholder="Username">
                                </div>
                                @error('usernameUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" wire:model="passwordUpdate" id="passwordUpdate"
                                        class="form-control @error('passwordUpdate') is-invalid @enderror"
                                        autocomplete="off" placeholder="Password">
                                </div>
                                @error('passwordUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="text" wire:model="currentUpdate" id="currentUpdate"
                                        class="form-control @error('currentUpdate') is-invalid @enderror"
                                        autocomplete="off" placeholder="Password" readonly>
                                </div>
                                @error('currentUpdate')
                                    <div><span class="text-danger">{{ $message }}</span></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" wire:click="update" wire:key="update">Update</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal-user', event => {
            $('#openModalUser').modal('hide');
        });
    </script>
@endpush
