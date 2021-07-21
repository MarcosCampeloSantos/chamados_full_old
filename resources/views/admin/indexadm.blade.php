@extends('styles.home')

@section('title','Chamados-Home')

@section('name','Chamados')

@section('content')
{{---------------------TELA HOME DE USUARIO ADM------------------------}}
<div class="row justify-content-center mb-5 index">
    <div class="overflow-hidden card perfil text-center">
        <i class="fas fa-address-card mt-3 fa-4x"></i>
        <div class="card-body lh-1">
            <a href=""><h6 class="display-6">Perfil</h6></a>
            <div class="">
                <p class="card-title text-center">Bem vindo,<b> {{$name}}</b></p>
            </div>
            <a href="{{route('paineladm')}}" class="btn btn-primary btn-sm mt-3"><i class="fas fa-tachometer-alt"></i> Painel de Administração</a>
            <a href="{{route('sair')}}" class="btn btn-primary btn-sm mt-3"><i class="fas fa-door-open"></i> Sair</a>
        </div>
    </div>
    <a href="{{route('chamado')}}" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo chamado</a>
    <a href="{{route('usuarios')}}" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Criar e Editar Usuarios</a>
    <a href="#" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
</div>

{{---------------------LISTAGEM DE TODOS OS CHAMADOS EM ABERTO------------------------}}
<div>
    <h3 class="display-6 text-center">Chamados em Aberto</h3>
</div>
<div class="overflow-auto listagem-chamados border rounded-2 m-3">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="row">Nª CHAMADO</th>
                <th scope="row">NOME</th>
                <th scope="row">ASSUNTO</th>
                <th scope="row">TOPICO</th>
                <th scope="row">DATA DE CRIAÇÃO</th>
                <th scope="row"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamado as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td >{{$item->name}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->topico}}</td>
                    <td>{{$item->created_at}}</td>
                    {{---------------------BOTÃO PARA CHAMAR O MODAL------------------------}}
                    <td><a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Visualizar Chamado</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{---------------------MODAL COM DADOS DO CHAMADO------------------------}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ...
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
    
