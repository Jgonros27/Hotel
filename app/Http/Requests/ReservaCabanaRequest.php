<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReservaCabanaRequest extends FormRequest
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
        // Obtener el tipo de cabaña seleccionado
        $tipoCabanaId = $this->input('tipoCabana');

        // Obtener la capacidad máxima de huéspedes para el tipo de cabaña seleccionado
        $capacidadMaxima = DB::table('tipo_cabanas')->where('id', $tipoCabanaId)->value('capacidad');
        return [
            'usuario' => [
                'required', // El campo usuario es obligatorio
                Rule::exists('users', 'id'), // Verificar que el valor exista en la tabla users
            ],
            'tipoCabana' => [
                'required', // El campo tipoCabana es obligatorio
                Rule::exists('tipo_cabanas', 'id'), // Verificar que el valor exista en la tabla tipo_cabanas
            ],
            'fechaEntrada' => 'required|date', // La fecha de entrada es obligatoria y debe ser una fecha válida
            'fechaSalida' => 'required|date|after:fechaEntrada', // La fecha de salida es obligatoria, debe ser una fecha válida y posterior a la fecha de entrada
            'nHuespedes' => [
                'required', // El campo nHuespedes es obligatorio
                'integer', // Debe ser un número entero
                'between:1,'.$capacidadMaxima, // Debe estar entre 1 y 10
            ],
            'mediaPension' => 'nullable', // La media pensión es opcional
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        // Obtener el tipo de cabaña seleccionado
        $tipoCabanaId = $this->input('tipoCabana');

        // Obtener la capacidad máxima de huéspedes para el tipo de cabaña seleccionado
        $capacidadMaxima = DB::table('tipo_cabanas')->where('id', $tipoCabanaId)->value('capacidad');
        return [
            'usuario.required' => __('validation.required'), // Mensaje de error para campo usuario obligatorio
            'usuario.exists' => __('validation.exists', ['attribute' => __('validation.attributes.user')]), // Mensaje de error para usuario que no existe
            'tipoCabana.required' => __('validation.required'), // Mensaje de error para campo tipoCabana obligatorio
            'tipoCabana.exists' => __('validation.exists', ['attribute' => __('validation.attributes.cabin_type')]), // Mensaje de error para tipoCabana que no existe
            'fechaEntrada.required' => __('validation.required' , ['attribute' => __('validation.attributes.departure_date')]), // Mensaje de error para fechaEntrada obligatoria
            'fechaEntrada.date' => __('validation.date' , ['attribute' => __('validation.attributes.departure_date')]), // Mensaje de error para fechaEntrada no válida
            'fechaSalida.required' => __('validation.required' , ['attribute' => __('validation.attributes.departureSalida_date')]), // Mensaje de error para fechaSalida obligatoria
            'fechaSalida.date' => __('validation.date' , ['attribute' => __('validation.attributes.departureSalida_date')]), // Mensaje de error para fechaSalida no válida
            'fechaSalida.after' => __('validation.after', ['attribute' => __('validation.attributes.departureSalida_date')]), // Mensaje de error para fechaSalida no posterior a fechaEntrada
            'nHuespedes.required' => __('validation.required' , ['attribute' => __('validation.attributes.huespedes')]), // Mensaje de error para nHuespedes obligatorio
            'nHuespedes.integer' => __('validation.integer' , ['attribute' => __('validation.attributes.huespedes')]), // Mensaje de error para nHuespedes no entero
            'nHuespedes.between' => __('validation.between.numeric', ['min' => 1, 'max' => $capacidadMaxima]), // Mensaje de error para nHuespedes fuera de rango
        ];
    }
}
