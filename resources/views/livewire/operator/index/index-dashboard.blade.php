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
                                    @livewire('operator.component.tab-dashboard-index')
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
                                                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">New SPK</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('operator.component.new-spk-dashboard-index')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>

                                <div class="tab-pane" id="tab2">
                                    <!-- ROW-2-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-status bg-dark br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Incoming</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('operator.component.incoming-dashboard-index')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>
                                
                                @if(Auth()->user()->jobdesk == 'Checker')
                                <div class="tab-pane" id="tab3">
                                    <!-- ROW-2-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-status bg-success br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Complete Checker</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('operator.component.complete-checker-dashboard-index')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>
                                
                                <div class="tab-pane" id="tab4">
                                    <!-- ROW-2-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-status bg-success br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Layout Acc Customer</h3>
                                                </div>
                                                <div class="card-body">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ROW-2 END -->
                                </div>
                                @endif
                                

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
