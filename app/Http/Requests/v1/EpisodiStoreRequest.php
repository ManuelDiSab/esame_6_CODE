<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class EpisodiStoreRequest extends FormRequest
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
            'idSerie'=>'required|integer',
            'titolo' => 'required|string|max:45',
            'durata' => 'string|max:255',
            'numero' => 'required|integer',
            'stagione' => 'required|integer',
            'voto' => 'string|max:3|min:0',
            'trama'=>'string|max:500',
            'path_img' => 'required|image|mimes:jpeg,pbg,jpg,wepb|max:4048',
            'path_video' => 'required|mimes:mp4,m4v,mov,avi,mkv'
        ];
    }
}
