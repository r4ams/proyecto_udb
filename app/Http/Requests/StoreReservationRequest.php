<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Reglas de validación que aplican a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
            'phone' => 'required|string|regex:/^\d{8,15}$/',
            'reservation_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'customer_name.required' => 'El nombre del cliente es obligatorio.',
            'customer_name.string' => 'El nombre del cliente debe ser una cadena de texto.',
            'customer_name.max' => 'El nombre del cliente no debe exceder los 255 caracteres.',
            'table_id.required' => 'La mesa es obligatoria.',
            'table_id.exists' => 'La mesa seleccionada no existe.',
            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.string' => 'El número de teléfono debe ser una cadena de texto.',
            'phone.regex' => 'El número de teléfono debe tener entre 8 y 15 dígitos.',
            'reservation_date.required' => 'La fecha de reservación es obligatoria.',
            'reservation_date.date' => 'La fecha de reservación debe ser una fecha válida.',
            'reservation_date.after_or_equal' => 'La fecha de reservación debe ser hoy o en el futuro.',
        ];
    }
}
