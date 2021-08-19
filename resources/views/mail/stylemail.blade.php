@extends('styles.home')

@section('title','Envio-Email')
    
@section('content')
    <div class="row justify-content-center mb-5 index">
        <div>
            <h1 class="display-4">Chamado #{!!$chamado!!}</h1>
        </div>
        <div>
            <h2>Mensagem: </h2>
            <p>{!!$mensagem!!}</p>
        </div>
    </div>
@endsection