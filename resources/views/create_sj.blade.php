@extends('layouts.app')
@section('content')
<div class="container-full">
<div class="row">
<div class="col-md-6 col-md-offset-3"  style="border: 4px solid #a1a1a1;">
        <h2><center><font color="white">CREATE SJ</font></center></h2>
        <center>
        <form action="{{asset('create/sj')}}" class="form-horizontal" method="post">
        {{ csrf_field() }}
        <label for="">Tanggal Delivery</label>
        <input type="date" class="form-control" name="tanggal_delivery" />
        <label for="">Customer Name</label>
        <input type="text" class="form-control" name="customer_name" />
        <label for="">Cycle</label>
        <input type="number" class="form-control" name="cycle" />
        <label for="">PDS Number</label>
        <input type="text" class="form-control" name="pdsnumber" />
        <label for="">DO AII</label>
        <input type="text" class="form-control" name="doaii" />
        <label for="">DO AIIA</label>
        <input type="text" class="form-control" name="doaiia" />
        <br>
        <input type="submit" value="Create" class="btn btn-md btn-success">
        <br> <hr>
        </center>
        </form>       
        </div>
</div>
</div>

@endsection
