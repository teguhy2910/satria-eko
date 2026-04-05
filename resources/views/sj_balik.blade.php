@extends('layouts.app')
@section('content')
<div class="container-full">
    @include('partials.flash_message')

    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="border: 4px solid #a1a1a1;">
            <h2><center><span style="color: white;">Scan Barcode -- SJ Balik</span></center></h2>
            <center>
                <form action="{{ url('/sj_balik') }}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <input type="text" class="form-control" placeholder="Scan Barcode" name="doaii" autofocus />
                </form>
            </center>
            <hr>
            <form action="{{ url('/update_sj_balik_ppic_upload') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="update_sj_balik_ppic">
                <hr>
                <input type="submit" class="btn btn-md btn-warning" value="Upload Data Scan">
                <hr>
            </form>
        </div>
    </div>
</div>
@endsection
