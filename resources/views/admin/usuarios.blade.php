@extends('styles.home')

@section('title','Chamados-Criar')
@section('name','Novo Chamado')

@section('content')
<div class="n-chamado mx-auto mb-3">
    <form>
        <div class="mb-3">
            <label class="form-label">Topicos</label>
            <select class="form-select" aria-label="Default select example">
                <option selected>Selecione um Topico de Suporte</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tutulo</label>
            <input type="email" class="form-control" id="titulo" placeholder="Digite o Titulo">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Conteudo</label>
            <textarea class="form-control" id="conteudo" rows="3" placeholder="Digite o Assunto"></textarea>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Anexo</label>
            <input class="form-control" type="file" id="formFile">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>
@endsection