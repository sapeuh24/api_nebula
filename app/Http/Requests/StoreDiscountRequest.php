<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'discount' => 'required|numeric|min:1|max:100',
            'minutes' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'discount.required' => 'El campo descuento es requerido',
            'discount.numeric' => 'El campo descuento debe ser un número',
            'discount.min' => 'El campo descuento debe ser mayor a 0',
            'discount.max' => 'El campo descuento debe ser menor a 100',
            'minutes.required' => 'El campo minutos es requerido',
            'minutes.numeric' => 'El campo minutos debe ser un número',
            'minutes.min' => 'El campo minutos debe ser mayor a 0',
        ];
    }
}