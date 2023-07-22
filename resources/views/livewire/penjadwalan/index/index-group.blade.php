<div>
    {{-- Success is as dangerous as failure. --}}

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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Home</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

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
                                                data-bs-toggle="tab">Group SPK
                                            </button>
                                        </li>
                                        <li>
                                            <button href="#tab2" class="btn btn-primary mt-1 mb-1 me-3"
                                                data-bs-toggle="tab">Ungroup SPK
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
                                                <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Group SPK</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('component.group-index')
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
                                                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Ungroup SPK</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('component.ungroup-index')
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
