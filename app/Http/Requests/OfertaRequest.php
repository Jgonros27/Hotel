<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Se autoriza por defecto, puedes definir tu lógica de autorización si es necesario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipoCabana' => [
                'required', // El campo tipoCabana es obligatorio
                Rule::exists('tipo_cabanas', 'id'), // Verificar que el valor exista en la tabla tipo_cabanas
            ],
            'descuento' => [
                'required', // El campo descuento es obligatorio
                'integer', // Debe ser un número entero
                'between:1,100', // Debe estar entre 1 y 100
            ],
            'fechaInicio' => 'required|date', // La fecha de inicio es obligatoria y debe ser una fecha válida
            'fechaFin' => 'required|date|after:fechaInicio', // La fecha de fin es obligatoria, debe ser una fecha válida y después de la fecha de inicio
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipoCabana.required' => 'Campo obligatorio.', // Mensaje de error para campo tipoCabana obligatorio
            'tipoCabana.exists' => 'El tipo de cabaña seleccionado no existe en la base de datos.', // Mensaje de error para tipoCabana que no existe
            'descuento.required' => 'Campo obligatorio.', // Mensaje de error para campo descuento obligatorio
            'descuento.integer' => 'Debe ser un número entero.', // Mensaje de error para descuento que no es un número entero
            'descuento.between' => 'Debe estar entre 1 y 100.', // Mensaje de error para descuento fuera del rango
            'fechaInicio.required' => 'Campo obligatorio.', // Mensaje de error para campo fechaInicio obligatorio
            'fechaInicio.date' => 'Debe ser una fecha válida.', // Mensaje de error para fechaInicio que no es una fecha válida
            'fechaFin.required' => 'Campo obligatorio.', // Mensaje de error para campo fechaFin obligatorio
            'fechaFin.date' => 'Debe ser una fecha válida.', // Mensaje de error para fechaFin que no es una fecha válida
            'fechaFin.after' => 'Debe ser posterior a la fecha de inicio.', // Mensaje de error para fechaFin que no es posterior a la fecha de inicio
        ];
    }
}
