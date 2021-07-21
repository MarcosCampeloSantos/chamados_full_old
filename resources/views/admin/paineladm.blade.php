@extends('styles.home')

@section('title','Dashboard')

@section('name','Painel de Administração')

@section('content')
<div class="row">
    <div class="w-25 mx-auto rounded-3">
        <table class="table border listagem-dp overflow-auto table-striped table-hover">
            <h5 class="text-center">Departamentos e Topicos</h6>
            <thead>
                <tr>
                    <th scope="row">ID</th>
                    <th scope="row">DEPARTAMENTOS</th>
                    <th scope="row">TOPICOS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <td ></td>
                    <td ></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deptop">
            Inserir
        </button>
    </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deptop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
      </div>
    </div>
  </div>
@endsection