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
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">SPK RAB - {{ $dataCountTotalSpkRab }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2" class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Pengajuan Barang SPK - {{ $dataCountTotalPengajuanBarangSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab4" class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Pengajuan Maklun - 
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
                                        <h3 class="card-title">New SPK RAB</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('accounting.component.new-spk-rab-dashboard-index')
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
                                                <button
                                                    class="btn btn-dark mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk1')"
                                                    wire:key="tabPengajuanBarangSpk1" href="#tabPengajuanBarangSpk1">New -
                                                    {{ $dataCountNewPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk2')"
                                                    wire:key="tabPengajuanBarangSpk2" href="#tabPengajuanBarangSpk2">Process -
                                                    {{ $dataCountProcessPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk3' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk3')"
                                                    wire:key="tabPengajuanBarangSpk3" href="#tabPengajuanBarangSpk3">Reject -
                                                    {{ $dataCountRejectPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-warning mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk4' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk4')"
                                                    wire:key="tabPengajuanBarangSpk4" href="#tabPengajuanBarangSpk4">Stock -
                                                    {{ $dataCountStockPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk5' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk5')"
                                                    wire:key="tabPengajuanBarangSpk5" href="#tabPengajuanBarangSpk5">Approved -
                                                    {{ $dataCountApprovedPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk6' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk6')"
                                                    wire:key="tabPengajuanBarangSpk6" href="#tabPengajuanBarangSpk6">Beli -
                                                    {{ $dataCountBeliPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk7' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangSpk('tabPengajuanBarangSpk7')"
                                                    wire:key="tabPengajuanBarangSpk7" href="#tabPengajuanBarangSpk7">Complete -
                                                    {{ $dataCountCompletePengajuanBarangSpk }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk1">
                                                <h5 class="card-title">New</h5>
                                                @livewire('accounting.component.pengajuan-new-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk2' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk2">
                                                <h5 class="card-title">Process</h5>
                                                @livewire('accounting.component.pengajuan-process-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk3' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk3">
                                                <h5 class="card-title">Reject</h5>
                                                @livewire('accounting.component.pengajuan-reject-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk4' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk4">
                                                <h5 class="card-title">Stock</h5>
                                                @livewire('accounting.component.pengajuan-stock-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk5' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk5">
                                                <h5 class="card-title">Approved</h5>
                                                @livewire('accounting.component.pengajuan-approved-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk6' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk6">
                                                <h5 class="card-title">Beli</h5>
                                                @livewire('accounting.component.pengajuan-beli-barang-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangSpk === 'tabPengajuanBarangSpk7' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk7">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('accounting.component.pengajuan-complete-barang-spk-index')
                                            </div>
                                        </div>
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
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Barang Personal</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('accounting.component.pengajuan-barang-personal-index')
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
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Maklun SPK</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('accounting.component.pengajuan-maklun-spk-index')
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
                                        @livewire('accounting.component.all-dashboard-index')
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