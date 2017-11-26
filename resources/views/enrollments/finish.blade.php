@extends('layouts.app')

@section('content')
<h1>Inschrijven G.O.K. 2018</h1>
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div class="alert alert-success">
    <p>Yes, de inschrijving is afgerond!</p>


<h3>Betaalinstructie</h3>
@if(count($enrollment->terms) == 1)
    <p>U heeft ervoor gekozen om in &eacute;&eacute;n keer te betalen.</p>
    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $payment['total'] }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
@else
    <p>U heeft ervoor gekozen om in twee termijnen te betalen.</p>
    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $enrollment->terms[0]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
    <p>Maak uiterlijk 1 mei het bedrag van <strong>&euro;{{ $enrollment->terms[1]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[1]->slug }}</strong></p>
@endif
<p>U ontvangt de betaalinstructie ook op het e-mailadres van de contactpersoon.</p>
</div>
@endsection