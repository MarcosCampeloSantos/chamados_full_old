<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function rules()
    {   
        return [
            'cria_nome' => 'required',
            'nivel_user' => 'required',
            'dep_user' => 'required',
            'cria_email' => 'required',
            'senha' => 'required|min:6|confirmed',
            'senha_confirmation' => 'required'
            
        ];
    }

    public function messages()
    {
        return[
            'cria_nome.required' => 'O Campo Nome é Obrigatorio!',
            'nivel_user.required' => 'Por favor escolher nivel de acesso!',
            'dep_user.required' => 'O Campo Departamento é Obrigatorio!',
            'cria_email.required' => 'O Campo E-mail é obrigatorio!',
            'senha.required' => 'O Campo senha é Obrigatorio!',
            'senha.min' => 'A senha deve ter no minimo :min caracteres!',
            'senha_confirmation.required' => 'O Campo de Confirmação de Senha é Obrigatorio!',
            'senha.confirmed' => 'As senhas não correspondem'
        ];
    }
}
