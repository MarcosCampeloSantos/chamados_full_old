@extends('styles.home')

@section('title','Chamados-Acompanhar')

@section('name','Acompanhar')
    
@section('content')
<div class="overflow-auto listagem-chamados border rounded-2">
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