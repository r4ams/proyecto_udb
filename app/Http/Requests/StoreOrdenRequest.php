<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:255',
            'comments' => 'nullable|string|max:500'
        ];
    }

    /**
     * Obtiene los mensajes personalizados de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'table_id.required' => 'El campo "Mesa" es obligatorio.',
            'table_id.exists' => 'La mesa seleccionada no es válida.',
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_name.string' => 'El nombre del cliente debe ser una cadena de texto.',
            'customer_name.max' => 'El nombre del cliente no puede exceder los 255 caracteres.',
            'comments.string' => 'Los comentarios deben ser una cadena de texto.',
            'comments.max' => 'Los comentarios no pueden exceder los 500 caracteres.'
        ];
    }
}
