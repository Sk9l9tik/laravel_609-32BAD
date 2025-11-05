@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <form method="post" action="{{ url('/paste/store') }}">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" 
                       class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" 
                       aria-describedby="titleHelp" 
                       value="{{ old('title') }}">
                <div id="titleHelp" class="form-text">Введите название пасты</div>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="main_text" class="form-label">Основной текст</label>
                <textarea class="form-control @error('main_text') is-invalid @enderror" 
                          id="main_text" name="main_text" rows="10" required>{{ old('main_text') }}</textarea>
                @error('main_text')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="expiration" class="form-label">Срок хранения</label>
                <select class="form-select @error('expiration') is-invalid @enderror" 
                        id="expiration" name="expiration" aria-describedby="expirationHelp">
                    <option value="">-- выберите --</option>
                    <option value="24" {{ old('expiration') == '1 day' ? 'selected' : '' }}>1 день</option>
                    <option value="72" {{ old('expiration') == '3 days' ? 'selected' : '' }}>3 дня</option>
                    <option value="168" {{ old('expiration') == '7 days' ? 'selected' : '' }}>7 дней</option>
                    <option value="720" {{ old('expiration') == '30 days' ? 'selected' : '' }}>30 дней</option>
                </select>
                <div id="expirationHelp" class="form-text">Выберите срок действия пасты</div>
                @error('expiration')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="access" class="form-label">Доступ</label>
                <select class="form-select @error('access') is-invalid @enderror" 
                        id="access" name="access" aria-describedby="accessHelp">
                    <option value="">-- выберите --</option>
                    <option value="false" {{ old('access') == 'public' ? 'selected' : '' }}>Публичная</option>
                    <option value="true" {{ old('access') == 'private' ? 'selected' : '' }}>Приватная</option>
                </select>
                <div id="accessHelp" class="form-text">Выберите уровень доступа</div>
                @error('access')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>
</div>
@endsection