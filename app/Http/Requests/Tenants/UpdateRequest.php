<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name'        => 'sometimes|required|string|min:5|max:255|regex:/(^[A-Za-z ÁÉÍÓÚÑáéíóúñ]+$)+/',
            'nicknames'   => 'sometimes|required|array|min:0|max:100',
            'nicknames.*' => 'sometimes|string|min:3|max:50|regex:/(^[A-Za-z0-9 ÁÉÍÓÚÑáéíóúñ]+$)+/',
            'title_id'    => 'sometimes|nullable|integer|exists:titles,id',
            'number'      => 'sometimes|required|integer|min:1',
        ];
    }
}
