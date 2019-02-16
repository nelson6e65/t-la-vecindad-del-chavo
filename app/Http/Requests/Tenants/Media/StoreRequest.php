<?php

namespace App\Http\Requests\Tenants\Media;

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
            'image' => 'required|image64:jpeg,jpg,png',
            // FIXME ,svg,svg+xml Se guardan, pero no se muestran bien de vuelta.
        ];
    }
}
