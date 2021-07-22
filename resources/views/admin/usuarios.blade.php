@extends('styles.home')

@section('title','Chamados-Criar')
@section('name','Criação e Edição de Usuario')

@section('content')
{{---------------------BOTÃO PARA CHAMAR MODAL------------------------}}
<div class="m-3">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Novo Usuario
    </button>
</div>
<div class="n-chamado mx-auto mb-3">

{{---------------------MODAL------------------------}}
<div class="modal fade" data-bs-backdrop="static" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Criação de Novo Usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <div class="modal-body">
        {{---------------------FORMULARIO DE CRIAÇÃO DE USUARIO------------------------}}
        <form action="{{route('criar_user')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nivel</label>
                <select class="form-select overflow-auto" name="nivel_user" aria-label="Default select example">
                    <option selected>Selecione Nivel do Usuario</option>
                    <option value="1">Admin</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control" name="cria_nome" id="cria_email" placeholder="Digite o Nome">
            </div>
            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <select class="form-select" name="dep_user" aria-label="Default select example">
                    <option selected>Selecione Nivel do Usuario</option>
                    @foreach ($departamento as $item)
                    <option value="{{$item->departamento}}">{{$item->departamento}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control" name="cria_email" id="cria_email" placeholder="Digite o E-mail">
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control" name="cria_senha" id="cria_senha" placeholder="Digite a Senha">
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" name="cria_senha" id="confirm_senha" placeholder="Digite a Senha">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
    </div>
    </div>
</div>
</div>
</div>
{{---------------------TABELA COM A LISTAGEM DE TODOS USUARIOS ATIVOS------------------------}}
<div class="overflow-auto listagem-chamados border rounded-2 m-3">
    <table class="table table-striped table-hover">
        <thead>
            <tr class="table-dark sticky-top">
                <th scope="row">CODIGO</th>
                <th scope="row">NOME</th>
                <th scope="row">DEPARTAMENTO</th>
                <th scope="row">NIVEL DE ACESSO</th>
                <th scope="row">DATA</th>
                <th scope="row" class="text-center">EDITAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td >{{$item->name}}</td>
                <td>{{$item->departamento}}</td>
                @if ($item->nivel == '1')
                <td>Administrador</td>
                @else
                <td>Usuario</td>
                @endif
                <td>{{$item->created_at}}</td>
                <td class="text-center"><a href="#"><i class="fas fa-edit"></a></i></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection