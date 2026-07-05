<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determinar si el usuario esta autorizado.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para el login.
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:100',
        ];
    }

    /**
     * Mensajes personalizados de validacion.
     */
    public function messages(): array
    {
        return [
            'username.required' => 'El campo usuario es obligatorio.',
            'username.string'   => 'El usuario debe ser texto.',
            'password.required' => 'El campo contrasena es obligatorio.',
            'password.string'   => 'La contrasena debe ser texto.',
        ];
    }
}