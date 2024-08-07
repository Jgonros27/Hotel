<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CabanaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Aquí se puede definir la lógica de autorización si es necesario
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
            'tipoCabana.required' => 'Campo obligatorio.', // Mensaje de error para campo obligatorio
            'tipoCabana.exists' => 'El tipo de cabaña seleccionado no existe en la base de datos.', // Mensaje de error para tipoCabana que no existe
        ];
    }
}
