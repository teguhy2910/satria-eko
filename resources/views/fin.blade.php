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
            <h2><center><font color="white">Scan Barcode -- Finance</font></center></h2>
            <center>
                <form action="{{asset('fin')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input id="a" type="text" class="form-control" placeholder="Scan Barcode" name="rc"/>                      
            </center>
        </form>
        <hr>
        <form action="{{asset('fin_upload')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="upload_sj">
        <hr>
        <input type="submit" class="btn btn-md btn-primary" value="Upload">
        <hr>
        </form>
        </div>
    </div>
</div>

@endsection
