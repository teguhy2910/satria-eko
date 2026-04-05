@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">
        <div class="col-md-12">
            @include('partials.flash_message')

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a><big><big><big><span style="font-family: calibri;">Surat Jalan</span></big></big></big> <span class="label label-warning"></span></a></li>
                </ul>
                <div class="panel-body">
                    @if(in_array(Auth::user()->name, ['ppic', 'pc']))
                        <a href="{{ url('/sj_balik') }}" class="btn btn-md btn-warning">Scan Disini >> SJ BALIK & Ke Finance</a>
                        <br><br>
                    @elseif(Auth::user()->name == 'finance')
                        <a href="{{ url('/terima_finance') }}" class="btn btn-md btn-success">FINANCE</a>
                        <br><br>
                    @endif

                    <form method="post" action="{{ url('/filter_view') }}" class="pull-right">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <label>FROM</label>
                                <input type="date" name="from" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>TO</label>
                                <input type="date" name="to" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label><br>
                                <input type="submit" class="btn btn-md btn-primary">
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

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#sj_all_ppic').DataTable({
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', 'Show all']],
        dom: 'lBfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'],
        processing: true,
        ajax: {
            url: '{{ url("data_sj") }}',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'tanggal_delivery', name: 'tanggal_delivery' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'pdsnumber', name: 'pdsnumber' },
            { data: 'doaii', name: 'doaii' },
            { data: 'sj_balik', name: 'sj_balik' },
            { data: 'terima_finance', name: 'terima_finance' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
