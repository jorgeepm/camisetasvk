<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalizarCamisetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'nombre_jugador' => 'required|string|max:15', // Máximo 15 letras
        'dorsal' => 'required|integer|between:1,99', // Número entre 1 y 99
    ];
}
}
