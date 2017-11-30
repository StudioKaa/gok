@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <h1><img src="{{ asset('img/logo.png') }}" alt="Gezin op Kamp"></h1>
    <p><a class="btn btn-lg btn-success" href="/enrollments/create" role="button">Schrijf je nu in</a></p>
</div>
<p class="mt-5 d-flex justify-content-center">
    <!-- <a class="mr-3 btn btn-primary" href="#" role="button">Inschrijven activiteiten</a> -->
    <a class="btn btn-secondary" href="http://scoutingrveer.nl/gok" target="_blank" role="button">Meer informatie</a>
</p>
@endsection
