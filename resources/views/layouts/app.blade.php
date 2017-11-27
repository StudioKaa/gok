<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GOK - Scouting Raamsdonksveer</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/narrow-jumbotron.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
      <header class="header">
        <nav>
          <ul class="nav nav-pills">
          @if(!Auth::check())
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('/') ? 'active' : '') }}}" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('enrollments/create') ? 'active' : '') }}}" href="/enrollments/create">Inschrijven</a>
            </li>
          @else
            <li class="nav-item">
              <a href="/enrollments/{{ Auth::user()->enrollment->slug }}/continue" class="nav-link">{{ Auth::user()->name }}</a>
            </li>
          @endif
          </ul>
        </nav>
        <h3 class="text-muted">G.O.K. 2018</h3>
      </header>

      <main role="main">
        @yield('content')
      </main>

      <footer class="footer">
        <p>S.B.B.S. namens Scouting Raamsdonksveer, Kerklaan 22 4942AR Raamsdonksveer, KvK: 41100325, tel: 0162769096, mail: gok@scoutingrveer.nl.</p>
      </footer>

    </div>
</body>
</html>
