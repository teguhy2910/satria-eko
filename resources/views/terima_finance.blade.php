@extends('layouts.app')
@section('content')
<div class="container-full">
    @include('partials.flash_message')

    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="border: 4px solid #a1a1a1;">
            <h2><center><span style="color: white;">Scan Barcode -- Finance</span></center></h2>
            <center>
                <form action="{{ url('/terima_finance') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input id="a" type="text" class="form-control" placeholder="Scan Barcode" name="doaii" />
                </form>
            </center>
            <hr>
            <form action="{{ url('/update_fin_upload') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="update_fin_upload">
                <hr>
                <input type="submit" class="btn btn-md btn-warning" value="Upload Data Scan">
                <hr>
            </form>
        </div>
    </div>
</div>
@endsection
