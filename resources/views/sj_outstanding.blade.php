@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">        
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li><a href="{{asset('sj/dashboard')}}"><big><font face="calibri">Surat Jalan </font></big> <span class="label label-warning"></span></a></li>
                <li class="active"><a href={{asset("/sj_out")}}><font face="calibri" color="black"><big><big><big>Outstanding SJ > 7 Hari </big></big></big> </font> <span class="label label-success"></span></a></li>
                </ul>
                <div class="panel-body">                    
                    <table id="sj_ppic" class="table table-bordered table-condensed dt-responsive">
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
            </tr>
        </thead>        
            <tbody>
                @foreach($data as $row)
                <tr class='success'>
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->tanggal_delivery}}</td>
                    <td>{{$row->customer_name}}</td>
                    <td>{{$row->cycle}}</td>
                    <td>{{$row->pdsnumber}}</td>
                    <td>{{$row->doaii}}</td>
                    <td>{{$row->doaiia}}</td>                    
                    <td>
                        @if($row->sj_balik==null)
                        Belum
                        @else
                        {{$row->sj_balik}}
                        @endif
                    </td>
                    <td>
                        @if($row->kirim_finance==null)
                        Belum
                        @else
                        {{$row->kirim_finance}}
                        @endif
                    </td>
                    <td>
                        @if($row->terima_finance==null)
                        Belum
                        @else
                        {{$row->terima_finance}}
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
