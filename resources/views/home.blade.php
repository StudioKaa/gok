@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <h1><img src="{{ asset('img/logo.png') }}" alt="Gezin op Kamp"></h1>
    <p><a class="btn btn-lg btn-success" href="/enrollments/create" role="button">Schrijf je nu in</a></p>
    <p>
        <!-- <a class="btn btn-primary" href="#" role="button">Inschrijven activiteiten</a> -->
        <a class="btn btn-secondary" href="/login" role="button">Bekijk je inschrijving</a></p>
</div>
@endsection
