@extends('layouts.main')

@section('content')
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

                <!-- ROW-1 -->
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <div class="card bg-dark img-card box-primary-shadow">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font">000000</h2>
                                        <p class="text-white mb-0">Total SPK</p>
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
                                        <h2 class="mb-0 number-font">000000</h2>
                                        <p class="text-white mb-0">SPK Proses</p>
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
                                        <h2 class="mb-0 number-font">000000</h2>
                                        <p class="text-white mb-0">SPK Pending</p>
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
                                        <h2 class="mb-0 number-font">000000</h2>
                                        <p class="text-white mb-0">SPK Complete</p>
                                    </div>
                                    <div class="ms-auto"> <i class="fe fe-check-square text-white fs-40 me-2 mt-2"></i> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-1 END -->


                <div class="row">
                    <div class="col-lg-12">
                        <!--Row-->
                        <div class="panel panel-primary">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li>
                                            <button href="#tab1" class="active btn btn-primary mt-1 mb-1 me-3"
                                                data-bs-toggle="tab">SPK
                                                <span class="badge bg-dark text-white ms-2"></span>
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
                                                <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                                                <div class="card-header">
                                                    <h3 class="card-title">Data Spk Baru</h3>
                                                </div>
                                                <div class="card-body">
                                                    @livewire('follow-up.dashboard')
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

    
@endsection
