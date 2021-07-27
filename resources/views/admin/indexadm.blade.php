@extends('styles.home')

@section('title','Chamados Home')

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
    <a href="{{route('chamado')}}" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo Chamado</a>
    <a href="{{route('usuarios')}}" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Criar e Editar Usuarios</a>
    <a href="{{route('finalizadosadm')}}" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
</div>

{{---------------------LISTAGEM DE TODOS OS CHAMADOS EM ABERTO------------------------}}
<div>
    <h3 class="display-6 text-center">Chamados em Aberto</h3>
</div>
<div>
    <nav>
        <div class="nav nav-tabs sticky-top" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Todos os Chamados</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Chamados Atribuidos</button>
        </div>
    </nav>
</div>
<div class="overflow-auto listagem-chamados border rounded-2 m-3">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <table class="table table-striped table-hover">
                <thead class="sticky-top table-dark">
                    <tr>
                        <th scope="row">Nª CHAMADO</th>
                        <th scope="row">STATUS</th>
                        <th scope="row">TIMER</th>
                        <th scope="row">NOME</th>
                        <th scope="row">ASSUNTO</th>
                        <th scope="row">TOPICO</th>
                        <th scope="row">DATA DE CRIAÇÃO</th>
                        <th scope="row"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chamado as $item)
                        @if ($item->status_id != '2')
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                @if ($item->status_id == '1')
                                    <td><span class="badge bg-success">Aberto</span></td>
                                @elseif($item->status_id == '2')
                                    <td><span class="badge bg-danger">Fechado</span></td>
                                @elseif($item->status_id == '3')
                                    <td><span class="badge bg-warning text-dark">Em Atendimento</span></td>
                                @else
                                    <td><span class="badge bg-info text-dark">Pausado</span></td>
                                @endif
                                <td id="counter">00:00:00 <button onclick="start()">Teste</button></td>
                                <td >{{$item->name}}</td>
                                <td>
                                    {{$item->title}}
                                    @foreach ($interacoes as $item1)
                                        @if ($item->id == $item1->chamado_id && $item1->anexo)
                                            <i class="fas fa-paperclip"></i>
                                        @endif
                                    @endforeach
                                </td>
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
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <table class="table table-striped table-hover">
                    <thead class="sticky-top table-dark">
                        <tr>
                            <th scope="row">Nª CHAMADO</th>
                            <th scope="row">STATUS</th>
                            <th scope="row">TIMER</th>
                            <th scope="row">NOME</th>
                            <th scope="row">ASSUNTO</th>
                            <th scope="row">TOPICO</th>
                            <th scope="row">DATA DE CRIAÇÃO</th>
                            <th scope="row"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chamado as $item)
                            @foreach ($relacionamentos as $item6)
                                @if ($item6->topicos_id == $item->topico && $item->status_id != '2')
                                    @if ($item6->departamentos_id == $departamento)
                                        <tr>
                                            <th scope="row">{{$item->id}}</th>
                                            @if ($item->status_id == '1')
                                                <td><span class="badge bg-success">Aberto</span></td>
                                            @elseif($item->status_id == '2')
                                                <td><span class="badge bg-danger">Fechado</span></td>
                                            @elseif($item->status_id == '3')
                                                <td><span class="badge bg-warning text-dark">Em Atendimento</span></td>
                                            @else
                                                <td><span class="badge bg-info text-dark">Pausado</span></td>
                                            @endif
                                            <td >@yield('cronometro')</td>
                                            <td >{{$item->name}}</td>
                                            <td>
                                                {{$item->title}}
                                                @foreach ($interacoes as $item1)
                                                    @if ($item->id == $item1->chamado_id && $item1->anexo)
                                                        <i class="fas fa-paperclip"></i>
                                                    @endif
                                                @endforeach
                                            </td>
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
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
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
                                <h4 class="form-label display-6">{{$item->title}}</h4>
                            </div>
                            @isset($erroChat)
                                <div class="alert alert-danger m-3" role="alert">
                                    <li>{{$erroChat}}</li>
                                </div>
                            @endisset
                            <div class="chat chat_content p-3 overflow-auto">
                                @foreach ($interacoes as $item1)
                                    @if ($item1->chamado_id == $item->id)
                                        <div class="mb-3 chat_color shadow p-3 rounded">
                                            @foreach ($usuarios as $item3)
                                                @if ($item1->user_id == $item3->id)
                                                    <p><b>{{$item3->name}}</b></p>
                                                @endif
                                            @endforeach
                                            <p class="text-break">{{$item1->chat}}</p>
                                            <div class="row">
                                                @if ($item1->anexo)
                                                    <div class="col">
                                                        <p class="fs-6 fw-light text-top mt-4"><i class="fas fa-paperclip"></i> {{$item1->anexo}}</p>
                                                    </div>
                                                @endif
                                                <div class="col">
                                                    <p class="fs-6 fw-light text-end mt-4">{{$item->created_at}}</p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    @endif
                                @endforeach  
                            </div>
                            <div>
                                <form action="{{route('envchat')}}" method="POST">
                                    @csrf
                                    <textarea type="text" class="form-label chat_label mt-2 text-break p-2" rows="3" name="chat" placeholder="Digite o Aqui..."></textarea>
                                    <div class="row">
                                        <input type="hidden" name="id_chamado" value="{{$item->id}}">
                                        <input type="hidden" name="id_Chat" id="id_Chat" value="#exampleModal{{$item->id}}">
                                        <input type="hidden" name="url_ver" id="url_ver" value="{{Request::segment(1)}}">
                                        <div class="col">
                                            <select class="form-select chat_select" name="status_chamado" aria-label="Default select example">
                                                {{--<option value="1">Aberto</option>--}}
                                                <option value="2">Fechado</option>
                                                <option value="3">Em Atendimento</option>
                                                <option value="4">Pausado</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary" type="submit">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @isset($erroChat)
            @isset($chatid)
                <input type="hidden" value="{{$chatid}}" id="finalmente">
                <script>
                    var input = document.getElementById('finalmente');
                    var texto = input.value;
                    $(document).ready(function() {
                        $(texto).modal('show');
                    })
                </script>
            @endisset
        @endisset
    @endforeach
</div>
@endsection
    
