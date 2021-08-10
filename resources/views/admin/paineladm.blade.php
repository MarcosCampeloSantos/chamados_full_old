@extends('styles.home')

@section('title','Chamados Dashboard')

@section('name','Painel de Administração')

@section('content')
  @isset($errorelacionameto)
    <div class="alert alert-danger" role="alert">
      <li>{{$errorelacionameto}}</li>
    </div>
  @endisset
  <div class="row ">
    <div class="w-25 mx-auto col">
      <h5 class="text-center">Departamentos</h6>
      <div class="overflow-auto border rounded-3 listagem-dp">
        <table class="table table-striped table-hover">
          <thead>
              <tr class="text-center table-dark sticky-top">
                  <th scope="row">ID</th>
                  <th scope="row">DEPARTAMENTOS</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
            @foreach ($departamento as $item)
              <tr class="text-center">
                <th scope="row" class="border">{{$item->id}}</th>
                <td >{{$item->departamento}}</td>
                <td>
                  <button data-bs-target="#excluirdep{{$item->id}}" class="btn btn-danger" data-bs-toggle="modal">
                    <i class="fas fa-minus"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
      <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#dep">
        Inserir
      </button>
    </div>

    <div class="w-25 mx-auto col">
      <h5 class="text-center">Topicos de Atendimento</h6>
      <div class="overflow-auto border rounded-3 listagem-dp">
        <table class="table table-striped table-hover">
          <thead>
              <tr class="text-center table-dark sticky-top">
                  <th scope="row">ID</th>
                  <th scope="row">TOPICO</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
            @foreach ($topicos as $item)
              <tr class="text-center">
                <th scope="row" class="border">{{$item->id}}</th>
                <td >{{$item->topicos}}</td>
                <td>
                  <button data-bs-target="#excluirtop{{$item->id}}" class="btn btn-danger" data-bs-toggle="modal">
                    <i class="fas fa-minus"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
      <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#top">
        Inserir
      </button>
    </div>
  </div>
  <div class="row mt-3">
    <div class="w-25 mx-auto col">
      <h5 class="text-center">Relacionamentos</h6>
      <div class="overflow-auto border rounded-3 listagem-dp">
        <table class="table table-striped table-hover">
          <thead>
              <tr class="text-center table-dark sticky-top">
                  <th scope="row">ID</th>
                  <th scope="row">DEPARTAMENTO</th>
                  <th scope="row">TOPICOS</th>
                  <th scope="row">ATRIBUIDO</th>
                  <th scope="row">EDIÇÃO</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($relacionamentos as $item)
              <tr class="text-center">
                <th scope="row" class="border">{{$item->id}}</th>
                <td>
                  @foreach ($departamento as $item2)
                  @if($item->departamentos_id == $item2->id)
                    {{$item2->departamento}}
                  @endif
                  @endforeach
                </td>
                <td>
                  @foreach ($topicos as $item3)
                  @if($item->topicos_id == $item3->id)
                    {{$item3->topicos}}
                  @endif
                  @endforeach
                </td>
                <td>
                  <div class="row">
                    <div class="col">
                      <select class="form-select" size="1">
                        @foreach ($atribuicao as $item1)
                          @foreach ($users as $item2)
                            @if ($item1->id_user == $item2->id && $item1->id_relacionamento == $item->id)
                                <option value="{{$item2->id}}" selected>{{$item2->name}}</option>
                            @endif
                          @endforeach
                        @endforeach
                      </select>
                    </div> 
                    <div class="col-1">
                      <button data-bs-target="#excluirreluser{{$item->id}}" class="btn btn-danger" data-bs-toggle="modal">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>                
                    <div class="col-1">
                      <button data-bs-target="#aditreluser{{$item->id}}" class="btn btn-primary" data-bs-toggle="modal">
                        <i class="fas fa-plus-circle"></i>
                      </button>
                    </div> 
                  </div>
                </td>
                <td>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editrel{{$item->id}}">
                    Editar
                  </button>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#excluirel{{$item->id}}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
      </table>
      </div>
      <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#rel">
        Inserir
      </button>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="dep" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Criar Deparmento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('criardep')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <input type="text" class="form-control" rows="3" name="cria_dep" id="cria_email" placeholder="Digite o Topico">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="top" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Criar Topico</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('criartop')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Topico</label>
                <input type="text" class="form-control" rows="3" name="cria_top" id="cria_email" placeholder="Digite o Topico">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="rel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Criar Relacionamentos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('criar_rel')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <select class="form-select" name="rel_dep" size="1" aria-label="size 3 select example">
                  @foreach ($departamento as $item)
                    <option value="{{$item->id}}">{{$item->id}} - {{$item->departamento}}</option>
                  @endforeach
                </select>
                <label class="form-label mt-3">Relacionado a</label>
                <select class="form-select" name="rel_top" size="1" aria-label="size 3 select example">
                  @foreach ($topicos as $item)
                    <option value="{{$item->id}}">{{$item->id}} - {{$item->topicos}}</option>
                  @endforeach
                </select>
                <label class="form-label mt-3">Relacionado a</label>
                <select class="form-select" name="rel_user" size="1" aria-label="size 3 select example">
                  @foreach ($users as $item3)
                    @if ($item3->nivel == '1' || $item3->nivel == '4')
                      <option value="{{$item3->id}}">{{$item3->name}}</option>
                    @endif
                  @endforeach
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  @foreach ($relacionamentos as $item)
    <div class="modal fade" id="editrel{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Editar Relacionamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('editar_rel')}}" method="POST">
              @csrf
              <div class="mb-3">
                  <label class="form-label">Departamento</label>
                  <select class="form-select" name="rel_dep" size="1" aria-label="size 3 select example">
                    @foreach ($departamento as $item2)
                      <option value="{{$item2->id}}">{{$item2->departamento}}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="id_relacionamento" value="{{$item->id}}">
                  <label class="form-label mt-3">Relacionado a</label>
                  <select class="form-select" name="rel_top" size="1" aria-label="size 3 select example">
                    @foreach ($topicos as $item3)
                      <option value="{{$item3->id}}">{{$item3->topicos}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Editar</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($relacionamentos as $item)
    <div class="modal fade" id="aditreluser{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Adicionar Atribuição</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('adicionar_atributo')}}" method="POST">
              @csrf
              <div class="mb-3">
                  <input type="hidden" name="id_relacionamento" value="{{$item->id}}">
                  <label class="form-label">Atribuir a</label>
                  <select class="form-select" name="rel_user_edit" size="1" aria-label="size 3 select example">
                    @foreach ($users as $item3)
                      @if ($item3->nivel == '1' || $item3->nivel == '4')
                        <option value="{{$item3->id}}">{{$item3->name}}</option>
                      @endif
                    @endforeach
                  </select>
              </div>
              <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Adicionar</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($relacionamentos as $item)
    <div class="modal fade" id="excluirreluser{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Excluir Atribuição</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('delete_atributo')}}" method="POST">
              @csrf
              <div class="mb-3">
                  <input type="hidden" name="id_relacionamento" value="{{$item->id}}">
                  <select class="form-select" name="rel_user_edit" size="1" aria-label="size 3 select example">
                    @foreach ($atribuicao as $item1)
                      @foreach ($users as $item2)
                          @if ($item1->id_user == $item2->id && $item1->id_relacionamento == $item->id)
                              <option value="{{$item2->id}}" selected>{{$item2->name}}</option>
                          @endif
                        @endforeach
                      @endforeach
                  </select>
              </div>
              <div class="mb-3">
                  <button type="submit" class="btn btn-danger">Excluir</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($departamento as $item)
    <div class="modal fade" id="excluirdep{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Excluir Atribuição</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('excluirdep')}}" method="POST">
              @csrf
              <div class="mb-3 text-center">
                  <input type="hidden" name="id_departamento" value="{{$item->id}}">
                  <label class="form-label">Realmente quer Excluir o Departamento <b>{{$item->departamento}}</b></label>
              </div>
              <div class="mb-3 text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger ms-3">Excluir</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($topicos as $item)
    <div class="modal fade" id="excluirtop{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Excluir Atribuição</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('excluirtop')}}" method="POST">
              @csrf
              <div class="mb-3 text-center">
                  <input type="hidden" name="id_topico" value="{{$item->id}}">
                  <label class="form-label">Realmente quer Excluir o Topico <b>{{$item->topicos}}</b></label>
              </div>
              <div class="mb-3 text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger ms-3">Excluir</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  @foreach ($relacionamentos as $item)
    <div class="modal fade" id="excluirel{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Excluir Atribuição</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('excluirel')}}" method="POST">
              @csrf
              <div class="mb-3 text-center">
                  <input type="hidden" name="id_rel" value="{{$item->id}}">
                  <label class="form-label">Realmente quer Excluir o Relacionamento <b>{{$item->id}}</b></label>
              </div>
              <div class="mb-3 text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger ms-3">Excluir</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection