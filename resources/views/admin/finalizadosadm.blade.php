@extends('styles.home')

@section('title','Chamados Finalizados')

@section('name','Acompanhar')
    
@section('content')
    {{---------------------TABELA COM TODOS OS CHAMADOS ABERTOS DE DETERMINADO USUARIO------------------------}}
    @isset($errofinaladm)
        <div class="alert alert-danger" role="alert">
        <li>{{$errofinaladm}}</li>
        </div>
    @endisset
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                Fechados
                <span class="badge rounded-pill bg-secondary">{{$contfinaladm}}</span>
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                Arquivados
                <span class="badge rounded-pill bg-secondary">{{$contfinaladmarc}}</span>
            </button>
            <nav class="navbar navbar-light">
                <div class="container-fluid">
                  <form class="d-flex" method="POST" action="{{route('finalizadosadm')}}">
                    @csrf
                    <input class="form-control me-2" name="search" type="search" placeholder="Filtro" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Pesquisar</button>
                  </form>
                  @if ($limpafiltro == true)
                    <form class="d-flex" method="POST" action="{{route('finalizadosadm')}}">
                        @csrf
                        <input class="form-control me-2" name="search" type="hidden" value="" aria-label="Search">
                        <button class="btn btn-danger ms-1" type="submit">Limpar</button>
                    </form>
                  @endif
                </div>
            </nav>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="overflow-auto listagem-chamados border rounded-2">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="sticky-top table-dark">
                            <th scope="row">Nª</th>
                            <th scope="row">STATUS</th>
                            <th scope="row">ATENDIMENTO</th>
                            <th scope="row">CRIADO POR</th>
                            <th scope="row">ASSUNTO</th>
                            <th scope="row">TOPICO</th>
                            <th scope="row">DATA CRIAÇÃO</th>
                            <th scope="row"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finaladm as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                @if ($item->status_id == '2')
                                    <td><span class="badge bg-danger">Fechado</span></td>
                                @endif
                                <td>
                                    <select class="form-select chat_select" name="status_chamado" aria-label="Default select example">
                                        @foreach ($tempo as $item2)
                                            @if ($item->id == $item2->chamado_id)
                                                <option>Pausa: {{$item2->tempototal}}</option>
                                                @if($item2->pausado == '2')
                                                    <option selected> Tempo Total: {{$item2->finalizado}}</option>
                                                @endif     
                                            @endif
                                        @endforeach
                                    </select> 
                                </td>
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
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}"><i class="fas fa-edit"></i></button>
                                        </div>
                                        <div class="col">
                                            <form action="{{route('arquivo')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_chamado" value="{{$item->id}}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="overflow-auto listagem-chamados border rounded-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="sticky-top table-dark">
                                <th scope="row">Nª</th>
                                <th scope="row">STATUS</th>
                                <th scope="row">ATENDIMENTO</th>
                                <th scope="row">CRIADO POR</th>
                                <th scope="row">ASSUNTO</th>
                                <th scope="row">TOPICO</th>
                                <th scope="row">DATA CRIAÇÃO</th>
                                <th scope="row"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finaladmarc as $item)
                                <tr>
                                    <th scope="row">{{$item->id}}</th>
                                    @if ($item->status_id == '2')
                                        <td><span class="badge bg-danger">Fechado</span></td>
                                    @endif
                                    <td>
                                        <select class="form-select chat_select" name="status_chamado" aria-label="Default select example">
                                            @foreach ($tempo as $item2)
                                                @if ($item->id == $item2->chamado_id)
                                                    <option>Pausa: {{$item2->tempototal}}</option>
                                                    @if($item2->pausado == '2')
                                                        <option selected> Tempo Total: {{$item2->finalizado}}</option>
                                                    @endif     
                                                @endif
                                            @endforeach
                                        </select> 
                                    </td>
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
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}"><i class="fas fa-edit"></i></button>
                                            </div>
                                            <div class="col">
                                                <form action="{{route('excluirarquivo')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_excluirarquivo" value="{{$item->id}}">
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-folder-minus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    {{---------------------MODAL COM DADOS DO CHAMADO------------------------}}
    @foreach ($chamado->reverse() as $item)
        <div class="modal fade" id="exampleModal{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chamado Nª<b>{{$item->id}}</b> (IP: {{$item->IP}})</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div  class="mb-3 text-center lh-sm">
                            <h5 class="form-label display-6">{{$item->title}}</h5>
                        </div>
                        @isset($erroChat)
                            <div class="alert alert-danger m-3" role="alert">
                                <li>{{$erroChat}}</li>
                            </div>
                        @endisset
                        <div class="scroll chat chat_content rounded-top p-3 overflow-auto border border-1">
                            @foreach ($interacoes->reverse() as $item1)
                                @if ($item1->inicio != '1')
                                    @if ($item1->chamado_id == $item->id)
                                        <div class="mb-3 chat_color text-break shadow p-3 rounded">
                                            @foreach ($usuarios as $item3)
                                                @if ($item1->user_id == $item3->id)
                                                    <p><b>{{$item3->name}}</b></p>
                                                @endif
                                            @endforeach
                                            <p>{!!$item1->chat!!}</p>
                                            <div class="row">
                                                @if ($item1->anexo)
                                                    <div class="col">
                                                        <a href="/anexo/{{$item1->anexo}}" class="fs-6 fw-light text-top mt-4"><i class="fas fa-paperclip"></i>{{$item1->nameanexo}}</a>
                                                    </div>
                                                @endif
                                                <div class="col">
                                                    <p class="fs-6 fw-light text-end">{{$item1->created_at}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if ($item1->chamado_id == $item->id)
                                    @if ($item1->inicio == '1')
                                        <div class="mb-3 chat_color shadow p-3 rounded text-center chat_color_inicio">
                                            <p class="text-break">
                                                @foreach ($usuarios as $item3)
                                                    @if ($item1->user_id == $item3->id)
                                                        {{$item3->name}}
                                                    @endif
                                                @endforeach
                                                {{$item1->chat}}
                                            </p>
                                        </div>
                                    @endif
                                @endif 
                            @endforeach  
                        </div>
                        <div>
                            <form action="{{route('envchat')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @php
                                    $cont = array();
                                    array_push($cont, $item->id);
                                @endphp
                                <textarea type="text" id="txtArtigo" class="chat{{$item->id}} form-label w-100 mt-2 text-break p-2" rows="3" name="chat" id="cria_email" placeholder="Digite o Aqui..."></textarea>
                                <input class="form-control mt-2 w-50" name="anexo" type="file" id="formFile">
                                <div class="row mt-3">
                                    <input type="hidden" name="id_Chat" id="id_Chat" value="#exampleModal{{$item->id}}">
                                    <input type="hidden" name="url_ver" id="url_ver" value="{{Request::segment(1)}}">
                                    <div class="col-3">
                                        <select class="form-select chat_select" name="status_chamado" aria-label="Default select example">
                                            <option value="1">Abrir</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-primary" type="submit">Enviar</button>
                                    </div>
                                    <input type="hidden" name="id_chamado" value="{{$item->id}}">
                                </div>
                            </form>
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
    
    <script>
        var teste = <?php if(isset($cont)){echo json_encode($cont);} ?>;
        function teste1(item){
            ClassicEditor
            .create( document.querySelector( '.chat'+item ), {
                toolbar: {
                items: [
                    'heading',
                    'fontFamily',
                    'fontSize',
                    '|',
                    'bold',
                    'italic',
                    'bulletedList',
                    'numberedList',
                    'fontBackgroundColor',
                    'fontColor',
                    'removeFormat',
                    '|',
                    'outdent',
                    'indent',
                    'alignment',
                    '|',
                    'undo',
                    'redo'
                ]
            },
            language: 'pt-br',
                licenseKey: '',			
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: oevj7xtxj0l9-uxkzi3ishqrq' );
                console.error( error );
            } );
        }
        teste.forEach(teste1);
    </script>
@endsection