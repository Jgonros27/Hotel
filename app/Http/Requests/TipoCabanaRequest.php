<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCabanaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255', // El nombre es obligatorio, cadena de texto y máximo 255 caracteres
            'precio' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // El precio es obligatorio, numérico y puede tener máximo dos decimales
            'capacidad' => 'required|integer', // La capacidad es obligatoria y debe ser un número entero
            'servicios' => 'required|string', // Los servicios son obligatorios y deben ser una cadena de texto
            'precio_media_pension' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/', // El precio de media pensión es obligatorio, numérico y puede tener máximo dos decimales
            'dias_cancelacion' => 'required|integer', // Los días de cancelación son obligatorios y deben ser un número entero
            'especificaciones' => 'required|string', // Las especificaciones son obligatorias y deben ser una cadena de texto
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

            'precio.required' => 'Campo obligatorio.', // Mensaje de error para precio obligatorio
            'precio.numeric' => 'Debe ser un número.', // Mensaje de error para precio no es un número
            'precio.regex' => 'Debe tener hasta dos decimales.', // Mensaje de error para precio con más de dos decimales

            'capacidad.required' => 'Campo obligatorio.', // Mensaje de error para capacidad obligatoria
            'capacidad.integer' => 'Debe ser un número entero.', // Mensaje de error para capacidad no es un número entero

            'servicios.required' => 'Campo obligatorio.', // Mensaje de error para servicios obligatorios
            'servicios.string' => 'Deben ser una cadena de texto.', // Mensaje de error para servicios no es una cadena de texto

            'precio_media_pension.required' => 'Campo obligatorio.', // Mensaje de error para precio de media pensión obligatorio
            'precio_media_pension.numeric' => 'Debe ser un número.', // Mensaje de error para precio de media pensión no es un número
            'precio_media_pension.regex' => 'Debe tener hasta dos decimales.', // Mensaje de error para precio de media pensión con más de dos decimales

            'dias_cancelacion.required' => 'Campo obligatorio.', // Mensaje de error para días de cancelación obligatorios
            'dias_cancelacion.integer' => 'Debe ser un número entero.', // Mensaje de error para días de cancelación no es un número entero

            'especificaciones.required' => 'Campo obligatorio.', // Mensaje de error para especificaciones obligatorias
            'especificaciones.string' => 'Debe ser una cadena de texto.', // Mensaje de error para especificaciones no es una cadena de texto
        ];
    }
}
