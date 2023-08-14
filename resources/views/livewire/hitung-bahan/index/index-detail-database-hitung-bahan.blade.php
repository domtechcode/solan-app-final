<div>
    {{-- The Master doesn't talk, he acts. --}}

    <div>
        {{-- In work, do what you enjoy. --}}
        <!--app-content open-->
        <div class="main-content app-content mt-0">
            <div class="side-app">
    
                <!-- CONTAINER -->
                <div class="main-container container-fluid">
    
                    <!-- PAGE-HEADER -->
                    <div class="page-header">
                        <h1 class="page-title">{{ $title }}</h1>
                        <div>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->
    
                    @if (session()->has('success'))
                    {{-- Notif --}}
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <span class="alert-inner--icon"><i class="fe fe-check"></i></span>
                        <span class="alert-inner--text"><strong>Berhasil !!!</strong> {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                    </div>
                    {{-- End Notif --}}
                    @endif
    
                    @if (session()->has('error'))
                    {{-- Notif --}}
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
                        <span class="alert-inner--text"><strong>Gagal !!!</strong> {{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                    </div>
                    {{-- End Notif --}}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            @livewire('component.hitung-bahan-all-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                        </div>
                    </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!--app-content closed-->
    </div>
    
</div>
