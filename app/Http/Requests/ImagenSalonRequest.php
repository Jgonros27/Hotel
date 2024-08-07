<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImagenSalonRequest extends FormRequest
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
            'salon' => [
                'required', // El campo salon es obligatorio
                Rule::exists('salons', 'id'), // Verificar que el valor exista en la tabla salons
            ],
            'imagenSalon' => 'required', // El campo imagenSalon es obligatorio
            'nombreImagen' => 'nullable', // El campo nombreImagen es opcional
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
            'salon.required' => 'Campo obligatorio.', // Mensaje de error para campo salon obligatorio
            'salon.exists' => 'El salon seleccionado no existe en la base de datos.', // Mensaje de error para salon que no existe
            'imagenSalon.required' => 'Campo obligatorio.', // Mensaje de error para campo imagenSalon obligatorio
        ];
    }
}
