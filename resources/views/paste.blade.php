<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $paste->title ?? 'Paste' }}</title>
</head>
<body>
    @extends('layout')

    @section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $paste->title }}</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Доступ:</strong>
                {{ $paste->access ? 'Публичная' : 'Приватная' }}
            </div>

            <div class="mb-3">
                <strong>Создано:</strong> {{ $paste->created_at->format('Y-m-d H:i') }}
            </div>

            <hr>

            <div class="paste-text" style="white-space: pre-wrap;">
                {!! nl2br(e($paste->main_text)) !!}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('paste.index') }}" class="btn btn-secondary btn-sm">Назад</a>
        </div>
    </div>
    @endsection
</body>
</html>