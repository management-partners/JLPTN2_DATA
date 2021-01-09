<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title') | Update Data JLPT N2</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <link rel="stylesheet" href="{{ url('fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @yield('style')
</head>

<body class="antialiased">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top app-menu">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'grammar' ? 'active' : '' }}" href="/grammar">Grammar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'grammar-example' ? 'active' : '' }}" href="/grammar-example">Grammar Example</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'kanji' ? 'active' : '' }}" href="/kanji">Kanji</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'kanji-example' ? 'active' : '' }}" href="/kanji-example">Kanji Example</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'vocabulary' ? 'active' : '' }}" href="/vocabulary">Vocabulary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'vocabulary-example' ? 'active' : '' }}" href="/vocabulary-example">Vocabulary Example</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'lookandlearn' ? 'active' : '' }}" href="/lookandlearn">Look And Learn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(1) == 'lookandlearn-example' ? 'active' : '' }}" href="/lookandlearn-example">Look And Learn Example</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>