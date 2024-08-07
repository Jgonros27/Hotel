<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioUpdateRequest extends FormRequest
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
        // Obtiene el ID del usuario que está siendo actualizado
        $userId = $this->input('user_id');

        return [
            'name' => 'nullable|string', // El nombre es opcional y debe ser una cadena de texto
            'email' => [ // El correo electrónico puede ser nulo o único, ignorando el correo electrónico del usuario actual
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'nullable|min:6|confirmed', // La contraseña es opcional y debe tener al menos 6 caracteres y coincidir con la confirmación
            'password_confirmation' => 'nullable|min:6', // La confirmación de contraseña es opcional y debe tener al menos 6 caracteres
            'admin' => 'nullable|in:on' // El campo de administrador es opcional y solo puede ser 'on'
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
            // Mensajes de error para cada regla de validación
            'name.required' => 'Campo obligatorio.',
            'name.string' => 'Formato no válido.',
            'email.required' => 'Campo obligatorio.',
            'email.email' => 'Formato no válido.',
            'email.unique' => 'Email existente.',
            'password.required' => 'Campo obligatorio',
            'password.min' => 'Introduzca una contraseña mas larga',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password_confirmation.required' => 'Campo obligatorio',
            'password_confirmation.min' => 'Introduzca una contraseña mas larga',

        ];
    }
}
