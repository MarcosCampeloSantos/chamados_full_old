@extends('styles.home')

@section('title','Chamados-Acompanhar')

@section('name','Acompanhar')
    
@section('content')
{{---------------------TABELA COM TODOS OS CHAMADOS ABERTOS DE DETERMINADO USUARIO------------------------}}
<div class="overflow-auto listagem-chamados border rounded-2">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="row">Nª CHAMADO</th>
                <th scope="row">NOME</th>
                <th scope="row">ASSUNTO</th>
                <th scope="row">DATA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chamado as $item)
            @if ($id == $item->user_id)
            <tr>
                <th scope="row">{{$item->id}}</th>
                <td >{{$item->name}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->created_at}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
   
@endsection