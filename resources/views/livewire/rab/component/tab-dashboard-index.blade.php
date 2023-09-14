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
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">New SPK -
                                    {{ $dataCountNewSpk }}
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
                                    class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-cyan mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Incoming -
                                    {{ $dataCountIncomingSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab4"
                                    class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-danger mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Hold -
                                    {{ $dataCountHoldSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab5"
                                    class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">Pengajuan Barang - {{ $dataCountPengajuanBarang }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab7"
                                    class="{{ $activeTab === 'tab7' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab7')" wire:key="tab7">Pengajuan Maklun
                                    SPK - {{ $dataCountPengajuanMaklun }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab8"
                                    class="{{ $activeTab === 'tab8' ? 'active' : '' }} btn btn-purple mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab8')" wire:key="tab8">Riwayat
                                    Pengajuan Barang
                                    - {{ $dataCountRiwayatPengajuanBarangPersonal }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab9"
                                    class="{{ $activeTab === 'tab9' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab9')" wire:key="tab9">All -
                                    {{ $dataCountAllSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab10"
                                    class="{{ $activeTab === 'tab10' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab10')" wire:key="tab10">Last Data
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
                                    <div class="card-status bg-cyan br-te-7 br-ts-7"></div>
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
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarang1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarang('tabPengajuanBarang1')"
                                                    wire:key="tabPengajuanBarang1" href="#tabPengajuanBarang1">Pengajuan Barang SPK -
                                                    {{ $dataCountPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarang2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarang('tabPengajuanBarang2')"
                                                    wire:key="tabPengajuanBarang2" href="#tabPengajuanBarang2">Pengajuan Barang Personal -
                                                    {{ $dataCountPengajuanBarangPersonal }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarang1' ? 'active' : '' }}"
                                                id="tabPengajuanBarang1">
                                                <h5 class="card-title">Pengajuan Barang SPK</h5>
                                                @livewire('rab.component.pengajuan-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarang2' ? 'active' : '' }}"
                                                id="tabPengajuanBarang2">
                                                <h5 class="card-title">Pengajuan Barang Personal</h5>
                                                @livewire('rab.component.pengajuan-barang-personal-index')
                                            </div>
                                        </div>
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
                                                    {{ $dataCountRiwayatPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal2')"
                                                    wire:key="tabPengajuanBarangPersonal2"
                                                    href="#tabPengajuanBarangPersonal2">Reject Pengajuan Barang Personal -
                                                    {{ $dataCountRejectPengajuanBarangPersonal }}</button>
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
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal2">
                                                <h5 class="card-title">Reject Pengajuan Barang Personal</h5>
                                                @livewire('component.riwayat-reject-pengajuan-barang-personal-index')
                                            </div>
                                        </div>
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
                    <div class="tab-pane {{ $activeTab === 'tab10' ? 'active' : '' }}" id="tab10">
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
