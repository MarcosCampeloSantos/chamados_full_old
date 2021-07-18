@extends('styles.home')

@section('title','Chamados-Home')

@section('name','Chamados')

@section('content')
    <div class="row justify-content-center">
        <div class="overflow-hidden card perfil text-center">
            <i class="fas fa-address-card fa-9x"></i>
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <a href="/criar" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo chamado</a>
        <a href="/acompanhar" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Acompanhar Chamados</a>
        <a href="#" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
    </div>
@endsection
    
