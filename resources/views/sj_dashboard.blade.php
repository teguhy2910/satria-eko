@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">        
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a class=""><big><big><big><font face="calibri">Surat Jalan </font></big></big></big> <span class="label label-warning"></span></a></li>
                <li><a href={{asset("/sj_outstanding")}}><font face="calibri" color="black"><big>Outstanding SJ > 7 Hari </big> </font> <span class="label label-success"></span></a></li>
                </ul>
                <div class="panel-body">
                    @if(Auth::user()->name == 'ppic' || Auth::user()->name == 'pc')
                    <a href="{{asset("/sj_balik")}}" class="btn btn-md btn-warning">Scan Disini >> SJ BALIK & Ke Finance</a>
                    <br><br>
                    @elseif(Auth::user()->name == 'finance')                
                    <a href="{{asset("/terima_finance")}}" class="btn btn-md btn-success">FINANCE</a>
                    <br><br>
                    @endif
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @elseif(Session::has('danger'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('danger') }}</p>
                    @endif
                    <table id="sj_ppic" class="table table-bordered table-condensed table-hover dt-responsive">
                <thead>                 
                <tr class="info">
                <th><small>TANGGAL WAKTU UPLOAD</small></th>    
                <th><small>TANGGAL_DELIVERY</small></th>    
                <th><small>CUSTOMER_NAME</small></th>
                <th><small>PDSNUMBER</small></th>
                <th><small>DOAII</small></th>
                <th><small>SJ BALIK</small></th>
                <th><small>FINANCE</small></th>                
            </tr>
        </thead>                    
            </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
