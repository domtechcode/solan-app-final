<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5  Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}">

    <!-- TITLE -->
    <title>CV. Solan - {{ $title }} </title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- INTERNAL Switcher css -->
    <link href="{{ asset('assets/switcher/css/switcher.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/switcher/demo.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/toastr-cdn.css') }}" rel="stylesheet">

    <style>
        .select2-selection__arrow {
            display: none;
        }
    </style>

    @livewireStyles
    @stack('styles')

</head>

<body class="app sidebar-mini ltr light-mode">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">
            @include('layouts.header')
            @yield('content')
        </div>

        @include('layouts.sidebar')

        @include('layouts.footer')
    </div>

    <!-- BACK-TO-TOP -->
    {{-- <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a> --}}

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Alpine Plugins -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    <!-- INTERNAL SELECT2 JS -->
    
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- ACCORDION JS -->
    <script src="{{ asset('assets/plugins/accordion/accordion.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/accordion/accordion.js') }}"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>

    <!-- SIDE-MENU JS -->
    <script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}"></script>

    <!--- TABS JS -->
    <script src="{{ asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ asset('assets/plugins/tabs/tab-content.js') }}"></script>

    <!-- SIDEBAR JS -->
    <script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

    <!-- Color Theme js -->
    <script src="{{ asset('assets/js/themeColors.js') }}"></script>

    <!-- Sticky js -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Custom-switcher -->
    <script src="{{ asset('assets/js/custom-swicher.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Switcher js -->
    <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>
    <script src="{{ asset('vendor/pharaonic/pharaonic.select2.min.js') }}"></script>
    <script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>
    <script src="{{ asset('assets/js/toastr-cdn.js') }}"></script>
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPostion = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLenght = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {
                        this.value = value.toLocaleString('id-ID', {
                            // currency: 'IDR',
                            // style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPostion = this.value.length - originalLenght + cursorPostion;
                        this.setSelectionRange(cursorPostion, cursorPostion);
                    }
                });
            });

            Livewire.on('flashMessage', (param) => {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                toastr[param['type']](param['message'], param['title']);
            });
        });
    </script>

    <script type="module">
        Echo.channel('notif.' + {{ Auth::user()->id }})
            .listen('NotificationSent', function(data) {
                // console.log(data);
                Livewire.emit('indexRender');
            });
    </script>

    {{-- <script>
    Echo.channel('refresh')
            .listen('IndexRenderEvent', function (e) {
                Livewire.emit('indexRender');
            });
</script> --}}

    {{-- <script>
    window.livewire.onError(statusCode => {
        return false
    });
</script> --}}

    {{-- <script>
    document.addEventListener('livewire:load', function () {
            Livewire.on('renderIndex', function () {
                Livewire.emit('indexRender');
            });
        });
</script> --}}

</body>

</html>
