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
        <thead class="sticky-top table-dark">
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
                    <td>
                        @foreach ($topicos as $item1)
                            @if ($item->topico == $item1->id)
                                {{$item1->topicos}}
                            @endif
                        @endforeach
                    </td>
                    <td>{{$item->created_at}}</td>
                    {{---------------------BOTÃO PARA CHAMAR O MODAL------------------------}}
                    <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">Visualizar Chamado</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{---------------------MODAL COM DADOS DO CHAMADO------------------------}}
    @foreach ($chamado as $item)
    <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chamado Nª<b>{{$item->id}}</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div  class="mb-3 text-center lh-sm">
                            <h5 class="form-label display-6">{{$item->title}}</h5>
                        </div>
                        <div class="chat chat_content p-3 overflow-auto">
                            @foreach ($interacoes as $item1)
                            @if ($item1->chamado_id == $item->id)
                            <div class="mb-3 shadow p-3 bg-body rounded">
                                @foreach ($usuarios as $item3)
                                    @if ($item1->user_id == $item3->id)
                                        <p><b>{{$item3->name}}</b></p>
                                    @endif
                                @endforeach
                                <p class="text-break">{{$item1->chat}}</p>
                                <p class="fs-6 fw-light text-end mt-4">{{$item->created_at}}</p>
                            </div>
                            @endif
                            @endforeach  
                        </div>
                        <div>
                            <form action="{{route('envchat')}}" method="POST">
                                @csrf
                                <textarea type="text" class="form-label chat_label mt-2 text-break p-2" rows="3" name="chat" id="cria_email" placeholder="Digite o Aqui..."></textarea>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">Enviar</button>
                                    </div>
                                    <input type="hidden" name="id_chamado" value="{{$item->id}}">
                                    <div class="col">
                                        {{--<select class="form-select chat_select" name="dep_user" aria-label="Default select example">
                                            <option selected>Selecione Status de Atendimento</option>
                                            <option value="1"></option>
                                        </select>--}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
    
