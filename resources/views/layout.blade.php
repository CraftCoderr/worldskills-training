<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="/dist/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/css/style.css">

    @stack('styles')

    @stack('templates')
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand navbar-light">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="/assets/logo.svg.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            Главная
        </a>
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item">
                    <a href="manager.html" class="nav-link btn">Управление</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       id="btn-notifications">Уведомления
                        <span class="badge badge-primary">3</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="btn-notifications">
                        <a class="dropdown-item" href="#">Уведомление 1</a>
                        <a class="dropdown-item" href="#">Уведомление 2</a>
                        <a class="dropdown-item" href="#">Уведомление 3</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link btn">Выйти</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link btn">Регистрация</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link btn">Вход</a>
                </li>
            @endauth
        </ul>
    </nav>
</div>
<main>
    @yield('content')
</main>

@stack('modals')

<script src="/dist/jquery-3.5.1.js"></script>
<script src="/dist/bootstrap/js/bootstrap.js"></script>
@stack('scripts')
@stack('components')
</body>
</html>
