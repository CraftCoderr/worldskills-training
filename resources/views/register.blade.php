@extends('layout')

@section('content')
    <div class="content container mt-5">
        <div class="col-8 mx-auto">
            <div class="card">
                <h5 class="card-header">Регистрация</h5>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="surname">Фамилия</label>
                            <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname"  value="{{ old('surname') }}">
                            @error('surname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="project">Проект</label>
                            <select class="custom-select @error('project') is-invalid @enderror" id="project" name="project" required>
                                <option @if(old('project') > 0) value="{{ old('project') }}" @else disabled @endif selected>Выберите проект</option>
                                @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="spec">Специализация или направление разработки</label>
                            <select class="custom-select @error('spec') is-invalid @enderror" id="spec" name="spec" required>
                                <option @if(old('spec') > 0) value="{{ old('spec') }}" @else disabled @endif  selected>Выберите специализацию</option>
                                @foreach($specs as $spec)
                                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                @endforeach
                            </select>
                            @error('spec')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo" required>
                            <label class="custom-file-label" for="photo">Выберите файл...</label>
                            @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
