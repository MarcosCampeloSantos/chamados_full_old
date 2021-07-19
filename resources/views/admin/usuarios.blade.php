@extends('styles.home')

@section('title','Chamados-Criar')
@section('name','Novo Chamado')

@section('content')
<div class="n-chamado mx-auto mb-3">
    <form action="{{route('criar_user')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nivel</label>
            <select class="form-select" name="nivel_user" aria-label="Default select example">
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
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="cria_email" id="cria_email" placeholder="Digite o E-mail">
        </div>
        <div class="mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control" name="cria_senha" id="cria_senha" placeholder="Digite a Senha">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>
@endsection