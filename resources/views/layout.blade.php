<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>609-32</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Laravel Project</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('paste.index') }}">Pastes</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('paste.create') }}">Create</a></li>
                @endauth
            </ul>

            <div class="d-flex align-items-center">
                @guest
                    <form class="d-flex" method="POST" action="{{ route('auth') }}">
                        @csrf
                        <input name="email" class="form-control form-control-sm me-2" type="text" placeholder="Email" value="{{ old('email') }}">
                        <input name="password" class="form-control form-control-sm me-2" type="password" placeholder="Password">
                        <button class="btn btn-outline-success btn-sm" type="submit">Sign in</button>
                    </form>
                @else
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userMenu" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li><a class="dropdown-item" href="{{ route('paste.index') }}">My pastes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<main class="container my-4 flex-grow-1">
    {{-- вывод флеш сообщений --}}
    @include('error')

    {{-- содержимое страницы --}}
    @yield('content')
</main>

<footer class="bg-light text-center py-3 mt-auto">
    &copy; {{ date('Y') }}
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>