<?php

namespace Luinux\WordpressLaravelIntegration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWordpressCredential extends FormRequest
{
    /**
     * Determinar si el usuario está autorizado para hacer esta petición.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que aplican a la petición.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'api_key' => 'nullable|string|max:255',
            'api_secret' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Obtener los mensajes de error para las reglas de validación definidas.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la conexión es obligatorio.',
            'url.required' => 'La URL de WordPress es obligatoria.',
            'url.url' => 'La URL de WordPress no tiene un formato válido.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }
}
