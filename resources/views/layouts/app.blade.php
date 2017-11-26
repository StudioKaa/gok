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
      <header class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('/') ? 'active' : '') }}}" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('enrollments/create') ? 'active' : '') }}}" href="/enrollments/create">Inschrijven</a>
            </li>
            @if(Auth::check())
              <li class="nav-item">
                <span class="nav-link">{{ Auth::user()->name }}</span>
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
        <p>&copy; Company 2017</p>
      </footer>

    </div>
</body>
</html>
