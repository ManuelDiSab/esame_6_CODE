<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class SerieTVStoreRequest extends FormRequest
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
            'idGenere' => 'required|integer',
            'titolo' => 'required|string|max:45',
            'trama' => 'string|max:255',
            'n_stagioni' => 'required|integer',
            'anno_inizio' => 'required|string|max:4',
            'anno_fine' => 'string|max:10'
        ];
    }
}
