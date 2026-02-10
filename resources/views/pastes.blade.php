<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastes</title>
</head>
<body>
    @extends('layout')

    @section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Список записей</h5>

            <div class="d-flex align-items-center">
                <form class="me-2" method="get" action="{{ route('paste.index') }}">
                    <label class="me-1">Записей на странице:</label>
                    <select name="perpage" class="form-select form-select-sm" style="width:100px" onchange="this.form.submit()">
                        @foreach([2,5,10,25] as $pp)
                            <option value="{{ $pp }}" {{ request('perpage', $pastes->perPage()) == $pp ? 'selected' : '' }}>{{ $pp }}</option>
                        @endforeach
                    </select>
                </form>

                @auth
                <a href="{{ route('paste.create') }}" class="btn btn-success btn-sm">Добавить запись</a>
                @endauth
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Доступ</th>
                        <th>Создано</th>
                        <th class="text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pastes as $paste)
                        <tr>
                            <td>{{ $paste->id }}</td>
                            <td><a href="{{ route('paste.show', $paste->id) }}">{{ $paste->title }}</a></td>
                            <td>{{ $paste->access == 1 ? 'Публичная' : 'Приватная' }}</td>
                            <td>{{ $paste->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('paste.show', $paste->id) }}" class="btn btn-sm btn-outline-primary">Просмотр</a>

                                @auth
                                    <a href="{{ route('paste.edit', $paste->id) }}" class="btn btn-sm btn-outline-warning">Редактировать</a>

                                    <form class="d-inline" method="POST" action="{{ route('paste.destroy', $paste->id) }}" onsubmit="return confirm('Удалить запись?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Удалить</button>
                                    </form>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Записей нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-2">
                <div class="pagination-summary">
                    Показано {{ $pastes->firstItem() ?? 0 }}–{{ $pastes->lastItem() ?? 0 }} из {{ $pastes->total() }}
                </div>

                <div class="pagination-wrapper">
                    {{-- per-page selector (keeps query string) --}}
                    <form class="d-flex align-items-center" method="get" action="{{ route('paste.index') }}">
                        <label class="me-2 mb-0">Записей на странице:</label>
                        <select name="perpage" class="form-select form-select-sm me-2" style="width:95px" onchange="this.form.submit()">
                            @foreach([2,5,10,25,50] as $pp)
                                <option value="{{ $pp }}" {{ request('perpage', $pastes->perPage()) == $pp ? 'selected' : '' }}>{{ $pp }}</option>
                            @endforeach
                        </select>
                        <noscript><button class="btn btn-sm btn-secondary">Изменить</button></noscript>
                    </form>

                    {{-- centered pagination (uses bootstrap-5 template from vendor) --}}
                    <nav aria-label="Pagination navigation">
                        {{ $pastes->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
</html>
