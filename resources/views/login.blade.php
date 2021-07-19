@extends('styles.home')

@section('title','Chamados-Login')

@section('name','Login')

@section('login')
<div class="login cor mt-5 container-fluid shadow p-3 mb-5 bg-body rounded">
    <div class="mb-3 w-50 mx-auto">
        <h1 class="display-6 text-center">Login</h1>
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul>
            @foreach ($errors->all() as $item)
              <li>{{$item}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        @if (isset($erro))
        <div class="alert alert-danger" role="alert">
          <p>{{$erro}}</p>
        </div>
        @endif
        <form action="{{route('logar.usuario')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">E-mail</label>
              <input type="email" class="form-control" name="loginemail" id="loginemail" placeholder="Digite seu Email">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Senha</label>
              <input type="password" class="form-control" name="loginpassword" id="loginpassword" placeholder="Digite Sua Senha">
            </div>
            <div claas="mb-3">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
          </form>
    </div>
</div>
@endsection