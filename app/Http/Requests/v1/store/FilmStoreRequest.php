<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class FilmStoreRequest extends FormRequest
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
            'idGenere'=>'required|integer',
            'titolo'=>'required|string|max:45',
            'trama'=>'string|max:255',
            'regista'=>'required|max:45|string',
            'durata'=>'required|string|max:10',
            'anno'=>'required|string'
        ];
    }
}
