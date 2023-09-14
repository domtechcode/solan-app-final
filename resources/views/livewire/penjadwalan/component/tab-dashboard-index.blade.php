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
                                    data-bs-toggle="tab" wire:click="changeTab('tab1')" wire:key="tab1">Incoming -
                                    {{ $dataCountIncomingSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab2"
                                    class="{{ $activeTab === 'tab2' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab2')" wire:key="tab2">Manage SPK -
                                    {{ $dataCountManageSpk }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab3"
                                    class="{{ $activeTab === 'tab3' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab3')" wire:key="tab3">Manage Operator
                                </button>
                            </li>
                            <li>
                                <button href="#tab4"
                                    class="{{ $activeTab === 'tab4' ? 'active' : '' }} btn btn-cyan mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab4')" wire:key="tab4">Pengajuan
                                    Kekurangan Qc -
                                    {{ $dataCountTotalPengajuanKekuranganQc }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab5"
                                    class="{{ $activeTab === 'tab5' ? 'active' : '' }} btn btn-purple mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab5')" wire:key="tab5">Riwayat
                                    Pengajuan Barang
                                    - {{ $dataCountTotalPengajuanBarang }}
                                </button>
                            </li>
                            <li>
                                <button href="#tab6"
                                    class="{{ $activeTab === 'tab6' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab6')" wire:key="tab6">All
                                </button>
                            </li>
                            <li>
                                <button href="#tab7"
                                    class="{{ $activeTab === 'tab7' ? 'active' : '' }} btn btn-info mt-1 mb-1 me-3"
                                    data-bs-toggle="tab" wire:click="changeTab('tab7')" wire:key="tab7">Last Data
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
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk1')"
                                                    wire:key="tabSpk1" href="#tabSpk1">New SPK -
                                                    {{ $dataCountNewSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk2')"
                                                    wire:key="tabSpk2" href="#tabSpk2">Selesai Dijadwalkan -
                                                    {{ $dataCountReady }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk3')"
                                                    wire:key="tabSpk3" href="#tabSpk3">Running -
                                                    {{ $dataCountRunningSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-success mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk4')"
                                                    wire:key="tabSpk4" href="#tabSpk4">Complete -
                                                    {{ $dataCountComplete }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}"
                                                    data-bs-toggle="tab" wire:click="changeTabSpk('tabSpk5')"
                                                    wire:key="tabSpk5" href="#tabSpk5">Reject -
                                                    {{ $dataCountReject }}</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk1' ? 'active' : '' }}"
                                                id="tabSpk1">
                                                <h5 class="card-title">New SPK</h5>
                                                @livewire('penjadwalan.component.new-spk-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk2' ? 'active' : '' }}"
                                                id="tabSpk2">
                                                <h5 class="card-title">Selesai Dijadwalkan</h5>
                                                @livewire('penjadwalan.component.dijadwalkan-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk3' ? 'active' : '' }}"
                                                id="tabSpk3">
                                                <h5 class="card-title">Running</h5>
                                                @livewire('penjadwalan.component.running-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk4' ? 'active' : '' }}"
                                                id="tabSpk4">
                                                <h5 class="card-title">Complete</h5>
                                                @livewire('penjadwalan.component.complete-dashboard-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabSpk === 'tabSpk5' ? 'active' : '' }}"
                                                id="tabSpk5">
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
                        <!-- ROW-2-->
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-headpills">
                                    <div class="card-status bg-info br-te-7 br-ts-7"></div>
                                    <div class="card-header border-bottom">
                                        <ul class="nav nav-pills card-header-pills">
                                            <?php
                                            $noWorkStep = 1;
                                            ?>

                                            @foreach ($workStepList as $data)
                                                <li class="nav-item">
                                                    <button
                                                        class="btn btn-sm btn-info mt-1 mb-1 me-3 {{ $activeTabOperator === 'tabOperator' . $noWorkStep ? 'active' : '' }}"
                                                        data-bs-toggle="tab"
                                                        wire:click="changeTabOperator('tabOperator{{ $noWorkStep }}')"
                                                        wire:key="tabOperator{{ $noWorkStep }}"
                                                        href="#tabOperator{{ $noWorkStep }}">
                                                        {{ $data->name }}
                                                    </button>
                                                </li>
                                                <?php
                                                $noWorkStep++;
                                                ?>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <?php
                                            $noWorkStepSelected = 1;
                                            ?>

                                            @foreach ($workStepList as $data)
                                                <div class="tab-pane {{ $activeTabOperator === 'tabOperator' . $noWorkStepSelected ? 'active' : '' }}"
                                                    id="tabOperator{{ $noWorkStepSelected }}">
                                                    <h5 class="card-title">{{ $data->name }}</h5>
                                                        @livewire('penjadwalan.component.operator-dashboard-index' , ['dataWorkStepList' => $data->id], key($data->id))
                                                </div>
                                                <?php
                                                $noWorkStepSelected++;
                                                ?>
                                            @endforeach

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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-status bg-cyan br-te-7 br-ts-7"></div>
                                    <div class="card-header">
                                        <h3 class="card-title">Pengajuan Kekurangan Qc</h3>
                                    </div>
                                    <div class="card-body">
                                        @livewire('penjadwalan.component.pengajuan-kekurangan-qc-dashboard-index')
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
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal1')"
                                                    wire:key="tabPengajuanBarangPersonal1"
                                                    href="#tabPengajuanBarangPersonal1">Pengajuan Barang Personal -
                                                    {{ $dataCountPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangPersonal2')"
                                                    wire:key="tabPengajuanBarangPersonal2"
                                                    href="#tabPengajuanBarangPersonal2">Reject Pengajuan Barang Personal -
                                                    {{ $dataCountRejectPengajuanBarangPersonal }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-info mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangSpk1')"
                                                    wire:key="tabPengajuanBarangSpk1"
                                                    href="#tabPengajuanBarangSpk1">Pengajuan Barang SPK -
                                                    {{ $dataCountPengajuanBarangSpk }}</button>
                                            </li>
                                            <li class="nav-item">
                                                <button
                                                    class="btn btn-primary mt-1 mb-1 me-3 {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk2' ? 'active' : '' }}"
                                                    data-bs-toggle="tab"
                                                    wire:click="changeTabPengajuanBarangPersonal('tabPengajuanBarangSpk2')"
                                                    wire:key="tabPengajuanBarangSpk2"
                                                    href="#tabPengajuanBarangSpk2">Reject Pengajuan Barang SPK -
                                                    {{ $dataCountRejectPengajuanBarangSpk }}</button>
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
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangPersonal2' ? 'active' : '' }}"
                                                id="tabPengajuanBarangPersonal2">
                                                <h5 class="card-title">Reject Pengajuan Barang Personal</h5>
                                                @livewire('component.riwayat-reject-pengajuan-barang-personal-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk1' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk1">
                                                <h5 class="card-title">Pengajuan Barang SPK</h5>
                                                @livewire('component.riwayat-pengajuan-barang-spk-index')
                                            </div>
                                            <div class="tab-pane {{ $activeTabPengajuanBarang === 'tabPengajuanBarangSpk2' ? 'active' : '' }}"
                                                id="tabPengajuanBarangSpk2">
                                                <h5 class="card-title">Reject Pengajuan Barang SPK</h5>
                                                @livewire('component.riwayat-reject-pengajuan-barang-spk-index')
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
