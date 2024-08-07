<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
            'name' => 'required|string', // El nombre es obligatorio y debe ser una cadena de texto
            'email' => 'required|email|unique:users,email', // El correo electrónico es obligatorio, debe ser un correo electrónico válido y único en la tabla de usuarios
            'password' => 'required|min:6|confirmed', // La contraseña es obligatoria, debe tener al menos 6 caracteres y debe coincidir con el campo de confirmación de contraseña
            'password_confirmation' => 'required|min:6', // El campo de confirmación de contraseña es obligatorio y debe tener al menos 6 caracteres
            'admin' => 'nullable|in:on', // El campo de administrador es opcional y solo puede ser 'on'
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
            'name.required' => 'Campo obligatorio.', // Mensaje de error para nombre obligatorio
            'name.string' => 'Formato no válido.', // Mensaje de error para nombre que no es una cadena de texto

            'email.required' => 'Campo obligatorio.', // Mensaje de error para correo electrónico obligatorio
            'email.email' => 'Formato no válido.', // Mensaje de error para correo electrónico no válido
            'email.unique' => 'Email existente.', // Mensaje de error para correo electrónico que ya existe en la base de datos

            'password.required' => 'Campo obligatorio.', // Mensaje de error para contraseña obligatoria
            'password.min' => 'Introduzca una contraseña más larga.', // Mensaje de error para contraseña que debe tener al menos 6 caracteres
            'password.confirmed' => 'Las contraseñas no coinciden.', // Mensaje de error para contraseña que no coincide con el campo de confirmación de contraseña

            'password_confirmation.required' => 'Campo obligatorio.', // Mensaje de error para confirmación de contraseña obligatoria
            'password_confirmation.min' => 'Introduzca una contraseña más larga.', // Mensaje de error para confirmación de contraseña que debe tener al menos 6 caracteres
        ];
    }
}
