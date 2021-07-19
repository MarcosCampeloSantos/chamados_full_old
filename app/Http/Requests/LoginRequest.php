<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return[
            'loginemail' => 'required|email',
            'loginpassword' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return[
            'loginemail.required' => 'O Campo Email é Obrigatorio!',
            'loginemail.email' => 'Por favor inserir um E-mail Valido!',
            'loginpassword.required' => 'O Campo Senha é Obrigatorio!',
            'loginpassword.min' => 'A senha deve ter no minimo :min caracteres!'
        ];
    }
}
