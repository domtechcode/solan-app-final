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
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">Incoming - {{ $dataCountIncomingSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2" class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Manage SPK - {{ $dataCountManageSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab3" class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-cyan mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Operator
                                </button>
                            </li>
                            <li>
                                <button href="#tab4"
                                    class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-purple mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Riwayat
                                    Pengajuan Barang
                                    - {{ $dataCountTotalPengajuanBarang }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab5" class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">All
                                </button>
                            </li>
                            <li>
                                <button href="#tab6" class="{{ $activeTab === 'tab6' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab6')" wire:key="tab6">Last Data Training Program
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
                                        <h3 class="card-title">Incoming</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('penjadwalan.component.incoming-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk1')" wire:key="tabSpk1" href="#tabSpk1">New SPK - {{ $dataCountNewSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk2')" wire:key="tabSpk2" href="#tabSpk2">Selesai Dijadwalkan - {{  $dataCountReady }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk3')" wire:key="tabSpk3" href="#tabSpk3">Running - {{ $dataCountRunningSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk4')" wire:key="tabSpk4" href="#tabSpk4">Complete - {{ $dataCountComplete }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk5')" wire:key="tabSpk5" href="#tabSpk5">Reject - {{ $dataCountReject }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}" id="tabSpk1">
                                                <h5 class="card-title">New SPK</h5>
                                                @livewire('penjadwalan.component.new-spk-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}" id="tabSpk2">
                                                <h5 class="card-title">Selesai Dijadwalkan</h5>
                                                @livewire('penjadwalan.component.dijadwalkan-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}" id="tabSpk3">
                                                <h5 class="card-title">Running</h5>
                                                @livewire('penjadwalan.component.running-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}" id="tabSpk4">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('penjadwalan.component.complete-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}" id="tabSpk5">
                                                <h5 class="card-title">Reject</h5>
                                                @livewire('penjadwalan.component.reject-dashboard-index')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>
                    <div class="tab-pane {{ $activeTab === 'tab3' ? 'active' : '' }}" id="tab3">
                        {{-- <!-- ROW-2-->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-cyan br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator1' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator1')" wire:key="tabOperator1" href="#tabOperator1">Setting</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator2' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator2')" wire:key="tabOperator2" href="#tabOperator2">Checker</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator3' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator3')" wire:key="tabOperator3" href="#tabOperator3">Plate</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator4' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator4')" wire:key="tabOperator4" href="#tabOperator4">Potong Bahan</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator5' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator5')" wire:key="tabOperator5" href="#tabOperator5">Cetak</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator6' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator6')" wire:key="tabOperator6" href="#tabOperator6">Potong Jadi</button>
                                            </li>
                                            <li class="nav-item">
                                                <button class="btn btn-outline-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator7' ? 'active' : '' }}" data-bs-toggle="tab" wire:click="changeTabOperator('tabOperator7')" wire:key="tabOperator7" href="#tabOperator7">Pond</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator1' ? 'active' : '' }}" id="tabOperator1">
                                                <h5 class="card-title">Setting</h5>
                                                @livewire('penjadwalan.component.operator.setting-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator2' ? 'active' : '' }}" id="tabOperator2">
                                                <h5 class="card-title">Checker</h5>
                                                @livewire('penjadwalan.component.operator.checker-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator3' ? 'active' : '' }}" id="tabOperator3">
                                                <h5 class="card-title">Plate</h5>
                                                @livewire('penjadwalan.component.operator.plate-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator4' ? 'active' : '' }}" id="tabOperator4">
                                                <h5 class="card-title">Potong Bahan</h5>
                                                @livewire('penjadwalan.component.operator.potong-bahan-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator5' ? 'active' : '' }}" id="tabOperator5">
                                                <h5 class="card-title">Cetak</h5>
                                                @livewire('penjadwalan.component.operator.cetak-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator6' ? 'active' : '' }}" id="tabOperator6">
                                                <h5 class="card-title">Potong Jadi</h5>
                                                @livewire('penjadwalan.component.operator.potong-jadi-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabOperator === 'tabOperator7' ? 'active' : '' }}" id="tabOperator7">
                                                <h5 class="card-title">Pond</h5>
                                                @livewire('penjadwalan.component.operator.pond-dashboard-index')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END --> --}}
                        
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
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal1')"
                                                    wire:key="tabPengajuanBarangPersonal1" href="#tabPengajuanBarangPersonal1">Pengajuan Barang Personal -
                                                    {{ $dataCountPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangSpk1')"
                                                    wire:key="tabPengajuanBarangSpk1" href="#tabPengajuanBarangSpk1">Pengajuan Barang SPK -
                                                    {{ $dataCountPengajuanBarangSpk }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal1">
                                                <h5 class="card-title">Pengajuan Barang Personal</h5>
                                                @livewire('component.riwayat-pengajuan-barang-personal-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk1">
                                                <h5 class="card-title">Pengajuan Barang SPK</h5>
                                                @livewire('component.riwayat-pengajuan-barang-spk-index')
                                            </div>
                                        </div>
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
                                        <h3 class="card-title">All</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('penjadwalan.component.all-dashboard-index')
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