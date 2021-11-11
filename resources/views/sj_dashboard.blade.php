@extends('layouts.app3')
@section('content')
<div class="container-full">
    <div class="row">        
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active"><a class=""><big><big><big><font face="calibri">Surat Jalan </font></big></big></big> <span class="label label-warning"></span></a></li>
                <li><a href={{asset("/sj_out")}}><font face="calibri" color="black"><big>Outstanding SJ > 7 Hari </big> </font> <span class="label label-success"></span></a></li>
                </ul>
                <div class="panel-body">
                    @if(Auth::user()->dept == 'ppic')
                    <a href="{{asset("/balik")}}" class="btn btn-md btn-warning">SJ BALIK</a>
                    <a href="{{asset("/rc")}}" class="btn btn-md btn-success">KIRIM FINANCE</a>
                    @elseif(Auth::user()->dept == 'finance')                
                    <a href="{{asset("/fin")}}" class="btn btn-md btn-success">FINANCE</a>
                    <a href="{{asset("/aii")}}" class="btn btn-md btn-primary">KIRIM AII</a>
                    @endif
                    <br><br>
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
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
            </tr>
        </thead>        
            <tbody>
                @foreach($data as $row)
                @if($row->BALIK==null||$row->RECHEIPT_CHECK==null||$row->LEADER_CHECK==null||$row->FINANCE==null||$row->SUPERVISOR==null||$row->KIRIMAII==null)
                <tr>
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
