@extends('layouts.app3')
@section('content')
<div class="container-full">
    @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @if(Session::has('warning'))
    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('warning') }}</p>
    @endif
    <div class="row">
        <div class="col-md-6 col-md-offset-3"  style="border: 4px solid #a1a1a1;">
            <h2><center><font color="white">Scan Barcode -- Recheipt Check</font></center></h2>
            <center>
                <form action="{{asset('rc')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" class="form-control" autofocus placeholder="Scan Barcode" name="rc" /><br>
            <br><br>
            </center>
        </form>
        </div>
    </div>
</div>

@endsection
