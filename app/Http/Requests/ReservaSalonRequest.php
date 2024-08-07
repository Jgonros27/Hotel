<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservaSalonRequest extends FormRequest
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
            'salon' => [
                'required', // El campo salon es obligatorio
                Rule::exists('salons', 'id'), // Verificar que el valor exista en la tabla salons
            ],
            'fechaEvento' => 'required|date', // La fecha del evento es obligatoria y debe ser una fecha válida
            'horaInicio' => 'required|date_format:H:i', // La hora de inicio es obligatoria y debe ser en formato HH:mm
            'horaFin' => 'required|date_format:H:i|after:horaInicio', // La hora de fin es obligatoria, debe ser en formato HH:mm y posterior a horaInicio
            'tipoEvento' => 'required|in:cumpleaños,boda,bautizo,comunion,evento_empresarial,otros', // El tipo de evento es obligatorio y debe estar dentro de las opciones dadas
            'mensaje' => 'required', // El mensaje es obligatorio
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

            'salon.required' => __('validation.required'), // Mensaje de error para campo salon obligatorio
            'salon.exists' => __('validation.exists', ['attribute' => __('validation.attributes.salon')]), // Mensaje de error para salon que no existe

            'fechaEvento.required' => __('validation.required', ['attribute' => __('validation.attributes.event_date')]), // Mensaje de error para fechaEvento obligatoria
            'fechaEvento.date' => __('validation.date', ['attribute' => __('validation.attributes.event_date')]), // Mensaje de error para fechaEvento no válida

            'horaInicio.required' => __('validation.required', ['attribute' => __('validation.attributes.start_time')]), // Mensaje de error para horaInicio obligatoria
            'horaInicio.date_format' => __('validation.date_format', ['attribute' => __('validation.attributes.start_time'), 'format' => 'HH:mm']), // Mensaje de error para horaInicio no en formato HH:mm

            'horaFin.required' => __('validation.required', ['attribute' => __('validation.attributes.end_time')]), // Mensaje de error para horaFin obligatoria
            'horaFin.date_format' => __('validation.date_format', ['attribute' => __('validation.attributes.end_time'), 'format' => 'HH:mm']), // Mensaje de error para horaFin no en formato HH:mm
            'horaFin.after' => __('validation.after', ['attribute' => __('validation.attributes.end_time')]), // Mensaje de error para horaFin no posterior a horaInicio

            'tipoEvento.required' => __('validation.required', ['attribute' => __('validation.attributes.event_type')]), // Mensaje de error para tipoEvento obligatorio
            'tipoEvento.in' => __('validation.in', ['attribute' => __('validation.attributes.event_type')]), // Mensaje de error para tipoEvento no en las opciones permitidas

            'mensaje.required' => __('validation.required', ['attribute' => __('validation.attributes.mensaje')]), // Mensaje de error para mensaje obligatorio
        ];
    }
}
