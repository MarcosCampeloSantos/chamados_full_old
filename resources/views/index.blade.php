@extends('styles.home')

@section('title','Chamados Home')

@section('name','Chamados')

@section('content')
{{---------------------HOME DE ACESSO USUARIO------------------------}}
<div class="row justify-content-center mb-5 index">
    <div class="overflow-hidden card perfil text-center">
        <i class="fas fa-address-card mt-3 fa-4x"></i>
        <div class="card-body lh-1">
            <a href=""><h6 class="display-6">Perfil</h6></a>
            <div class="text-start">
                <p class="card-title text-center">Bem vindo,<b> {{$name}}</b></p>
            </div>
            <a href="{{route('sair')}}" class="btn btn-primary btn-sm mt-3"><i class="fas fa-door-open"></i> Sair</a>
        </div>
    </div>
    <a href="{{route('chamado')}}" class="style-card hvr-bob cor-cartao1 cartao rounded-2 text-center">Criar um novo Chamado</a>
    <a href="{{route('acompanhar')}}" class="style-card hvr-bob cor-cartao2 cartao rounded-2 text-center">Acompanhar Chamados</a>
    <a href="{{route('finalizados')}}" class="style-card hvr-bob cor-cartao3 cartao rounded-2 text-center">Chamados Finalizados</a>
</div>
@endsection
    
