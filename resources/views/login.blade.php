    @extends('layout')

    @section('content')
    <div class="container" style="margin-top:70px;">
        @include('error')

        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-6 col-lg-4">
                <div class="card shadow-sm bg-dark text-white">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Вход в систему</h3>

                        <form method="POST" action="{{ route('auth') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" name="email" type="email"
                                       class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input id="password" name="password" type="password"
                                       class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="color: #cfd8dc;">Запомнить</label>
                                </div>
                                <a href="{{ route('login') }}" class="text-decoration-none" style="color:#9fb0ff;">Забыли?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Войти</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3 text-muted small">
                    Нет аккаунта? Обратитесь к администратору.
                </div>
            </div>
        </div>
    </div>
    @endsection