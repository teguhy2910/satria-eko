<?php

namespace App\Services;

use App\SuratJalan;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SuratJalanImportService
{
    /**
     * Import SJ from uploaded Excel file.
     */
    public function importFromExcel(Request $request, $fileInput = 'sj')
    {
        if (!$request->hasFile($fileInput)) {
            return ['status' => 'error', 'message' => 'Something Wrong Contact Administrator'];
        }

        $data = Excel::toArray(new \stdClass(), $request->file($fileInput))[0];

        if (empty($data)) {
            return ['status' => 'error', 'message' => 'Something Wrong Contact Administrator'];
        }

        $insert = [];
        foreach ($data as $value) {
            $row = [
                'tanggal_delivery' => $value['tanggal_delivery'] ?? null,
                'customer_name'    => $value['customer_name'] ?? null,
                'pdsnumber'        => $value['pdsnumber'] ?? null,
                'doaii'            => $value['doaii'] ?? null,
            ];

            if (!empty($row['doaii']) && $row['tanggal_delivery'] !== null) {
                $insert[] = $row;
            }
        }

        if (empty($insert)) {
            return ['status' => 'danger', 'message' => 'Gagal Upload SJ'];
        }

        foreach ($insert as $row) {
            SuratJalan::create($row);
        }

        return ['status' => 'message', 'message' => 'Sukses Scan SJ, Total Upload=' . count($insert) . ' SJ'];
    }

    /**
     * Process bulk update from Excel for sj_balik or terima_finance.
     */
    public function bulkUpdateFromExcel(Request $request, $fileInput, $fieldName, $alreadyLabel)
    {
        if (!$request->hasFile($fileInput)) {
            return ['status' => 'error', 'message' => 'Something Wrong Contact Administrator'];
        }

        $data = Excel::toArray(new \stdClass(), $request->file($fileInput))[0];

        if (empty($data)) {
            return ['status' => 'error', 'message' => 'No data found in file'];
        }

        $insert = [];
        $errors = [];

        foreach ($data as $value) {
            $exists = SuratJalan::findByDoaii($value['doaii'] ?? null)->exists();
            if ($exists) {
                $insert[] = ['doaii' => $value['doaii'] ?? null];
            } else {
                $errors[] = ['doaii' => $value['doaii'] ?? null];
            }
        }

        $insert = array_filter($insert, function ($value) {
            return !is_null($value['doaii']) && $value['doaii'] !== '';
        });

        $successCount = 0;
        $failCount = 0;
        $alreadyExists = [];
        $successUpload = [];

        if (!empty($insert)) {
            foreach ($insert as $row) {
                $sj = SuratJalan::findByDoaii($row['doaii'])->first();
                if ($sj && $sj[$fieldName] === null) {
                    $successCount++;
                    $successUpload[] = ['doaii' => $sj->doaii];
                    $sj->update([$fieldName => Carbon::now()]);
                } else {
                    $alreadyExists[] = ['doaii' => $sj->doaii];
                    $failCount++;
                }
            }
        }

        $result = [
            'errors'       => $errors,
            'already'      => $alreadyExists,
            'success'      => $successUpload,
            'alreadyLabel' => $alreadyLabel,
        ];

        if ($successCount > 0) {
            $result['status'] = 'message';
            $result['message'] = 'Sukses Scan SJ, Total Upload=' . $successCount . ' SJ';
        }
        if ($failCount > 0) {
            $result['danger'] = 'Gagal Upload ' . $failCount . ' ' . $alreadyLabel;
        }

        return $result;
    }

    /**
     * Export error/success report as Excel download.
     */
    public function exportErrorReport($errors, $alreadyExists, $successUpload, $alreadyLabel)
    {
        $sheets = [];

        $hasData = false;

        if (!empty($errors)) {
            $sheets[] = ['title' => 'SJ Tidak Ada Di Master', 'data' => $errors];
            $hasData = true;
        }
        if (!empty($alreadyExists)) {
            $sheets[] = ['title' => $alreadyLabel, 'data' => $alreadyExists];
            $hasData = true;
        }
        if (!empty($successUpload)) {
            $sheets[] = ['title' => 'SJ Sukses Upload', 'data' => $successUpload];
            $hasData = true;
        }

        if (!$hasData) {
            return null;
        }

        // Create a multi-sheet export
        return Excel::download(new class($sheets) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            private $sheets;
            
            public function __construct($sheets)
            {
                $this->sheets = $sheets;
            }
            
            public function sheets(): array
            {
                $sheetExports = [];
                foreach ($this->sheets as $sheet) {
                    $sheetExports[] = new class($sheet) implements \Maatwebsite\Excel\Concerns\FromArray {
                        private $sheet;
                        
                        public function __construct($sheet)
                        {
                            $this->sheet = $sheet;
                        }
                        
                        public function array(): array
                        {
                            return $this->sheet['data'];
                        }
                        
                        public function title(): string
                        {
                            return $this->sheet['title'];
                        }
                    };
                }
                return $sheetExports;
            }
        }, 'SJ Error.xlsx');
    }

    /**
     * Export all SJ data to Excel.
     */
    public function exportAll()
    {
        $sj = SuratJalan::all();
        
        // Create a simple export
        $export = new class($sj) implements \Maatwebsite\Excel\Concerns\FromCollection {
            private $sj;
            
            public function __construct($sj)
            {
                $this->sj = $sj;
            }
            
            public function collection()
            {
                return $this->sj;
            }
        };
        
        return Excel::download($export, 'sj.xlsx');
    }
}
