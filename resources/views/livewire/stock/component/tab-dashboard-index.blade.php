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
                                <button href="#tab1"
                                    class="{{ $activeTab === 'tab1' ? 'active' : '' }} btn btn-dark mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">New
                                    SPK - {{ $dataCountNewSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2"
                                    class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-primary mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Reject -
                                    {{ $dataCountRejectSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab3"
                                    class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-success mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Complete -
                                    {{ $dataCountCompleteSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab4"
                                    class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-purple mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Riwayat
                                    Pengajuan Barang
                                    - {{ $dataCountPengajuanBarangPersonal }}
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
                                        @livewire('stock.component.new-spk-dashboard-index')
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
                                        @livewire('stock.component.reject-dashboard-index')
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
                                    <div class="card-status bg-success br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Complete</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('stock.component.complete-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab4' ? 'active' : '' }}" id="tab4">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal1')"
                                                    wire:key="tabPengajuanBarangPersonal1" href="#tabPengajuanBarangPersonal1">Pengajuan Barang Personal -
                                                    {{ $dataCountPengajuanBarangPersonal }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal1">
                                                <h5 class="card-title">Pengajuan Barang Personal</h5>
                                                @livewire('component.riwayat-pengajuan-barang-personal-index')
                                            </div>
                                        </div>
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
