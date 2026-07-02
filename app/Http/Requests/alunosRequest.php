<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class alunosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dataNascimento'=>['required', 'date'],
            'nome'=>['required', 'string', 'max:100'],
            'avatar',
            'doencaCronca',
            'doenca_id'=>['required', 'string', 'max:24'],
            'religiae_id',
            'user_id',
            'encaredado_id',
            'grauParentesto_id',
            'endereco_id',
            'Quarterao',
            'Casa',
            'codigobarra',
            'sexo'
        ];
    }
}
