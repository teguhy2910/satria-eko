<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratJalanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tanggal_delivery' => 'required|date',
            'customer_name'    => 'required|string|max:255',
            'pdsnumber'        => 'required|string|max:255',
            'doaii'            => 'required|string|max:255',
        ];
    }
}
