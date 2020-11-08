@extends('layout')

@section('title')
    Авторизация
@endsection

@section('content')
    <div class="content container mt-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <h5 class="card-header">Авторизация</h5>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @if ($errors)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="form_email">Email</label>
                            <input type="email" class="form-control" id="form_email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="form_password">Пароль</label>
                            <input type="password" class="form-control" id="form_password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
