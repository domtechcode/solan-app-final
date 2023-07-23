<div>
    {{-- Do your work, then step back. --}}
    <form wire:submit.prevent="save">
    <!-- ROW-2-->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                <div class="card-header">
                    <h3 class="card-title">Form Setting</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 mb-3">
                            <table class="table border text-nowrap text-md-nowrap table-bordered table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">File</th>
                                        <th class="border-bottom-0">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fileLayoutData as $file)
                                    <tr>
                                        <td>
                                            <a href="{{ asset(Storage::url($file['file_path'].'/'.$file['file_name'])) }}" download>{{ $file['file_name'] }}</a>
                                        </td>
                                        <td>
                                            {{ $file['type_file'] }}
                                        </td>
                                    </tr> 
                                    @empty
                                        No Data !!
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">File Layout</label>
                                <x-forms.filepond
                                    wire:model="fileLayout"
                                    multiple
                                    allowImagePreview
                                    imagePreviewMaxHeight="200"
                                    allowFileTypeValidation
                                    allowFileSizeValidation
                                    maxFileSize="1024mb"
                                />
            
                                @error('fileLayout') <p class="mt-2 text-sm text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Catatan Proses Pengerjaan</label>
                            <div class="input-group control-group" style="padding-top: 5px;">
                                <textarea class="form-control mb-4" placeholder="Catatan" rows="4" wire:model="catatanProsesPengerjaan"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-2 END -->
    </form>
</div>
