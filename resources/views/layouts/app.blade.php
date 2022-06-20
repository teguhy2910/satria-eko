<!DOCTYPE html>
<html lang="en">
<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
window.Laravel = <?php echo json_encode([
'csrfToken' => csrf_token(),
]); ?>
</script>
<title>{{ config('app.name', 'Satria') }}</title>
<!-- Styles -->
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.bootstrap.min.css')}}"> 
<link rel="stylesheet" type="text/css" href="{{asset('/css/AdminLTE.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/navigasi.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert.css')}}">
</head>
<body>
    <style type="text/css">
        body {
           /* background-image: url("img/bg1.jpeg"); */
           background-color: #348feb;
        }
    </style>
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
<div class="navbar-header">
<!-- Collapsed Hamburger -->
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
<span class="sr-only">Toggle Navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<!-- Branding Image -->
<a class="navbar-brand" href="{{ url('/sj/dashboard') }}">
<big><font color="white">All New SATRIA</font></big>
</a>
</div>
<div class="collapse navbar-collapse" id="app-navbar-collapse">

<!-- Left Side Of Navbar -->
<ul class="nav navbar-nav">
&nbsp;
@if (Auth::guest())
@else
<li><a href="{{asset('/sj/dashboard')}}"><font color="white" face="calibri" size="3px"> SJ On Progress</font></a></li>
<li><a href="{{asset('dashboard')}}"><font color="white" face="calibri" size="3px"> ALL SJ</font></a></li>
@if(Auth::user()->name == 'ppic' || Auth::user()->name == 'pc')
<li><a href="{{asset('upload/sj/dashboard')}}"><font color="white" face="calibri" size="3px"> Upload SJ</font></a></li>
<li><a href="{{asset('create/sj')}}"><font color="white" face="calibri" size="3px"> Create SJ</font></a></li>
@endif
@endif  
</ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">

<!-- Authentication Links -->
@if (Auth::guest())                        
@else 

<li><a aria-expanded="false"><font color="white">Welcome {{ Auth::user()->name }}</font></a>
</li>
<li>
<a href="{{ url('/logout') }}"
onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
<button class="btn btn-sm bg-maroon"><i class="fa fa-power-off" aria-hidden="true"></i></button>
</a>
<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</li>
@endif
</ul>

</div>
<!-- End Navbar Collapse -->
</div>
<!-- End Container -->
</nav>
<!-- End Nav -->
@yield('content')
<!-- Scripts -->
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.flash.min.js')}}"></script>
<script type="text/javascript" scr="{{asset('js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/responsive.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/Chart.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jszip.min.js')}}"></script>
<link href="{{asset('css/bootstrap-editable.css')}}" rel="stylesheet"/>
<script src="{{asset('js/bootstrap-editable.min.js')}}"></script>
<!-- Include this after the sweet alert js file -->
@include('sweet::alert')
<script>
     $("input:text:visible:first").focus();
</script>
<script type="text/javascript">
$(document).ready(function() {
$('#sj_all_ppic').DataTable({
lengthMenu: [
[ 10, 25, 50, -1 ],
[ '10', '25', '50', 'Show all' ]
],
"dom": 'lBfrtip',
"buttons": [
'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
],
processing: true,
serverSide: true,
ajax: {
            'url':'{!!url("data_sj")!!}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$('#sj_ppic').DataTable({
lengthMenu: [
[ 10, 25, 50, -1 ],
[ '10', '25', '50', 'Show all' ]
],
"dom": 'lBfrtip',
"buttons": [
'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
],
processing: true,
serverSide: true,
ajax: {
            'url':'{!!url("data_outstanding_sj")!!}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$('#sj_ppic_more_7_days').DataTable({
lengthMenu: [
[ 10, 25, 50, -1 ],
[ '10', '25', '50', 'Show all' ]
],
"dom": 'lBfrtip',
"buttons": [
'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
],
processing: true,
serverSide: true,
ajax: {
            'url':'{!!url("data_outstanding_sj_7_day")!!}',
            'type': 'POST',
            'headers': {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
$('#sj_filter').DataTable({
lengthMenu: [
[ 10, 25, 50, -1 ],
[ '10', '25', '50', 'Show all' ]
],
"dom": 'lBfrtip',
"buttons": [
'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
]
});
});
</script>
</body>
</html>