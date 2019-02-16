<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        return [
            'name'        => 'required|string|min:5|max:255|regex:/(^[A-Za-z ÁÉÍÓÚÑáéíóúñ]+$)+/',
            'nicknames'   => 'present|array|min:0|max:100',
            'nicknames.*' => 'sometimes|string|min:3|max:50|regex:/(^[A-Za-z0-9 ÁÉÍÓÚÑáéíóúñ]+$)+/',
            'title_id'    => 'nullable|integer|exists:titles,id',
            'number'      => 'required|integer|min:1',

        ];
    }
}
