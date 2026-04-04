<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Satria') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    @stack('styles')
    <style>
        body { background-color: #348feb; }
        .btn2 { border: 2px solid white; background-color: #348feb; color: white; padding: 5px 5px; margin-top: -10px; font-size: 13px; cursor: pointer; border-radius: 5px; }
    </style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/sj/dashboard') }}">
                <big><span style="color: white;">All New SATRIA</span></big>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                &nbsp;
                @if (Auth::check())
                    <li><a href="{{ url('/sj/dashboard') }}"><span style="color: white; font-family: calibri; font-size: 13px;"> SJ On Progress</span></a></li>
                    <li><a href="{{ url('/dashboard') }}"><span style="color: white; font-family: calibri; font-size: 13px;"> ALL SJ</span></a></li>
                    <li><a href="{{ url('/download_sj') }}"><span style="color: white; font-family: calibri; font-size: 13px;"> Download ALL SJ</span></a></li>
                    @if(in_array(Auth::user()->name, ['ppic', 'pc']))
                        <li><a href="{{ url('/upload/sj/dashboard') }}"><button class="btn2">Upload SJ</button></a></li>
                        <li><a href="{{ url('/create/sj') }}"><button class="btn2">Create SJ</button></a></li>
                    @endif
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><a aria-expanded="false"><span style="color: white;">Welcome {{ Auth::user()->name }}</span></a></li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <button class="btn btn-sm bg-maroon"><i class="fa fa-power-off" aria-hidden="true"></i></button>
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

<script>$("input:text:visible:first").focus();</script>
@stack('scripts')
</body>
</html>