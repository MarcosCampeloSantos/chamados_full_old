@extends('styles.home')

@section('title','Chamados-Home')

@section('name','Chamados')

@section('content')
    <div class="row justify-content-center mb-5 index">
        <div class="overflow-hidden card perfil text-center">
            <i class="fas fa-address-card fa-9x"></i>
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
            <div class="mb-3">
                <a href="#" class="btn btn-primary">Nada Por enquanto</a>
            </div>
            </div>
        </div>
        <a href="{{route('criarChamado')}}" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo chamado</a>
        <a href="{{route('usuarios')}}" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Criar e Editar Usuarios</a>
        <a href="#" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
    </div>
    <div>
        <h3 class="display-6 text-center">Chamados em Aberto</h3>
    </div>
    <div class="overflow-auto listagem-chamados border rounded-2 m-3">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="row">CODIGO</th>
                    <th scope="row">NOME</th>
                    <th scope="row">ASSUNTO</th>
                    <th scope="row">DATA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td >Larry the Bird</td>
                    <td>Conteudo Teste</td>
                    <td>18/07/2021</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
    
