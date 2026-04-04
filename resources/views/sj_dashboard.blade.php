@extends('layouts.app')
@section('content')
<div class="container-full">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a><big><big><big><span style="font-family: calibri;">Surat Jalan</span></big></big></big> <span class="label label-warning"></span></a></li>
                    <li><a href="{{ url('/sj_outstanding') }}"><span style="font-family: calibri; color: black;"><big>Outstanding SJ > 7 Hari</big></span> <span class="label label-success"></span></a></li>
                </ul>
                <div class="panel-body">
                    @if(in_array(Auth::user()->name, ['ppic', 'pc']))
                        <a href="{{ url('/sj_balik') }}" class="btn btn-md btn-warning">Scan Disini >> SJ BALIK & Ke Finance</a>
                        <br><br>
                    @elseif(Auth::user()->name == 'finance')
                        <a href="{{ url('/terima_finance') }}" class="btn btn-md btn-success">FINANCE</a>
                        <br><br>
                    @endif

                    @include('partials.flash_message')

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

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('#sj_ppic').DataTable({
        lengthMenu: [[10, 25, 50, -1], ['10', '25', '50', 'Show all']],
        dom: 'lBfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'],
        processing: true,
        ajax: {
            url: '{{ url("data_outstanding_sj") }}',
            type: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            error: function(xhr, error, thrown) {
                console.log('AJAX Error:', error, thrown);
                console.log('Response:', xhr.responseText);
            }
        },
        columns: [
            { data: 'created_at', name: 'created_at' },
            { data: 'tanggal_delivery', name: 'tanggal_delivery' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'pdsnumber', name: 'pdsnumber' },
            { data: 'doaii', name: 'doaii' },
            { data: 'sj_balik', name: 'sj_balik' },
            { data: 'terima_finance', name: 'terima_finance' }
        ]
    });
});
</script>
@endpush
