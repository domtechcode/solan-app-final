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
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">SPK -
                                    {{ $dataCountSpk }}
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
                                    class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-danger mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Hold -
                                    {{ $dataCountHoldSpk }}
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
                            <li>
                                <button href="#tab5"
                                    class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">All -
                                    {{ $dataCountAllSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab6"
                                    class="{{ $activeTab === 'tab6' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab6')" wire:key="tab6">Last Data
                                    Training Program
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
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk1')"
                                                    wire:key="tabSpk1" href="#tabSpk1">New SPK -
                                                    {{ $dataCountNewSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-green mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk2')"
                                                    wire:key="tabSpk2" href="#tabSpk2">Acc SPK -
                                                    {{ $dataCountAccSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk3')"
                                                    wire:key="tabSpk3" href="#tabSpk3">Complete -
                                                    {{ $dataCountCompleteSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-warning mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk4')"
                                                    wire:key="tabSpk4" href="#tabSpk4">Cancel -
                                                    {{ $dataCountCancelSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk5')"
                                                    wire:key="tabSpk5" href="#tabSpk5">Pengajuan Kekurangan Qc -
                                                    {{ $dataCountTotalPengajuanKekuranganQc }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}"
                                                id="tabSpk1">
                                                <h5 class="card-title">New SPK</h5>
                                                @livewire('follow-up.component.new-spk-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}"
                                                id="tabSpk2">
                                                <h5 class="card-title">Acc Spk</h5>
                                                @livewire('follow-up.component.acc-spk-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}"
                                                id="tabSpk3">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('follow-up.component.complete-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}"
                                                id="tabSpk4">
                                                <h5 class="card-title">Cancel</h5>
                                                @livewire('follow-up.component.cancel-dashboard-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}"
                                                id="tabSpk5">
                                                <h5 class="card-title">Pengajuan Kekurangan Qc</h5>
                                                @livewire('follow-up.component.pengajuan-kekurangan-qc-dashboard-index')
                                            </div>
                                        </div>
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
                                        @livewire('follow-up.component.reject-dashboard-index')
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
                                    <div class="card-status bg-danger br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Hold</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('follow-up.component.hold-dashboard-index')
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
                                        @livewire('follow-up.component.all-dashboard-index')
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
