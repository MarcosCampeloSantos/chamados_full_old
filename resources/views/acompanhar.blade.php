@extends('styles.home')

@section('title','Chamados-Acompanhar')

@section('name','Acompanhar')
    
@section('content')
{{---------------------TABELA COM TODOS OS CHAMADOS ABERTOS DE DETERMINADO USUARIO------------------------}}
<div class="overflow-auto listagem-chamados border rounded-2">
    <table class="table table-striped table-hover">
        <thead>
            <tr class="sticky-top table-dark">
                <th scope="row">Nª CHAMADO</th>
                <th scope="row">NOME</th>
                <th scope="row">ASSUNTO</th>
                <th scope="row">DATA</th>
                <th scope="row"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamado as $item)
            @if ($id == $item->user_id)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td >{{$item->name}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at}}</td>
                 {{---------------------BOTÃO PARA CHAMAR O MODAL------------------------}}
                <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">Visualizar Chamado</button></td>
            </tr>
            @endif
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