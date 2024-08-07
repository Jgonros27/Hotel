<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Se autoriza por defecto, puedes definir tu lógica de autorización si es necesario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255', // El nombre es obligatorio, debe ser una cadena de texto y tener máximo 255 caracteres
            'descripcion' => 'required|string', // La descripción es obligatoria y debe ser una cadena de texto
            'precio_hora' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // El precio por hora es obligatorio, numérico y puede tener máximo dos decimales
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'Campo obligatorio.', // Mensaje de error para nombre obligatorio
            'nombre.string' => 'Debe ser una cadena de texto.', // Mensaje de error para nombre no es una cadena de texto
            'nombre.max' => 'No debe superar los 255 caracteres.', // Mensaje de error para nombre que excede los 255 caracteres

            'descripcion.required' => 'Campo obligatorio.', // Mensaje de error para descripción obligatoria
            'descripcion.string' => 'Debe ser una cadena de texto.', // Mensaje de error para descripción no es una cadena de texto

            'precio_hora.required' => 'Campo obligatorio.', // Mensaje de error para precio por hora obligatorio
            'precio_hora.numeric' => 'Debe ser un número.', // Mensaje de error para precio por hora no es un número
            'precio_hora.regex' => 'Debe tener máximo dos decimales.', // Mensaje de error para precio por hora con más de dos decimales
        ];
    }
}
