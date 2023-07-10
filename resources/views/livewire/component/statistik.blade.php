<div>
    {{-- In work, do what you enjoy. --}}
    <!-- ROW-1 -->
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="card bg-dark img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $totalOrder }}</h2>
                            <p class="text-white mb-0">Total SPK</p>
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Layout</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkLayout }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Sample</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkSample }}</span>
                                </button>
                            </div>
                            <div class="btn-list mt-2">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Production</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkProduction }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Stock</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkStock }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-package text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="card bg-info img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $prosesOrder }}</h2>
                            <p class="text-white mb-0">SPK Proses</p>
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Layout</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkProsesLayout }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Sample</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkProsesSample }}</span>
                                </button>
                            </div>
                            <div class="btn-list mt-2">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Production</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkProsesProduction }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Stock</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkProsesStock }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-file-text text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="card bg-danger img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $pendingOrder }}</h2>
                            <p class="text-white mb-0">SPK Pending</p>
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Layout</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkPendingLayout }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Sample</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkPendingSample }}</span>
                                </button>
                            </div>
                            <div class="btn-list mt-2">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Production</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkPendingProduction }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Stock</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkPendingStock }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-x-square text-white fs-40 me-2 mt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="card bg-success img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $completeOrder }}</h2>
                            <p class="text-white mb-0">SPK Complete</p>
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Layout</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkCompleteLayout }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Sample</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkCompleteSample }}</span>
                                </button>
                            </div>
                            <div class="btn-list mt-2">
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Production</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkCompleteProduction }}</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-purple mt-1 mb-1 me-3">
                                    <span>SPK Stock</span>
                                    <span class="badge bg-white text-primary ms-2">{{ $spkCompleteStock }}</span>
                                </button>
                            </div>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-check-square text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->
</div>
