<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset("images/star.png")}}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/my.css')}}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{route("admin.index")}}" class="logo">
            <span class="logo-mini"><b>I</b>SH</span>
            <span class="logo-lg"><b>I</b>SHOP</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{route('main.index')}}"><span class="fa fa-home"></span> </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset("adminlte/dist/img/user2-160x160.jpg")}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->name}}</p>
                    <i class="fa fa-circle text-success"></i> Online
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Меню</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="{{route("admin.index")}}"><i class="fa fa-home"></i> <span>Главная</span></a></li>
                <li><a href="{{route("admin.order.index")}}"><i class="fa fa-shopping-cart"></i> <span>Заказы</span></a>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-navicon"></i> <span>Категории</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.category.index')}}">Список категорий</a></li>
                        <li><a href="{{route('admin.category.create')}}">Добавить категорию</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{route("admin.products.index")}}"><i class="fa fa-cubes"></i> <span>Товары</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.products.index')}}">Список товаров</a></li>
                        <li><a href="{{route('admin.product.create')}}">Добавить товар</a></li>
                    </ul>
                </li>
                <li><a href="{{route('admin.cache.index')}}"><i class="fa fa-database"></i> <span>Кэширование</span></a></li>
                <li><a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i>
                        <span>Пользователи</span></a>

                <li class="treeview"><a href="{{route("admin.currency.index")}}"><i class="fa fa-cubes"></i> <span>Валюты</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('admin.products.index')}}">Список валют</a></li>
                        <li><a href="{{route('admin.product.create')}}">Добавить валюту</a></li>
                    </ul>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <div class="control-sidebar-bg"></div>
</div>

<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/ckeditor/ckeditor.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/ckeditor/adapters/jquery.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('js/ajaxupload.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.js')}}"></script>
<script src="{{ asset('adminlte/my.js')}}"></script>
</body>
</html>

