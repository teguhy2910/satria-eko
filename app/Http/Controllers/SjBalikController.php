<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanBarcodeRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Services\SuratJalanImportService;
use App\SuratJalan;
use Illuminate\Support\Facades\Session;

class SjBalikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('sj_balik');
    }

    public function scanStore(ScanBarcodeRequest $request)
    {
        $sj = SuratJalan::findByDoaii($request->doaii)->first();

        if (!$sj) {
            Session::flash('danger', 'Nomor PDS Salah !!!');
            return redirect('/sj_balik');
        }

        if ($sj->isSjBalik()) {
            Session::flash('danger', 'SJ Sudah BALIK !!!');
            return redirect('/sj_balik');
        }

        $sj->markSjBalik();
        Session::flash('message', 'Sukses Simpan Nomor PDS = ' . $request->doaii);

        return redirect('/sj_balik');
    }

    public function uploadStore(ImportExcelRequest $request, SuratJalanImportService $importService)
    {
        $result = $importService->bulkUpdateFromExcel(
            $request,
            'update_sj_balik_ppic',
            'sj_balik',
            'SJ Sudah Balik'
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
            'SJ Sudah Balik'
        );

        return redirect('/sj/dashboard');
    }
}
