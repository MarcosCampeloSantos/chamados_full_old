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
                <a href="{{route('usuarios')}}" class="btn btn-primary">Criar Usuarios</a>
            </div>
            </div>
        </div>
        <a href="{{route('criarChamado')}}" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo chamado</a>
        <a href="{{route('acompanhar')}}" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Acompanhar Chamados</a>
        <a href="#" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
    </div>
@endsection
    
