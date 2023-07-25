<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal " href="index.html">
                <img src="{{ asset('assets/images/brand/logo-white.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/logo-dark.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
            <!-- LOGO -->
            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2 w-auto p-3">
                            
                            <!-- SIDE-MENU -->
                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                    <img src="{{ asset('assets/images/users/1.png') }}" alt="profile-user"
                                        class="avatar  profile-user brround cover-image">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <div class="drop-heading">
                                        <div class="text-center">
                                            <h5 class="text-dark mb-0 fs-14 fw-semibold">{{ auth()->user()->name }}</h5>
                                            <small class="text-muted">{{ auth()->user()->role }}</small>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider m-0"></div>
                                    <form action="{{ route('logoutProcess') }}" method="post">
                                        @csrf
                                        <button class="button dropdown-item" type="submit">
                                            <i class="dropdown-icon fe fe-log-out"></i> Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->

<!--APP-SIDEBAR-->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="index.html">
                <img src="{{ asset('assets/images/brand/logo-white.png') }}" class="header-brand-img desktop-logo"
                    alt="logo">
                <img src="{{ asset('assets/images/brand/icon-white.png') }}" class="header-brand-img toggle-logo"
                    alt="logo">
                <img src="{{ asset('assets/images/brand/icon-dark.png') }}" class="header-brand-img light-logo"
                    alt="logo">
                <img src="{{ asset('assets/images/brand/logo-dark.png') }}" class="header-brand-img light-logo1"
                    alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">

                @if( auth()->user()->role == 'Follow Up' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('followUp.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="sub-category">
                    <h3>Form Instruksi Kerja</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Form Instruksi Kerja" or $title === "Form Instruksi Kerja Kekurangan") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-file"></i><span class="side-menu__label">Form Instruksi Kerja</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Form Instruksi Kerja</a></li>
                                            <li><a href="{{ route('followUp.createInstruction') }}" class="slide-item {{ ($title === "Form Instruksi Kerja") ? 'active' : ''}}">Form Instruksi Kerja (New)</a></li>
                                            <li><a href="{{ route('followUp.createInstructionKekurangan') }}" class="slide-item {{ ($title === "Form Instruksi Kerja Kekurangan") ? 'active' : ''}}">Form Instruksi Kerja (Kekurangan)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="sub-category">
                    <h3>Group</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Group") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-file"></i><span class="side-menu__label">Group</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Group</a></li>
                                            <li><a href="{{ route('followUp.group') }}" class="slide-item {{ ($title === "Group") ? 'active' : ''}}">Group (New)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

                @if( auth()->user()->role == 'Stock' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('stock.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

                @if( auth()->user()->role == 'Hitung Bahan' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('hitungBahan.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="sub-category">
                    <h3>Group</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Group") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-file"></i><span class="side-menu__label">Group</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Group</a></li>
                                            <li><a href="{{ route('hitungBahan.group') }}" class="slide-item {{ ($title === "Group") ? 'active' : ''}}">Group (New)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

                @if( auth()->user()->role == 'RAB' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('rab.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

                @if( auth()->user()->role == 'Penjadwalan' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('jadwal.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="sub-category">
                    <h3>Group</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Group") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-file"></i><span class="side-menu__label">Group</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Group</a></li>
                                            <li><a href="{{ route('jadwal.group') }}" class="slide-item {{ ($title === "Group") ? 'active' : ''}}">Group (New)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

                @if( auth()->user()->role == 'Operator' )
                <li class="sub-category">
                    <h3>Home</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ ($title === "Dashboard") ? 'active' : ''}}" data-bs-toggle="slide" href="javascript:void(0)"><i
                            class="side-menu__icon fe fe-home"></i><span class="side-menu__label">Home</span><i
                            class="angle fe fe-chevron-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="tab-menu-heading p-0 pb-2 border-0">
                            </div>
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side1">
                                        <ul class="sidemenu-list">
                                            <li class="side-menu-label1"><a href="javascript:void(0)">Home</a></li>
                                            <li><a href="{{ route('operator.dashboard') }}" class="slide-item {{ ($title === "Dashboard") ? 'active' : ''}}">Dashboard</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endif

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>
<!--/APP-SIDEBAR-->
