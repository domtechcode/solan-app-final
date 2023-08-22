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
                                <button href="#tab3" class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Pengajuan Barang Personal - {{ $dataCountTotalPengajuanBarangPersonal }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab4" class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Pengajuan Maklun - {{ $dataCountTotalPengajuanMaklun }}
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
                            <li>
                                <button href="#tab7" class="{{ $activeTab === 'tab7' ? 'active' : '' }} btn btn-success mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab7')" wire:key="tab7">Complete RAB
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
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-dark mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal1')"
                                                    wire:key="tabPengajuanBarangPersonal1" href="#tabPengajuanBarangPersonal1">New -
                                                    {{ $dataCountNewPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal2')"
                                                    wire:key="tabPengajuanBarangPersonal2" href="#tabPengajuanBarangPersonal2">Process -
                                                    {{ $dataCountProcessPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal3' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal3')"
                                                    wire:key="tabPengajuanBarangPersonal3" href="#tabPengajuanBarangPersonal3">Reject -
                                                    {{ $dataCountRejectPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-warning mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal4' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal4')"
                                                    wire:key="tabPengajuanBarangPersonal4" href="#tabPengajuanBarangPersonal4">Stock -
                                                    {{ $dataCountStockPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal5' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal5')"
                                                    wire:key="tabPengajuanBarangPersonal5" href="#tabPengajuanBarangPersonal5">Approved -
                                                    {{ $dataCountApprovedPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal6' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal6')"
                                                    wire:key="tabPengajuanBarangPersonal6" href="#tabPengajuanBarangPersonal6">Beli -
                                                    {{ $dataCountBeliPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal7' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal7')"
                                                    wire:key="tabPengajuanBarangPersonal7" href="#tabPengajuanBarangPersonal7">Complete -
                                                    {{ $dataCountCompletePengajuanBarangPersonal }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal1">
                                                <h5 class="card-title">New</h5>
                                                @livewire('accounting.component.pengajuan-new-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal2">
                                                <h5 class="card-title">Process</h5>
                                                @livewire('accounting.component.pengajuan-process-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal3' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal3">
                                                <h5 class="card-title">Reject</h5>
                                                @livewire('accounting.component.pengajuan-reject-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal4' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal4">
                                                <h5 class="card-title">Stock</h5>
                                                @livewire('accounting.component.pengajuan-stock-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal5' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal5">
                                                <h5 class="card-title">Approved</h5>
                                                @livewire('accounting.component.pengajuan-approved-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal6' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal6">
                                                <h5 class="card-title">Beli</h5>
                                                @livewire('accounting.component.pengajuan-beli-barang-personal-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanBarangPersonal === 'tabPengajuanBarangPersonal7' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk7">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('accounting.component.pengajuan-complete-barang-personal-index')
                                            </div>
                                        </div>
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
                                                    class="btn btn-dark mt-1 mb-1 me-3 {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanMaklun('tabPengajuanMaklun1')"
                                                    wire:key="tabPengajuanMaklun1" href="#tabPengajuanMaklun1">New -
                                                    {{ $dataCountNewPengajuanMaklun }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanMaklun('tabPengajuanMaklun2')"
                                                    wire:key="tabPengajuanMaklun2" href="#tabPengajuanMaklun2">Process -
                                                    {{ $dataCountProcessPengajuanMaklun }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun3' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanMaklun('tabPengajuanMaklun3')"
                                                    wire:key="tabPengajuanMaklun3" href="#tabPengajuanMaklun3">Reject -
                                                    {{ $dataCountRejectPengajuanMaklun }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun4' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanMaklun('tabPengajuanMaklun4')"
                                                    wire:key="tabPengajuanMaklun4" href="#tabPengajuanMaklun4">Approved -
                                                    {{ $dataCountApprovedPengajuanMaklun }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun5' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabPengajuanMaklun('tabPengajuanMaklun5')"
                                                    wire:key="tabPengajuanMaklun5" href="#tabPengajuanMaklun5">Complete -
                                                    {{ $dataCountCompletePengajuanMaklun }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun1' ? 'active' : '' }}"
                                                id="tabPengajuanMaklun1">
                                                <h5 class="card-title">New</h5>
                                                @livewire('accounting.component.pengajuan-new-maklun-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun2' ? 'active' : '' }}"
                                                id="tabPengajuanMaklun2">
                                                <h5 class="card-title">Process</h5>
                                                @livewire('accounting.component.pengajuan-process-maklun-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun3' ? 'active' : '' }}"
                                                id="tabPengajuanMaklun3">
                                                <h5 class="card-title">Reject</h5>
                                                @livewire('accounting.component.pengajuan-reject-maklun-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun4' ? 'active' : '' }}"
                                                id="tabPengajuanMaklun4">
                                                <h5 class="card-title">Approved</h5>
                                                @livewire('accounting.component.pengajuan-approved-maklun-spk-index')
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabPengajuanMaklun === 'tabPengajuanMaklun5' ? 'active' : '' }}"
                                                id="tabPengajuanMaklun5">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('accounting.component.pengajuan-complete-maklun-spk-index')
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
                    <div class="tab-pane {{ $activeTab === 'tab7' ? 'active' : '' }}" id="tab7">
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Last Data Training Program</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('accounting.component.complete-spk-rab-dashboard-index')
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