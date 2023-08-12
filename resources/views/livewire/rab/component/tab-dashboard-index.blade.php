<div>
    {{-- In work, do what you enjoy. --}}
    <div class="row">
        <div class="col-lg-12">
            <!--Row-->
            <div class="panel panel-primary">
                <div class=" tab-menu-heading">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">
                            <li>
                                <button href="#tab1" class="{{ $activeTab === 'tab1' ? 'active' : '' }} btn btn-dark mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">New SPK - {{ $dataCountNewSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2" class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-primary mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Reject - {{ $dataCountRejectSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab3" class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-warning mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Incoming - {{ $dataCountIncomingSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab4" class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-danger mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Hold - {{ $dataCountHoldSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab5" class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">Pengajuan Barang SPK
                                </button>
                            </li>
                            <li>
                                <button href="#tab6" class="{{ $activeTab === 'tab6' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab6')" wire:key="tab6">Pengajuan Barang Personal
                                </button>
                            </li>
                            <li>
                                <button href="#tab7" class="{{ $activeTab === 'tab7' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab7')" wire:key="tab7">Pengajuan Maklun SPK
                                </button>
                            </li>
                            <li>
                                <button href="#tab8" class="{{ $activeTab === 'tab8' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab8')" wire:key="tab8">All - {{ $dataCountAllSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab9" class="{{ $activeTab === 'tab9' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab9')" wire:key="tab9">Last Data Training Program
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
                    <div class="tab-pane {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-dark br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">New SPK</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.new-spk-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-primary br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Reject</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.reject-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab3' ? 'active' : '' }}" id="tab3">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-warning br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Incoming</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.incoming-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab4' ? 'active' : '' }}" id="tab4">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-danger br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Hold</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.hold-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab5' ? 'active' : '' }}" id="tab5">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Barang SPK</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.pengajuan-barang-spk-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab6' ? 'active' : '' }}" id="tab6">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Barang Personal</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.pengajuan-barang-personal-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab7' ? 'active' : '' }}" id="tab7">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Maklun SPK</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.pengajuan-maklun-spk-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab8' ? 'active' : '' }}" id="tab8">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">All</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('rab.component.all-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab9' ? 'active' : '' }}" id="tab9">
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