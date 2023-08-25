<div>
    {{-- In work, do what you enjoy. --}}
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Langkah Kerja</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Langkah Kerja</label>
                                <div class="input-group">
                                    <input type="text" wire:model="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" autocomplete="off"
                                        placeholder="Nama Langkah Kerja">
                                </div>
                                @error('name')
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
                    <h3 class="card-title">Data Langkah Kerja</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <select id="" name="" class="form-control form-select w-auto"
                                wire:model="paginateLangkahKerja">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <input type="text" class="form-control w-auto" placeholder="Search"
                                wire:model="searchLangkahKerja">
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
                                            <th class="border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataLangkahKerja as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>
                                                    <div class="btn-list">
                                                        <button type="button" class="btn btn-icon btn-sm btn-dark"
                                                            data-bs-toggle="modal" data-bs-target="#openModalLangkahKerja"
                                                            wire:click="modalDetailsLangkahKerja({{ $data->id }})"
                                                            wire:key="modalDetailsLangkahKerja({{ $data->id }})"><i
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
                            {{ $dataLangkahKerja->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->

    <!-- Modal General-->
    <div wire:ignore.self class="modal fade" id="openModalLangkahKerja" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Langkah Kerja</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Langkah Kerja</label>
                                <div class="input-group">
                                    <input type="text" wire:model="nameUpdate" id="nameUpdate"
                                        class="form-control @error('nameUpdate') is-invalid @enderror" autocomplete="off"
                                        placeholder="Nama Langkah Kerja">
                                </div>
                                @error('nameUpdate')
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
        window.addEventListener('close-modal-langkah-kerja', event => {
            $('#openModalLangkahKerja').modal('hide');
        });
    </script>
@endpush