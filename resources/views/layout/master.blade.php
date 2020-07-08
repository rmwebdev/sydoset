<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html>
    <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="description" content="Ela Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{asset('icon/history-copy.png')}}"/>
    <link rel="shortcut icon" href="{{asset('icon/history-copy.png')}}"/>

    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/normalize.min.css') }}"/>
    <!-- <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/bootstrap.min.css') }}"/> -->
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/bootstrap/css/bootstrap.min.css') }}"/> -->

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">


    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/themify-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/pe-icon-7-stroke.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/flag-icon.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/lib/ext/toastr.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/cs-skin-elastic.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/css/multiselect.css') }}"/>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="{{ asset('ElaAdminAsset/assets/css/lib/ext/chartist.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('ElaAdminAsset/assets/css/lib/ext/jqvmap.min.css') }}" rel="stylesheet"/>

    <!-- <link href="ElaAdminAsset/assets/css/lib/ext/weather-icons.css" rel="stylesheet" /> -->
    <link href="{{ asset('ElaAdminAsset/assets/css/lib/ext/fullcalendar.min.css') }}" rel="stylesheet" />
    <!-- <script src="ElaAdminAsset/assets/css/lib/datatable/datatables.min.css'"></script> -->
    <link href="{{ asset('ElaAdminAsset/assets/css/lib/datatable/DataTables-1.10.20/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <!-- <link href="ElaAdminAsset/assets/css/lib/datatable/DataTables-1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/> -->
    <link rel="stylesheet" href="{{ asset('ElaAdminAsset/assets/js/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('select-2/css/select2.min.css') }}" />

    <style type='text/css'>
        /* The container */
        .containerCheck {
            display: initial !important;
            position: relative;
            padding-left: 18px;
            margin-bottom: 12px;
            cursor: pointer;
            /* font-size: 22px; */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .containerCheck input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 18px;
            width: 18px;
            background-color: transparent;
            border-radius: 6px;
            border: solid 2px #1d1e4b;

        }

        /* On mouse-over, add a grey background color */
        .containerCheck:hover input ~ .checkmark {
            background-color: transparent;
        }

        /* When the checkbox is checked, add a blue background */
        .containerCheck input:checked ~ .checkmark {
            background-color: #1d1e4b;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .containerCheck input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .containerCheck .checkmark:after {
            left: 5px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        th.dt-center, td.dt-center { text-align: center; }
        th.dt-right, td.dt-right { text-align: right; }
    </style>


   @yield('css')
</head>

<body>
    <!-- Left Panel -->
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="row">
                <div class="col-md-12 ">
                    <div style="background-color: #1d1e4b;text-align: center;padding-top: 12px;padding-bottom: 12px;">
                        <a href="/"><img src="{{ asset('icon/icon_setops1.png') }}" style="width: 157px;height: 24px;"></a>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-left:17px;">
                <div class="col-md-12">
                    <label id="labelHead" style="padding-top:33px">{{ Session::get('nama_user')." ".Session::get('nama_user_last')}}</label><br/>
                    <label id="subLabel">{{ Session::get('role')}}</label>
                </div>
            </div>
            <hr class="divider" style="margin-left:16px;margin-right:16px;margin-top:24px;margin-bottom:0px">
            @include('layout.sidebarleft')
        </nav>
    </aside>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->

                <!-- /Widgets -->
                <!--  Traffic  -->

                @yield('content')

                <!--  /Traffic -->

            </div>
            <!-- .animated -->
        </div>
    </div>
    <!-- /#right-panel -->
    <!-- Scripts -->
    <script src="{{ asset('ElaAdminAsset/assets/css/lib/datatable/jQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <!-- <script src="ElaAdminAsset/assets/js/lib/ext/bootstrap.min.js"></script> -->
    <script src="{{asset('ElaAdminAsset/assets/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/jquery.matchHeight.min.js') }}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/main.js') }}"></script>

    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/toastr.min.js') }}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/ext/jquery.blockUI.js') }}"></script>


    <script src="{{ asset('ElaAdminAsset/assets/css/lib/datatable/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/css/lib/datatable/DataTables-1.10.20/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('ElaAdminAsset/assets/js/lib/datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('select-2/js/select2.min.js') }}"></script>


    <!-- <script src="ElaAdminAsset/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script> -->
    <!-- <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script> -->

    <script type="text/javascript">
    (function($) {
        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })(jQuery);


        @if(session('message'))
            var type = "{{ session('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ session('message') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ session('message') }}");
                    break;

                case 'success':
                    toastr.success("{{ session('message') }}");
                    break;

                case 'error':
                    toastr.error("{{ session('message') }}");
                    break;
            }
        @endif
    </script>

    @yield('js')
</body>
</html>
