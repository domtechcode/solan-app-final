<div>
    {{-- Success is as dangerous as failure. --}}

    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Dashboard</h1>
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

                @livewire('component.statistik')

                <div class="row">
                    <div class="col-lg-12">
                        <!--Row-->
                        <div class="panel panel-primary">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li>
                                            <button href="#tab1" class="active btn btn-info mt-1 mb-1 me-3"
                                                data-bs-toggle="tab">All
                                            </button>
                                        </li>
                                        
                                        <li>
                                            <button href="#tab8" class="btn btn-info mt-1 mb-1 me-3"
                                                data-bs-toggle="tab">Last Data Training Program
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-status bg-dark br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">All</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('accounting.component.all-dashboard-index')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>
                                <div class="tab-pane" id="tab8">
                                    <!-- ROW-2-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Last Data Training Program</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('component.training-program-dashboard-index')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>

                            </div>
                        </div>
                        <!--End Row-->
                    </div>
                </div>


            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
    <!--app-content closed-->
</div>
