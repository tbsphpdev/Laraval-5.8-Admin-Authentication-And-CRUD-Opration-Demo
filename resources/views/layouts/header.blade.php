<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Project </title>
    <base href="{{ url('home') }}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{asset('assets/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dist/css/skins/_all-skins.min.css')}}">
   <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-notify.css')}}">
   <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
     
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-1.11.2.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- CK Editor -->
    <!-- Datatable -->
    <script src="{{asset('assets/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ url('assets\images\favicon.png') }}" type="image/gif" sizes="32x32">
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">
    @include('layouts.headbar')
    @include('layouts.sidebar')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            {{ $title}}
            </h1>
            @if(\Illuminate\Support\Facades\Session::has('message'))
                <div class="alert alert-warning" style="margin-top: 20px;"> {{\Illuminate\Support\Facades\Session::get('message')}}</div>
            @endif
            <ol class="breadcrumb">
                <li><a href="{{'home'}}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="active">{{ $title}}</li>
            </ol>
        </section>
        @yield('content')
    </div>
    <div class='notifications top-right'></div>
    <div id="divLoading"> </div>
</div>
    <script>
        function reload_table() {
            table.ajax.reload(null, false);
        }
    </script>
    <style>
    #divLoading{
        display : none;
    }
    #divLoading.show{
        display : block;
        position : fixed;
        z-index: 100;
        background-image : url("{{asset('assets/images/loading.gif')}}");
        background-color:#666;
        opacity : 0.4;
        background-repeat : no-repeat;
        background-position : center;
        left : 0;
        bottom : 0;
        right : 0;
        top : 0;
    }
    #loadinggif.show{
        left : 50%;
        top : 50%;
        position : absolute;
        z-index : 101;
        width : 32px;
        height : 32px;
        margin-left : -16px;
        margin-top : -16px;
    }
    div.content {
        width : 1000px;
        height : 1000px;
    }
    .logo img {
        margin-top: 11px;
    }
    .logo-lg{
       margin-top: 17px !important;
       margin-left: 10px;
    }
</style>

</body>
</html>