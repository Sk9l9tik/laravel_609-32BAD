<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Paste</title>
    <style>
        .is-invalid { color: red; }
    </style>
</head>
<body>
    @extends('layout')

    @section('content')
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Редактировать запись #{{ $paste->id }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('paste.update', $paste->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Заголовок</label>
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $paste->title) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Текст</label>
                    <textarea name="main_text" rows="6" class="form-control @error('main_text') is-invalid @enderror" required>{{ old('main_text', $paste->main_text) }}</textarea>
                    @error('main_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Доступ</label>
                        <select name="access" class="form-select">
                            <option value="public" {{ old('access', $paste->access)=='public' ? 'selected' : '' }}>Публичный</option>
                            <option value="private" {{ old('access', $paste->access)=='private' ? 'selected' : '' }}>Приватный</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Срок (часы)</label>
                        <input name="expiration" type="number" class="form-control" value="{{ old('expiration', $paste->expiration ?? 24) }}" min="1">
                    </div>
                </div>

                <button class="btn btn-primary">Сохранить</button>
                <a href="{{ route('paste.index') }}" class="btn btn-secondary">Отмена</a>
            </form>
        </div>
    </div>
    @endsection
</body>
</html>