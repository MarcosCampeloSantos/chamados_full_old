@extends('styles.home')

@section('title','Dashboard')

@section('name','Painel de Administração')

@section('content')
<div class="w-25 mx-auto">
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
  <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#deptop">
    Inserir
  </button>
</div>
<!-- Modal -->
<div class="modal fade" id="deptop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <input type="text" class="form-control" rows="3" name="cria_dep" id="cria_email" placeholder="Digite o Departamento">
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