<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
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

                <!-- ROW-2-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                            <div class="card-header">
                                <h3 class="card-title">{{ $title }}</h3>
                            </div>
                            <div class="card-body">
                                @livewire('follow-up.component.reorder-instruction-index', ['instructionId' => $instructions])
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-2 END -->


            </div>
            <!-- CONTAINER CLOSED -->
        </div>
    </div>
    <!--app-content closed-->
</div>
