<?php

namespace App\Http\Requests\v1;

use App\Helpers\AppHelpers;

class TipologiaIndirizzoUpdateRequest extends TipologiaIndirizzoStoreRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        return AppHelpers::AggiornaRegoleHelper($rules);
    }
}