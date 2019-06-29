<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Analisis Sentimen | {{$title}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="icon" href="{{'AdminLTE/img/logo-ubl-web.png'}}" type="image/ico">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css'}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/font-awesome/css/font-awesome.min.css'}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/Ionicons/css/ionicons.min.css'}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{'AdminLTE/dist/css/AdminLTE.min.css'}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{'AdminLTE/dist/css/skins/_all-skins.min.css'}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/jvectormap/jquery-jvectormap.css'}}">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="{{'AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css'}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{'AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'}}">
    <!-- upload -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\upload.css'}}">
    <!-- sweet alert framework -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\sweetalert.css'}}">
    <!-- pnotify -->
    <link rel="stylesheet" type="text/css" href="{{'files\assets\css\pnotify.custom.min.css'}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{'AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css'}}">
    <!-- jQuery 3 -->
    <script src="{{'AdminLTE/bower_components/jquery/dist/jquery.min.js'}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{'AdminLTE/bower_components/jquery-ui/jquery-ui.min.js'}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{'AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js'}}"></script>
    <!-- DataTables -->
    <script src="{{'AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js'}}"></script>
    <script src="{{'AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js'}}"></script>
    <!-- upload -->
    <script type="text/javascript" src="{{'files\assets\js\upload.js'}}"></script>
    <!-- sweet alert js -->
    <script type="text/javascript" src="{{'files\assets\js\sweetalert.min.js'}}"></script>
    <!-- pnotify -->
    <script type="text/javascript" src="{{'files\assets\js\pnotify.custom.min.js'}}"></script>

    {{-- pie gradient --}}
    <script src="{{'Highcharts/code/highcharts.js'}}"></script>
    <script src="{{'Highcharts/code/modules/exporting.js'}}"></script>
    <script src="{{'Highcharts/code/modules/export-data.js'}}"></script>

    {{-- word cloud --}}
    {{-- <script src="{{'Highcharts/code/highcharts.js'}}"></script> --}}
    <script src="{{'Highcharts/code/modules/wordcloud.js'}}"></script>

    {{-- column drill down --}}
    <script src="{{'Highcharts/code/modules/data.js'}}"></script>
    <script src="{{'Highcharts/code/modules/drilldown.js'}}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Analisis</b> Sentimen</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <label
                                style="color: white; font-size: 16px; margin-top: 15px; margin-right: 15px;"><?php echo App\Models\TwitterStream::getTanggal(); ?></label>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="/">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="/kategori-sentimen">
                            <i class="fa fa-tags"></i> <span>Kategori Sentimen</span>
                        </a>
                    </li>
                    <li>
                        <a href="/crawling">
                            <i class="fa fa-twitter"></i> <span>Twitter Crawling</span>
                        </a>
                    </li>
                    {{-- <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i> <span>Kosa Kata</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/kata-dasar"><i class="fa fa-circle-o"></i> Kata Dasar</a></li>
                            <li><a href="/stopword"><i class="fa fa-circle-o"></i> Stopwords</a></li>
                        </ul>
                    </li> --}}
                    <li>
                        <a href="/preprocessing">
                            <i class="fa fa-gears"></i> <span>Preprocessing</span>
                        </a>
                    </li>
                    <li>
                        <a href="/training">
                            <i class="fa fa-list-alt"></i> <span>Data Training</span>
                        </a>
                    </li>
                    <li>
                        <a href="/analisa">
                            <i class="fa fa-pie-chart"></i> <span>Analisa Data</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('main')
        </div>
        
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Universitas Budi Luhur | </b> {{date('Y')}}
            </div>
            <strong> &copy; 1512502707 | Zacky Burhani Hotib</strong>

        </footer>
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Sparkline -->
    <script src="{{'AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js'}}"></script>
    <!-- jvectormap -->
    <script src="{{'AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'}}"></script>
    <script src="{{'AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{'AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js'}}"></script>
    <!-- daterangepicker -->
    <script src="{{'AdminLTE/bower_components/moment/min/moment.min.js'}}"></script>
    <script src="{{'AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js'}}"></script>
    <!-- datepicker -->
    <script src="{{'AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{'AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'}}"></script>
    <!-- Slimscroll -->
    <script src="{{'AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'}}"></script>
    <!-- FastClick -->
    <script src="{{'AdminLTE/bower_components/fastclick/lib/fastclick.js'}}"></script>
    <!-- AdminLTE App -->
    <script src="{{'AdminLTE/dist/js/adminlte.min.js'}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{'AdminLTE/dist/js/demo.js'}}"></script>
</body>

</html>