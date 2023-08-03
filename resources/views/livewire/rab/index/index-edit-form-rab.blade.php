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

                    @if (isset($notereject))
                        @foreach ($notereject as $datanotereject)
                            @if (isset($datanotereject))
                                <div class="row row-sm mb-5">
                                    <div class="text-wrap">
                                        <div class="">
                                            <div class="alert alert-danger">
                                                <span class=""><svg xmlns="http://www.w3.org/2000/svg" height="40" width="40" viewBox="0 0 24 24"><path fill="#f07f8f" d="M20.05713,22H3.94287A3.02288,3.02288,0,0,1,1.3252,17.46631L9.38232,3.51123a3.02272,3.02272,0,0,1,5.23536,0L22.6748,17.46631A3.02288,3.02288,0,0,1,20.05713,22Z"/><circle cx="12" cy="17" r="1" fill="#e62a45"/><path fill="#e62a45" d="M12,14a1,1,0,0,1-1-1V9a1,1,0,0,1,2,0v4A1,1,0,0,1,12,14Z"/></svg></span>
                                                <strong>Catatan Reject Dari Operator : {{ $datanotereject->user->name }}</strong>
                                                <hr class="message-inner-separator">
                                                <p>{{ $datanotereject->catatan }}</p>
                                                <div class="d-flex justify-content-end">
                                                    <small>{{ $datanotereject->created_at }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif


                    <div class="row mb-5">
                        <div class="col-md-7 overflow-auto" style="height: 100vh;">
                            @livewire('component.hitung-bahan-data-view-rab-index', ['instructionId' => $instructionSelectedId, 'workStepId' => $workStepSelectedId])
                        </div>
                        <div class="col-md-5 overflow-auto" style="height: 100vh;">
                            @livewire('rab.component.edit-form-rab-index', ['instructionId' => $instructionSelectedId])
                        </div>
                    </div>    
                </div>
                <!-- CONTAINER CLOSED -->
            </div>
        </div>
        <!--app-content closed-->
    </div>
    
</div>
