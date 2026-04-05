@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="border: 4px solid #a1a1a1;">
            <h2><center><span style="color: white;">EDIT SJ</span></center></h2>
            <center>
                <form action="{{ url('/edit_sj/' . $data->id) }}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                    <label>Tanggal Delivery</label>
                    <input type="date" class="form-control" value="{{ $data->tanggal_delivery }}" name="tanggal_delivery" />
                    <label>Customer Name</label>
                    <input type="text" class="form-control" value="{{ $data->customer_name }}" name="customer_name" />
                    <label>PDS Number</label>
                    <input type="text" class="form-control" value="{{ $data->pdsnumber }}" name="pdsnumber" />
                    <label>DO AII</label>
                    <input type="text" class="form-control" value="{{ $data->doaii }}" name="doaii" />
                    <br>
                    <input type="submit" value="EDIT" class="btn btn-md btn-success">
                    <br><hr>
                </form>
            </center>
        </div>
    </div>
</div>
@endsection
