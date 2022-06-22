@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">        
        <div class="col-md-12">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            @if(Session::has('warning'))
            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('warning') }}</p>
            @endif
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a class=""><big><big><big><font face="calibri">Surat Jalan </font></big></big></big> <span class="label label-warning"></span></a></li>
                </ul>
                <div class="panel-body">
                    @if(Auth::user()->name == 'ppic' || Auth::user()->name == 'pc')
                    <a href="{{asset("/sj_balik")}}" class="btn btn-md btn-warning">Scan Disini >> SJ BALIK & Ke Finance</a>
                    <br><br>
                    @elseif(Auth::user()->name == 'finance')                
                    <a href="{{asset("/terima_finance")}}" class="btn btn-md btn-success">FINANCE</a>
                    <br><br>
                    @endif
                    <form method='post' action='{{asset('filter_view')}}' class="pull-right">                    
                    {{ csrf_field() }}
                        <div class='row'>
                        <div class='col-md-4'>
                        <label>FROM</label>
                        <input type='date' name='from' class='form-control'>
                        </div>
                        <div class='col-md-4'>
                        <label>TO</label>
                        <input type='date' name='to' class='form-control'>
                        </div>
                        <div class='col-md-4'>
                        <label>&nbsp;</label> <br>
                        <input type='submit' class='btn btn-md btn-primary'>
                        </div>
                        </div>
                    </form>
                    <br><br>
                    <table id="sj_all_ppic" class="table table-bordered table-condensed table-hover dt-responsive">
                <thead>                 
                <tr class="info">
                <th><small>ID</small></th>    
                <th><small>TANGGAL WAKTU UPLOAD</small></th>    
                <th><small>TANGGAL_DELIVERY</small></th>    
                <th><small>CUSTOMER_NAME</small></th>
                <th><small>PDSNUMBER</small></th>
                <th><small>DOAII</small></th>
                <th><small>SJ BALIK</small></th>
                <th><small>FINANCE</small></th>
                <th><small></small></th>

            </tr>
        </thead>                   
            </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
