@extends('styles.home')

@section('title','Chamados-Criar')

@section('name','Novo Chamado')

@section('content')
{{---------------------FORMULARIO PARA CRIAÇÃO DE CHAMADOS------------------------}}
<div class="n-chamado mx-auto mb-3">
    <form action="{{route('chamadoCriar')}}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Topicos</label>
            <select class="form-select" name="topico" aria-label="Default select example">
                <option selected>Selecione um Topico de Suporte</option>
                <option value="1">Protheus</option>
                <option value="2">Chamados</option>
                <option value="3">Acessos</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tutulo</label>
            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Digite o Titulo">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Conteudo</label>
            <textarea class="form-control" name="conteudo" id="conteudo" rows="3" placeholder="Digite o Assunto"></textarea>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Anexo</label>
            <input class="form-control" name="anexo" type="file" id="formFile">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </form>
</div>
@endsection