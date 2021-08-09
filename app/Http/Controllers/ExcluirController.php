<?php

namespace App\Http\Controllers;

use App\Models\Atribuicoe;
use App\Models\Departamento;
use App\Models\Relacionamento;
use Illuminate\Http\Request;

class ExcluirController extends Controller
{
    public function deleteAtributo(Request $request)
    {
        if(Atribuicoe::where('id_relacionamento', '=', $request->id_relacionamento)->where('id_user', '=', $request->rel_user_edit)->first()){
            $user = Atribuicoe::where('id_relacionamento', '=', $request->id_relacionamento)->where('id_user', '=', $request->rel_user_edit)->first();
            $user->delete();

            return redirect()->route('paineladm');
        }else{
            session()->flash('errorelacionameto', 'Usuario não esta atibuido a este Relacionamento!');
            return redirect()->route('paineladm');
        }
    }

    public function excluirDep(Request $request)
    {
        if(!Relacionamento::where('departamentos_id', '=', $request->id_departamento)->first()){
            $dep = Departamento::where('id', '=', $request->id_departamento)->first();
            $dep->delete();

            return redirect()->route('paineladm');
        }elseif(Relacionamento::where('id', '=', $request->id_departamento)->first()){
            $relacionamento = Relacionamento::where('id', '=', $request->id_departamento)->first();
            session()->flash('errorelacionameto', 'Não é possivel excluir, departamento está no relacionamento: ' . $relacionamento->id);
            return redirect()->route('paineladm');
        }
    }
        
}
