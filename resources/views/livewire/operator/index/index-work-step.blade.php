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
                        @if($workStepData->work_step_list_id == 36)
                        <div class="col-md-12">
                        @else
                        <div class="col-md-8">
                        @endif
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
                                            @if($workStepData->work_step_list_id == 36)
                                                <!-- ROW-2-->
                                                @livewire('component.hitung-bahan-data-view-pengiriman-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @else
                                                @livewire('component.hitung-bahan-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @endif

                                            @if($workStepData->work_step_list_id == 6)
                                                <!-- Setting -->
                                                @livewire('component.operator.form-setting-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 37)
                                                <!-- Checker -->
                                                @livewire('component.operator.form-checker-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 7)
                                                <!-- Plate -->
                                                @livewire('component.operator.form-plate-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 8 || $workStepData->work_step_list_id == 9)
                                                <!-- Potong Bahan & Potong Jadi -->
                                                @livewire('component.operator.form-potong-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 10)
                                                <!-- Cetak -->
                                                @livewire('component.operator.form-cetak-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 23)
                                                <!-- Sablon -->
                                                @livewire('component.operator.form-sablon-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 24 || $workStepData->work_step_list_id == 25 || $workStepData->work_step_list_id == 26 || $workStepData->work_step_list_id == 27 || $workStepData->work_step_list_id == 29)
                                                <!-- Pond -->
                                                @livewire('component.operator.form-pond-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 32 || $workStepData->work_step_list_id == 33)
                                                <!-- Potong Bahan & Potong Jadi -->
                                                @livewire('component.operator.form-lem-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 12)
                                                <!-- Potong Bahan & Potong Jadi -->
                                                @livewire('component.operator.form-cetak-label-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 35)
                                                <!-- Potong Bahan & Potong Jadi -->
                                                @livewire('component.operator.form-qc-packing-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @elseif($workStepData->work_step_list_id == 36)
                                                <!-- Pengiriman -->
                                                @livewire('component.operator.form-pengiriman-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @else
                                                <!-- WorkStep Lain -->
                                                @livewire('component.operator.form-other-work-step-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
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
                            @if($workStepData->work_step_list_id != 36)
                                @livewire('component.timer-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                @livewire('component.reject-operator-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                            @endif
                        </div>
                      </div>
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!--app-content closed-->
    </div>
    
</div>
