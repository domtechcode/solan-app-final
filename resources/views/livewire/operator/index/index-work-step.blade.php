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
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-lg-12">
                                <!--Row-->
                                <div class="panel panel-primary">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li>
                                                    <button href="#tab1" class="active btn btn-dark mt-1 mb-1 me-3"
                                                        data-bs-toggle="tab">Order
                                                    </button>
                                                </li>
                                                <li>
                                                    <button href="#tab2" class="btn btn-primary mt-1 mb-1 me-3"
                                                        data-bs-toggle="tab">Details
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--Row End-->
                    
                                <!--Row -->
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <!-- ROW-2-->
                                            @livewire('component.hitung-bahan-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])

                                            @if($workStepData->work_step_list_id == 6)
                                                <!-- Setting -->
                                                @livewire('component.operator.form-setting-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 37)
                                                <!-- Setting -->
                                                @livewire('component.operator.form-checker-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @else

                                            @endif
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            @livewire('component.detail-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                        </div>
                                    </div>
                                </div>
                                <!--End Row-->
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4">
                            @livewire('component.timer-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                            @livewire('component.reject-operator-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                        </div>
                      </div>

                    {{-- <div class="row mb-5">
                        <div class="col-md-7">
                            
                        </div>
                        <div class="col-md-5">
                            
                        </div>
                    </div> --}}
    
                    
                    
    
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!--app-content closed-->
    </div>
    
</div>
