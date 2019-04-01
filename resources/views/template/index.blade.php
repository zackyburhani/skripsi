<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aplikasi Analisis Sentimen | {{$title}}</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{'files\assets\images\favicon.ico'}}" type="image/x-icon">
    <!-- Google font-->
    {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> --}}
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{'files\bower_components\bootstrap\css\bootstrap.min.css'}}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\icon\feather\css\feather.css'}}">
    <!-- upload -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\upload.css'}}">
    <!-- font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\icon\font-awesome\css\font-awesome.min.css'}}">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{'files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css'}}">
    <link rel="stylesheet" type="text/css" href="{{'files\assets\pages\data-table\css\buttons.dataTables.min.css'}}">
    <link rel="stylesheet" type="text/css" href="{{'files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css'}}">
    <!-- Select 2 css -->
    <link rel="stylesheet" href="{{'files\bower_components\select2\css\select2.min.css'}}">
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css" href="{{'files\bower_components\bootstrap-multiselect\css\bootstrap-multiselect.css'}}">
    <link rel="stylesheet" type="text/css" href="{{'files\bower_components\multiselect\css\multi-select.css'}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\style.css'}}">
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\jquery.mCustomScrollbar.css'}}">
    <!-- sweet alert framework -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\sweetalert.css'}}">
    <!-- pnotify -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\pnotify.custom.min.css'}}">
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{'files\bower_components\jquery\js\jquery.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\jquery-ui\js\jquery-ui.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\popper.js\js\popper.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\bootstrap\js\bootstrap.min.js'}}"></script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{'files\assets\js\sweetalert.min.js'}}"></script>
    <!-- pnotify -->
    <script type="text/javascript" src="{{'files\assets\js\pnotify.custom.min.js'}}"></script>
    <!-- upload -->
    <script type="text/javascript" src="{{'files\assets\js\upload.js'}}"></script>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="index-1.htm">
                            <img class="img-fluid" src="..\files\assets\images\logo.png" alt="Theme-Logo">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="..\files\assets\images\avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                                        <span>John Doe</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="#!">
                                                <i class="feather icon-settings"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="auth-normal-sign-in.htm">
                                                <i class="feather icon-log-out"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Sidebar chat start -->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu active pcoded-trigger">
                                    <a href="/">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="/crawling">
                                        <span class="pcoded-micon"><i class="fa fa-twitter"></i></span>
                                        <span class="pcoded-mtext">Crawling Tweets</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-book"></i></span>
                                        <span class="pcoded-mtext">Kosa Kata</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class=" pcoded-hasmenu">
                                            <a href="/singkatan">
                                                <span class="pcoded-mtext">Kata Singkatan</span>
                                            </a>
                                        </li>
                                        <li class=" pcoded-hasmenu">
                                            <a href="/emoticon">
                                                <span class="pcoded-mtext">Emoticon</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="/preprocessing">
                                        <span class="pcoded-micon"><i class="fa fa-gears"></i></span>
                                        <span class="pcoded-mtext">Preprocessing</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    @yield('main')
                </div>
            </div>
        </div>
    </div>

    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{'files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js'}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{'files\bower_components\modernizr\js\modernizr.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\modernizr\js\css-scrollbars.js'}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{'files\bower_components\chart.js\js\Chart.js'}}"></script>
    <!-- amchart js -->
    <script src="{{'files\assets\pages\widget\amchart\amcharts.js'}}"></script>
    <script src="{{'files\assets\pages\widget\amchart\serial.js'}}"></script>
    <script src="{{'files\assets\pages\widget\amchart\light.js'}}"></script>

    <!-- data-table js -->
    <script src="{{'files\bower_components\datatables.net\js\jquery.dataTables.min.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js'}}"></script>
    <script src="{{'files\assets\pages\data-table\js\jszip.min.js'}}"></script>
    <script src="{{'files\assets\pages\data-table\js\pdfmake.min.js'}}"></script>
    <script src="{{'files\assets\pages\data-table\js\vfs_fonts.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-buttons\js\buttons.print.min.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-buttons\js\buttons.html5.min.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js'}}"></script>
    <script src="{{'files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js'}}"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="{{'files\bower_components\i18next\js\i18next.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\jquery-i18next\js\jquery-i18next.min.js'}}"></script>
    <!-- Custom js -->
    <script src="{{'files\assets\pages\data-table\js\data-table-custom.js'}}"></script>
    {{-- <script type="text/javascript" src="{{'files\assets\js\SmoothScroll.js'}}"></script> --}}
    <script src="{{'files\assets\js\pcoded.min.js'}}"></script>
    <script src="{{'files\assets\js\jquery.mCustomScrollbar.concat.min.js'}}"></script>
    <script src="{{'files\assets\js\vartical-layout.min.js'}}"></script>
    {{-- <script type="text/javascript" src="{{'files\assets\pages\dashboard\analytic-dashboard.min.js'}}"></script> --}}
    <script type="text/javascript" src="{{'files\assets\js\script.js'}}"></script>

    <!-- Select 2 js -->
    <script type="text/javascript" src="{{'files\bower_components\select2\js\select2.full.min.js'}}"></script>
    <!-- Multiselect js -->
    <script type="text/javascript" src="{{'files\bower_components\bootstrap-multiselect\js\bootstrap-multiselect.js'}}"></script>
    <script type="text/javascript" src="{{'files\bower_components\multiselect\js\jquery.multi-select.js'}}"></script>
    <script type="text/javascript" src="{{'files\assets\pages\advance-elements\select2-custom.js'}}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    {{-- <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script> --}}
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>
</body>

</html>
