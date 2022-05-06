<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function getDiscounts()
    {
        $discounts = Discount::get();

        return response()->json([
            'discounts' => $discounts,
            'code' => 201,
        ]);
    }

    public function createDiscount(Request $request)
    {
        $messages = [
            'discount.required' => 'El campo descuento es requerido',
            'discount.numeric' => 'El campo descuento debe ser un número',
            'discount.min' => 'El campo descuento debe ser mayor a 0',
            'discount.max' => 'El campo descuento debe ser menor a 100',
            'minutes.required' => 'El campo minutos es requerido',
            'minutes.numeric' => 'El campo minutos debe ser un número',
            'minutes.min' => 'El campo minutos debe ser mayor a 0',
        ];

        $validator = Validator::make($request->all(), [
            'discount' => 'required|numeric|min:1|max:100',
            'minutes' => 'required|numeric|min:1',
        ], $messages);
        

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'code' => 422,
            ]);
        }
        
        $discount = new Discount();
        $discount->discount = $request->discount;
        $discount->minutes = $request->minutes;
        $discount->save();

        return response()->json([
            'message' => 'Descuento creado correctamente',
            'code' => 201,
        ]);
    }

    public function editDiscount(Request $request)
    {
        $discount = Discount::find($request->id);

        if (!$discount) {
            return response()->json([
                'message' => 'Descuento no encontrado',
                'code' => 404,
            ]);
        }

        $messages = [
            'discount.required' => 'El campo descuento es requerido',
            'discount.numeric' => 'El campo descuento debe ser un número',
            'discount.min' => 'El campo descuento debe ser mayor a 0',
            'discount.max' => 'El campo descuento debe ser menor a 100',
            'minutes.required' => 'El campo minutos es requerido',
            'minutes.numeric' => 'El campo minutos debe ser un número',
            'minutes.min' => 'El campo minutos debe ser mayor a 0',
        ];

        $validator = Validator::make($request->all(), [
            'discount' => 'required|numeric|min:1|max:100',
            'minutes' => 'required|numeric|min:1',
        ], $messages);
        

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'code' => 422,
            ]);
        }

        $discount->discount = $request->discount;
        $discount->minutes = $request->minutes;
        $discount->save();

        return response()->json([
            'message' => 'Descuento editado correctamente',
            'code' => 201,
        ]);
    }

    public function deleteDiscount(Request $request)
    {
        $discount = Discount::find($request->id);

        if (!$discount) {
            return response()->json([
                'message' => 'Descuento no encontrado',
                'code' => 404,
            ]);
        }

        $discount->delete();

        return response()->json([
            'message' => 'Descuento eliminado correctamente',
            'code' => 201,
        ]);
    }
}