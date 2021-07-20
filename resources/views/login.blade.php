@extends('styles.home')

@section('title','Chamados-Login')

@section('name','Login')

@section('login')
<div class="login cor mt-5 container-fluid shadow p-3 mb-5 bg-body rounded">
    <div class="mb-3 mx-auto">
        <h1 class="display-6 text-center">Login</h1>
        {{--Erros de Validação--}}
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          @foreach ($errors->all() as $item)
            <li>{{$item}}</li>
          @endforeach
        </div>
        {{--Erros de Login--}}
        @endif
        @if (isset($erro))
        <div class="alert alert-danger" role="alert">
          <li>{{$erro}}</li>
        </div>
        @endif
        <form action="{{route('login')}}" method="POST">
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