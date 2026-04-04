<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportExcelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sj' => 'required|mimes:xlsx,xls,csv',
        ];
    }

    public function messages()
    {
        return [
            'sj.required' => 'File Excel wajib dipilih',
            'sj.mimes'    => 'File harus berformat xlsx, xls, atau csv',
        ];
    }
}
