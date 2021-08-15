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
            <div class="row">
                <a href="{{route('homeOp')}}" class="btn btn-primary btn-sm mt-3 m-1 col"><i class="fas fa-tachometer-alt"></i> Modo Operador</a>
                <a href="{{route('sair')}}" class="btn btn-primary btn-sm mt-3 m-1 col"><i class="fas fa-door-open"></i> Sair</a>
            </div>
           
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
            <button class="nav-link active position-relative" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                Todos os Chamados
                <span class="badge rounded-pill bg-secondary">{{$contagemalladm}}</span>
            </button>
            <button class="nav-link position-relative" id="nav-dep-tab" data-bs-toggle="tab" data-bs-target="#nav-dep" type="button" role="tab" aria-controls="nav-dep" aria-selected="false">
                Chamados Departamento
                <span class="badge rounded-pill bg-secondary">{{$contagemadpadm}}</span>
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                Chamados Atribuidos
                <span class="badge rounded-pill bg-secondary">{{$contagematributoadm}}</span>
            </button>
            <button onclick="refresh()" class="btn m-2 ms-3"><i class="fas fa-sync-alt"></i></button>
        </div>
    </nav>
</div>
<div class="overflow-auto listagem-chamados border rounded-2">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <table class="table table-striped table-hover">
                <thead class="sticky-top table-dark">
                    <tr>
                        <th scope="row">Nª</th>
                        <th scope="row">STATUS</th>
                        <th scope="row">ATENDIMENTO</th>
                        <th scope="row">CRIADO POR</th>
                        <th scope="row">ASSUNTO</th>
                        <th scope="row">TOPICO</th>
                        <th scope="row">DATA DE CRIAÇÃO</th>
                        <th scope="row"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chamadosalladm as $item)
                        <tr>
                            <th scope="row">{{$item->id}}</th>
                            @if ($item->status_id == '1')
                                <td><span class="badge bg-success">Aberto</span></td>
                            @elseif($item->status_id == '2')
                                <td><span class="badge bg-danger">Fechado</span></td>
                            @elseif($item->status_id == '3' || $item->status_id == '5')
                                <td><span class="badge bg-warning text-dark">Em Atendimento</span></td>
                            @elseif($item->status_id == '4')
                                <td><span class="badge bg-info text-dark">Pausado</span></td>
                            @endif
                            <td>
                                <select class="form-select" name="status_chamado" aria-label="Default select example">
                                    @foreach ($tempo as $item2)
                                        @if ($item->id == $item2->chamado_id)
                                            @if ($item2->tempototal == NULL)
                                                <option selected>Calculando...</option>
                                            @endif
                                            @if ($item2->tempototal != NULL)
                                                <option selected>{{$item2->tempototal}}</option>
                                            @endif
                                            @if($item2->pausado == '2')
                                                <option selected> Tempo: {{$item2->finalizado}}</option>
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
                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">Visualizar Chamado</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="nav-dep" role="tabpanel" aria-labelledby="nav-profile-tab">
            <table class="table table-striped table-hover">
                <thead class="sticky-top table-dark">
                    <tr>
                        <th scope="row">Nª</th>
                        <th scope="row">STATUS</th>
                        <th scope="row">ATENDIMENTO</th>
                        <th scope="row">CRIADO POR</th>
                        <th scope="row">ASSUNTO</th>
                        <th scope="row">TOPICO</th>
                        <th scope="row">DATA DE CRIAÇÃO</th>
                        <th scope="row"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chamadosdpadm as $item)
                        <tr>
                            <th scope="row">{{$item->id}}</th>
                            @if ($item->status_id == '1')
                                <td><span class="badge bg-success">Aberto</span></td>
                            @elseif($item->status_id == '2')
                                <td><span class="badge bg-danger">Fechado</span></td>
                            @elseif($item->status_id == '3' || $item->status_id == '5')
                                <td><span class="badge bg-warning text-dark">Em Atendimento</span></td>
                            @elseif($item->status_id == '4')
                                <td><span class="badge bg-info text-dark">Pausado</span></td>
                            @endif
                            <td>
                                <select class="form-select" name="status_chamado" aria-label="Default select example">
                                    @foreach ($tempo as $item2)
                                            @if ($item->id == $item2->chamado_id)
                                                @if ($item2->tempototal == NULL)
                                                    <option selected>Calculando...</option>
                                                @endif
                                                @if ($item2->tempototal != NULL)
                                                    <option selected>{{$item2->tempototal}}</option>
                                                @endif
                                                @if($item2->pausado == '2')
                                                    <option selected> Tempo: {{$item2->finalizado}}</option>
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
                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">Visualizar Chamado</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"> 
            <table class="table table-striped table-hover">
                <thead class="sticky-top table-dark">
                    <tr>
                        <th scope="row">Nª</th>
                        <th scope="row">STATUS</th>
                        <th scope="row">ATENDIMENTO</th>
                        <th scope="row">CRIADO POR</th>
                        <th scope="row">ASSUNTO</th>
                        <th scope="row">TOPICO</th>
                        <th scope="row">DATA DE CRIAÇÃO</th>
                        <th scope="row"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chamadosatributoadm as $item)
                        <tr>
                            <th scope="row">{{$item->id}}</th>
                            @if ($item->status_id == '1')
                                <td><span class="badge bg-success">Aberto</span></td>
                            @elseif($item->status_id == '2')
                                <td><span class="badge bg-danger">Fechado</span></td>
                            @elseif($item->status_id == '3' || $item->status_id == '5')
                                <td><span class="badge bg-warning text-dark">Em Atendimento</span></td>
                            @elseif($item->status_id == '4')
                                <td><span class="badge bg-info text-dark">Pausado</span></td>
                            @endif
                            <td>
                                <select class="form-select" name="status_chamado" aria-label="Default select example">
                                    @foreach ($tempo as $item2)
                                            @if ($item->id == $item2->chamado_id)
                                                @if ($item2->tempototal == NULL)
                                                    <option selected>Calculando...</option>
                                                @endif
                                                @if ($item2->tempototal != NULL)
                                                    <option selected>{{$item2->tempototal}}</option>
                                                @endif
                                                @if($item2->pausado == '2')
                                                    <option selected> Tempo: {{$item2->finalizado}}</option>
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
                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}">Visualizar Chamado</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <div>
                            <div class="mb-3 text-center lh-sm">
                                <h4 class="form-label display-6">{{$item->title}}</h4>
                            </div>
                            @isset($erroChat)
                                <div class="alert alert-danger m-3" role="alert">
                                    <li>{{$erroChat}}</li>
                                </div>
                            @endisset
                            <div class="scroll chat chat_content rounded-top p-3 border border-1">
                                @foreach ($interacoes->reverse() as $item1)
                                    @if ($item1->inicio != '1')
                                        @if ($item1->chamado_id == $item->id)
                                            <div class="mb-3 text-break chat_color shadow p-3 rounded">
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
                                            <div class="mb-3 chat_color shadow p-3 text-center chat_color_inicio">
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
                                    @if ($item->status_id == '2' || $item->status_id == '3' || $item->status_id == '5')
                                        @php
                                            $cont = array();
                                            array_push($cont, $item->id);
                                        @endphp
                                        <textarea id="txtArtigo" type="text" class="chat{{$item->id}} form-label w-100 mt-2 text-break p-2" rows="3" name="chat" placeholder="Digite o Aqui..."></textarea>
                                    @endif
                                    @if ($item->status_id == '5' || $item->status_id == '3')
                                        <input class="form-control w-50 mt-2" name="anexo" type="file" id="formFile">
                                    @endif
                                    <div class="row mt-3">
                                        
                                        {{--Pontes de Dados--}}
                                        <input type="hidden" name="id_chamado" value="{{$item->id}}">
                                        <input type="hidden" name="id_Chat" id="id_Chat" value="#exampleModal{{$item->id}}">
                                        <input type="hidden" name="url_ver" id="url_ver" value="{{Request::segment(1)}}">

                                        <div class="col-3">
                                                <select class="form-select" name="status_chamado" aria-label="Default select example">
                                                    @if ($item->status_id == '3' || $item->status_id == '5')
                                                        <option value="2">Fechar</option>
                                                    @endif
                                                    @if ($item->status_id != '3' && $item->status_id != '5')
                                                        <option value="3">Iniciar Atendimento</option>
                                                    @endif
                                                    @if ($item->status_id != '4' && $item->status_id != '1')
                                                        <option value="4">Pausar</option>
                                                    @endif
                                                    @if ($item->status_id == '3' || $item->status_id == '5')
                                                        <option value="5" selected>Mensagem</option>
                                                    @endif
                                                </select>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-primary" type="submit">
                                                @if ($item->status_id == '1' || $item->status_id == '4')
                                                    Inicar
                                                @endif
                                                @if ($item->status_id == '5' || $item->status_id == '3')
                                                    Enviar
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
    
