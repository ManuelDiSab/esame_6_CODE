<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class indirizzoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "idTipologiaIndirizzo"=>'|integer',
            "idNazione"=>'|integer',
            'idComune'=>'|integer',
            "indirizzo"=>'|string|max:45',
            "civico"=>'|string|max:10',
            "cap"=>'|string|max:10',
            "località"=>'|string|max:10'
        ];
    }
}
