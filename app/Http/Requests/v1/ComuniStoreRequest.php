<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ComuniStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'nome'=> 'required|string|max:45',
            'regione' => 'required|string|max:45',
            'metropolitana' => '|string|max:45',
            'provincia'=> 'required|string|max:45',
            'siglaAuto'=>'required|string|max:2',
            'codCat'=>'required|string|max:4',
            'capoluogo'=>'|string|max:45',
            'multicap'=>'|string|max:3',
            'cap'=>'required|string|max:10',
            'capFine'=>'|string|max:10',
            'capInizio'=> '|string|max:10'
        ];
    }
}

