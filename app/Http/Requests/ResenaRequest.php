<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResenaRequest extends FormRequest
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
            'usuario' => [
                'required', // El campo usuario es obligatorio
                Rule::exists('users', 'id'), // Verificar que el valor exista en la tabla users
            ],
            'puntuacion' => 'required|integer|between:1,5', // La puntuación es obligatoria, debe ser un número entero entre 1 y 5
            'comentario' => 'nullable', // El comentario es opcional
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
            'usuario.required' => __('validation.required'), // Mensaje de error para campo usuario obligatorio
            'usuario.exists' => __('validation.exists', ['attribute' => __('validation.attributes.user')]), // Mensaje de error para usuario que no existe
            'puntuacion.required' => __('validation.required',['attribute' => __('inicio.puntuacion')]), // Mensaje de error para puntuación obligatoria
            'puntuacion.integer' => __('validation.integer'), // Mensaje de error para puntuación que no es un número entero
            'puntuacion.between' => __('validation.between.numeric', ['min' => 1, 'max' => 5]), // Mensaje de error para puntuación fuera del rango
        ];
    }
}
