<div>
    {{-- Stop trying to control. --}}
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Detail Langkah Kerja</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Detail Langkah Kerja</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

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
                                            @if ($workStepData->user_id == 50)
                                                @livewire('component.hitung-bahan-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                @livewire('component.details.form-maklun-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                            @else
                                                @if ($workStepData->work_step_list_id == 5)
                                                    @livewire('component.hitung-bahan-data-view-rab-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                @elseif ($workStepData->work_step_list_id == 3)
                                                    @livewire('component.hitung-bahan-all-data-rab-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                @else
                                                    @livewire('component.hitung-bahan-data-view-general-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @if ($workStepData->work_step_list_id == 6)
                                                        <!-- Setting -->
                                                        @livewire('component.details.form-setting-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 37)
                                                        <!-- Checker -->
                                                        @livewire('component.details.form-checker-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 7)
                                                        <!-- Plate -->
                                                        @livewire('component.details.form-plate-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 8 || $workStepData->work_step_list_id == 9)
                                                        <!-- Potong Bahan & Potong Jadi -->
                                                        @livewire('component.details.form-potong-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 10)
                                                        <!-- Cetak -->
                                                        @livewire('component.details.form-cetak-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 11)
                                                        <!-- Cetak -->
                                                        @livewire('component.details.form-sortir-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 23)
                                                        <!-- Sablon -->
                                                        @livewire('component.details.form-sablon-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif(
                                                        $workStepData->work_step_list_id == 24 ||
                                                            $workStepData->work_step_list_id == 25 ||
                                                            $workStepData->work_step_list_id == 26 ||
                                                            $workStepData->work_step_list_id == 27 ||
                                                            $workStepData->work_step_list_id == 29)
                                                        <!-- Pond -->
                                                        @livewire('component.details.form-pond-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 28)
                                                        <!-- Pond -->
                                                        @livewire('component.details.form-foil-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 32 || $workStepData->work_step_list_id == 33)
                                                        <!-- Potong Bahan & Potong Jadi -->
                                                        @livewire('component.details.form-lem-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 12)
                                                        <!-- Potong Bahan & Potong Jadi -->
                                                        @livewire('component.details.form-cetak-label-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 35)
                                                        <!-- Potong Bahan & Potong Jadi -->
                                                        @livewire('component.details.form-qc-packing-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 36)
                                                        <!-- Pengiriman -->
                                                        @livewire('component.details.form-pengiriman-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @elseif($workStepData->work_step_list_id == 45)
                                                        <!-- Pengiriman -->
                                                        @livewire('component.details.form-lipat-pinggir-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @else
                                                        <!-- WorkStep Lain -->
                                                        @livewire('component.details.form-other-work-step-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                                                    @endif
                                                @endif
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
                        @livewire('component.details.timer-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                    </div>

                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!--app-content closed-->
    </div>
