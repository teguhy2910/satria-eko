@extends('layouts.app3')
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
                    <div>
                        <a href="" class="btn btn-md btn-warning">Over Due Date 2 Days</a>
                        <a href="" class="btn btn-md btn-danger">Over Due Date 7 Days</a>
                    </div>
                    <form method='get' action='{{asset('filter')}}' class="pull-right">
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
                    <table id="sj_ppic" class="table table-bordered table-condensed table-hover dt-responsive">
                <thead>                 
                <tr class="info">
                <th><small>TANGGAL WAKTU UPLOAD</small></th>    
                <th><small>TANGGAL_DELIVERY</small></th>    
                <th><small>CUSTOMER_NAME</small></th>
                <th><small>CYCLE</small></th>
                <th><small>PDSNUMBER</small></th>
                <th><small>DOAII</small></th>
                <th><small>DOAIIA</small></th>                
                <th><small>SJ BALIK</small></th>
                <th><small>KIRIM FINANCE</small></th>
                <th><small>FINANCE</small></th>
                <th><small>KIRIMAII</small></th>
                <th><small></small></th>

            </tr>
        </thead>        
            <tbody>
                @foreach($data as $row)
                @if(\Carbon\Carbon::parse($row->TANGGAL_DELIVERY)->diffInDays(\Carbon\Carbon::parse($row->BALIK))>=7)
                <tr class='danger'>
                @elseif(\Carbon\Carbon::parse($row->TANGGAL_DELIVERY)->diffInDays(\Carbon\Carbon::parse($row->BALIK))>=2)
                <tr class='warning'>
                @else
                <tr class='success'>
                @endif
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->TANGGAL_DELIVERY}}</td>
                    <td>{{$row->CUSTOMER_NAME}}</td>
                    <td>{{$row->CYCLE}}</td>
                    <td>{{$row->PDSNUMBER}}</td>
                    <td>{{$row->DOAII}}</td>
                    <td>{{$row->DOAIIA}}</td>                    
                    <td>
                        @if($row->BALIK==null)
                        Belum
                        @else
                        {{$row->BALIK}}
                        @endif
                    </td>
                    <td>
                        @if($row->RECHEIPT_CHECK==null)
                        Belum
                        @else
                        {{$row->RECHEIPT_CHECK}}
                        @endif
                    </td>
                    <td>
                        @if($row->FINANCE==null)
                        Belum
                        @else
                        {{$row->FINANCE}}
                        @endif
                    </td>
                    <td>
                        @if($row->KIRIMAII==null)
                        Belum
                        @else
                        {{$row->KIRIMAII}}
                        @endif
                    </td>
                    @if($row->FINANCE==null && Auth::user()->dept == 'ppic')
                    <td><a href="{{asset('del/'.$row->PDSNUMBER)}}" class="btn btn-xs btn-danger">Del</a></td>
                    @elseif($row->FINANCE!=null && Auth::user()->dept == 'finance')
                    <td><a href="{{asset('del/'.$row->PDSNUMBER)}}" class="btn btn-xs btn-danger">Del</a></td>
                    @else
                    <td></td>
                    @endif
                    

                </tr>
                @endforeach
            </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
