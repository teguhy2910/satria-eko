<?php

namespace App\Http\Controllers;

use App\SuratJalan;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class SjDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('/sj/dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function sjDashboard()
    {
        return view('sj_dashboard');
    }

    public function sjOutstanding()
    {
        return view('sj_outstanding');
    }

    public function uploadSjDashboard()
    {
        return view('upload_sj_dashboard');
    }

    public function filterView(Request $request)
    {
        $this->validate($request, [
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ]);

        $data = SuratJalan::whereBetween('tanggal_delivery', [$request->from, $request->to])
            ->groupedByDoaii()
            ->get();

        return view('dashboard_filter', compact('data'));
    }

    public function dataSj()
    {
        $query = SuratJalan::select('id', 'created_at', 'tanggal_delivery', 'customer_name', 'pdsnumber', 'doaii', 'sj_balik', 'terima_finance');
            // ->groupedByDoaii(); // Removed GROUP BY as it causes DataTables issues

        return Datatables::of($query)
            ->addColumn('action', function ($data) {
                return '<a class="btn btn-warning btn-xs" href="edit_sj/' . $data->id . '">Edit</a>
                <a class="btn btn-danger btn-xs" href="delete_sj/' . $data->id . '">Del</a>';
            })
            ->make();
    }

    public function dataOutstandingSj()
    {
        $query = SuratJalan::select('created_at', 'tanggal_delivery', 'customer_name', 'pdsnumber', 'doaii', 'sj_balik', 'terima_finance')
            ->recentDays(7);
            // ->groupedByDoaii(); // Removed GROUP BY as it causes DataTables issues

        if (\Auth::user()->name === 'finance') {
            $query->notReceivedByFinance();
        } else {
            $query->outstanding();
        }

        return Datatables::of($query)->make();
    }

    public function dataOutstandingSj7Day()
    {
        $query = SuratJalan::select('created_at', 'tanggal_delivery', 'customer_name', 'pdsnumber', 'doaii', 'sj_balik', 'terima_finance')
            ->olderThanDays(7)
            ->outstanding();
            // ->groupedByDoaii(); // Removed GROUP BY as it causes DataTables issues

        return Datatables::of($query)->make();
    }
}
