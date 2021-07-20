<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{url(mix('css/app.css'))}}">
    <link rel="stylesheet" href="{{url(mix('css/app2.css'))}}">
    <script src="{{url(mix('js/app.js'))}}"></script>
    <title>@yield('title')</title>
</head>
<body>
    @if (Request::segment(1) != '')
        <div class="camada mx-auto">
            <div class="home mx-auto cor mt-5 shadow p-3 mb-5 bg-body rounded">
                <div class="mb-4">
                    @if(Request::segment(1) != '' && Request::segment(1) != 'homeUser' && Request::segment(1) != 'homeAdm')
                        <a class="voltar" href="{{url()->previous()}}"><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                    @endif
                    
                    <h1 class="display-6 text-center">@yield('name')</h1>
                </div>
                @yield('content')
            </div>
            @endif
            @yield('login')
            <footer class="footer navbar-fixed-bottom text-center">
                <p>&copy;Chamados 2021</p>
            </footer>
        </div>
    
    
    
</body>
</html>