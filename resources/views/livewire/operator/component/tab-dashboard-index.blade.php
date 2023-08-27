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
                                    class="{{ $activeTab === 'tab1' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">New Spk -
                                    {{ $dataCountNewSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2"
                                    class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-dark mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Incoming -
                                    {{ $dataCountIncomingSpk }}
                                </button>
                            </li>
                            @if (Auth()->user()->jobdesk == 'Checker')
                                <li>
                                    <button href="#tab3"
                                        class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-success mt-1 mb-1 me-3"
                                        data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Complete
                                        Checker - {{ $dataCountCompleteChecker }}
                                    </button>
                                </li>
                                <li>
                                    <button href="#tab4"
                                        class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-success mt-1 mb-1 me-3"
                                        data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Layout Acc
                                        Customer - {{ $dataCountCompleteCustomerChecker }}
                                    </button>
                                </li>
                            @endif
                            <li>
                                <button href="#tab5"
                                    class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-success mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">Selesai -
                                    {{ $dataCountSelesai }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab6"
                                    class="{{ $activeTab === 'tab6' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab6')" wire:key="tab6">Riwayat
                                    Pengajuan Barang
                                    - {{ $dataCountTotalPengajuanBarang }}
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

                    <div class="tab-pane {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2">
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

                    @if (Auth()->user()->jobdesk == 'Checker')
                        <div class="tab-pane {{ $activeTab === 'tab3' ? 'active' : '' }}" id="tab3">
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

                        <div class="tab-pane {{ $activeTab === 'tab4' ? 'active' : '' }}" id="tab4">
                            <!-- ROW-2-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-status bg-success br-te-7 br-ts-7"></div>
                                        <div class="card-header">
                                            <h3 class="card-title">Layout Acc Customer</h3>
                                        </div>
                                        <div class="card-body">
                                            @livewire('operator.component.complete-customer-checker-dashboard-index')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ROW-2 END -->
                        </div>
                    @endif

                    <div class="tab-pane {{ $activeTab === 'tab5' ? 'active' : '' }}" id="tab5">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-success br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Selesai</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('operator.component.selesai-dashboard-index')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ROW-2 END -->
                    </div>

                    <div class="tab-pane {{ $activeTab === 'tab6' ? 'active' : '' }}" id="tab6">
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
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal1')"
                                                    wire:key="tabPengajuanBarangPersonal1"
                                                    href="#tabPengajuanBarangPersonal1">Pengajuan Barang Personal -
                                                    {{ $dataCountPengajuanBarangPersonal }}</button>
                                            </li>
                                            @if (Auth()->user()->jobdesk == 'Setting' || Auth()->user()->jobdesk == 'Plate')
                                                <li class="nav-item">
                                                    <button
                                                        class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                        data-bs-toggle="tab"
                                                        wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangSpk1')"
                                                        wire:key="tabPengajuanBarangSpk1"
                                                        href="#tabPengajuanBarangSpk1">Pengajuan Barang SPK -
                                                        {{ $dataCountPengajuanBarangSpk }}</button>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal1">
                                                <h5 class="card-title">Pengajuan Barang Personal</h5>
                                                @livewire('component.riwayat-pengajuan-barang-personal-index')
                                            </div>
                                            @if (Auth()->user()->jobdesk == 'Setting' || Auth()->user()->jobdesk == 'Plate')
                                                <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                    id="tabPengajuanBarangSpk1">
                                                    <h5 class="card-title">Pengajuan Barang SPK</h5>
                                                    @livewire('component.riwayat-pengajuan-barang-spk-index')
                                                </div>
                                            @endif
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
