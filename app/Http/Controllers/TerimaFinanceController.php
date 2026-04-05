<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanBarcodeRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Services\SuratJalanImportService;
use App\SuratJalan;
use Illuminate\Support\Facades\Session;

class TerimaFinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = SuratJalan::groupedByDoaii()->get();

        return view('terima_finance', compact('data'));
    }

    public function scanStore(ScanBarcodeRequest $request)
    {
        $sj = SuratJalan::findByDoaii($request->doaii)->first();

        if (!$sj) {
            Session::flash('danger', 'Nomor PDS Salah !!!');
            return redirect('/terima_finance');
        }

        if ($sj->isTerimaFinance()) {
            Session::flash('danger', 'SJ Sudah diterima Finance !!!');
            return redirect('/terima_finance');
        }

        $sj->markTerimaFinance();
        Session::flash('message', 'Sukses Simpan Nomor PDS = ' . $request->doaii);

        return redirect('/terima_finance');
    }

    public function uploadStore(ImportExcelRequest $request, SuratJalanImportService $importService)
    {
        $result = $importService->bulkUpdateFromExcel(
            $request,
            'update_fin_upload',
            'terima_finance',
            'SJ Sudah Terima Finance'
        );

        if (isset($result['status'])) {
            Session::flash($result['status'], $result['message']);
        }
        if (isset($result['danger'])) {
            Session::flash('danger', $result['danger']);
        }

        $importService->exportErrorReport(
            $result['errors'],
            $result['already'],
            $result['success'],
            'SJ Sudah Terima Finance'
        );

        return redirect('/sj/dashboard');
    }
}
