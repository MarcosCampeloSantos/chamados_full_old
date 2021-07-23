@extends('styles.home')

@section('title','Dashboard')

@section('name','Painel de Administração')

@section('content')
<div class="row ">
  <div class="w-25 mx-auto col">
    <h5 class="text-center">Departamentos</h6>
    <div class="overflow-auto border rounded-3 listagem-dp">
      <table class="table table-striped table-hover">
        <thead>
            <tr class="text-center table-dark sticky-top">
                <th scope="row">ID</th>
                <th scope="row">DEPARTAMENTOS</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($departamento as $item)
            <tr class="text-center">
              <th scope="row" class="border">{{$item->id}}</th>
              <td >{{$item->departamento}}</td>
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
            </tr>
        </thead>
        <tbody>
          @foreach ($topicos as $item)
            <tr class="text-center">
              <th scope="row" class="border">{{$item->id}}</th>
              <td >{{$item->topicos}}</td>
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
                <th scope="row"></th>
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
                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#rel">
                  Editar
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
                  <option value="{{$item->id}}">{{$item->departamento}}</option>
                @endforeach
              </select>
              <label class="form-label mt-3">Relacionado a</label>
              <select class="form-select" name="rel_top" size="1" aria-label="size 3 select example">
                @foreach ($topicos as $item)
                  <option value="{{$item->id}}">{{$item->topicos}}</option>
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
@endsection