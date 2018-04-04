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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/narrow-jumbotron.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
      <header class="header">
        <nav>
          <ul class="nav nav-pills">
          @if(!Auth::check() || Auth::user()->admin)
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('/') ? 'active' : '') }}}" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('enrollments/create') ? 'active' : '') }}}" href="/enrollments/create">Inschrijven</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{{ (Request::is('login') ? 'active' : '') }}}" href="/login">Mijn inschrijving</a>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route('activities.show') }}" class="nav-link">Keuze-activiteiten</a>
            </li>
            <li class="nav-item">
              <a href="/enrollments/{{ Auth::user()->enrollment->slug }}/continue" class="nav-link">Mijn inschrijving</a>
            </li>
            <li class="nav-item">
              <span class="nav-link">{{ optional(Auth::user()->enrollment->cp())->name }}</span>
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
