<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuratJalanRequest;
use App\Http\Requests\UpdateSuratJalanRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Services\SuratJalanImportService;
use App\SuratJalan;
use Illuminate\Support\Facades\Session;

class SjCrudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadSjForm()
    {
        return view('upload_sj_dashboard');
    }

    public function create()
    {
        return view('create_sj');
    }

    public function store(StoreSuratJalanRequest $request)
    {
        SuratJalan::create($request->validated());

        return redirect('create/sj')->with('message', 'Sukses membuat SJ');
    }

    public function edit($id)
    {
        $data = SuratJalan::findOrFail($id);

        return view('sj_update', compact('data'));
    }

    public function update(UpdateSuratJalanRequest $request, $id)
    {
        SuratJalan::findOrFail($id)->update($request->validated());

        Session::flash('warning', 'EDIT data BERHASIL');
        return redirect('dashboard');
    }

    public function destroy($id)
    {
        SuratJalan::findOrFail($id)->delete();

        Session::flash('warning', 'PDS NUMBER berhasil dihapus');
        return redirect('/dashboard');
    }

    public function uploadSj(ImportExcelRequest $request, SuratJalanImportService $importService)
    {
        $result = $importService->importFromExcel($request, 'sj');

        Session::flash($result['status'], $result['message']);

        return redirect('/sj/dashboard');
    }

    public function downloadSj(SuratJalanImportService $importService)
    {
        return $importService->exportAll();
    }
}
