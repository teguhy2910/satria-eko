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
                    <table id="sj_filter" class="table table-bordered table-condensed table-hover dt-responsive">
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
                            </tr>
                        </thead>
                        @foreach($data as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->tanggal_delivery }}</td>
                                <td>{{ $row->customer_name }}</td>
                                <td>{{ $row->pdsnumber }}</td>
                                <td>{{ $row->doaii }}</td>
                                <td>{{ $row->sj_balik }}</td>
                                <td>{{ $row->terima_finance }}</td>
                            </tr>
                        @endforeach
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
    $('#sj_filter').DataTable({
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', 'Show all']],
        dom: 'lBfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5']
    });
});
</script>
@endpush
