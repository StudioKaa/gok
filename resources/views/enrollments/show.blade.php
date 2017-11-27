@extends('layouts.app')

@section('content')
<h1>Inschrijving #GOK{{ $enrollment->slug }}</h1>

@if(Request::session()->has('finished'))
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
@endif

<div class="my-table">
	<div class="row my-header">
		<div class="col-4">Adres</div>
		<div class="col-4">Contactpersoon</div>
		<div class="col-4">Kampeermiddel</div>
	</div>
	<div class="row">
		<div class="col-4">{{ $enrollment->address->title }}</div>
		<div class="col-4">{{ $enrollment->cp()->name }}</div>
		<div class="col-4">{{ ucfirst($enrollment->equipment) }}</div>
	</div>
	<div class="row">
		<div class="col-4">{{ $enrollment->address->street }}</div>
		<div class="col-4">{{ $enrollment->cp_email }}</div>
		<div class="col-4">{{ ucfirst($enrollment->equipment_size) }}</div>
	</div>
	<div class="row">
		<div class="col-4">{{ $enrollment->address->postal_code }} {{ $enrollment->address->city }}</div>
		<div class="col-4">{{ $enrollment->cp_phone }}</div>
	</div>
	<div class="row my-header">
		<div class="col-12">Deelnemers</div>
	</div>
	@foreach($payment['lines'] as $line)
	    <div class="row">
	        <div class="col-9">{{ $line['name'] }}</div>
	        <div class="col-3 text-right">&euro;{{ $line['price'] }},-</div>
	    </div>
	@endforeach
	<div class="row my-header">
	    <div class="col-9">Totaal</div>
	    <div class="col-3 text-right">&euro;{{ $payment['total'] }},-</div>
	</div>
	<div class="row my-header">
		<div class="col-12">Termijnen</div>
	</div>
	<div class="row">
		<div class="col-3"><em>Datum:</em></div>
		<div class="col-3"><em>Bedrag:</em></div>
		<div class="col-3"><em>Betalingskenmerk:</em></div>
		<div class="col-3 text-right"><em>Status:</em></div>
	</div>
	<div class="row">
        <div class="col-3">Uiterlijk 1 februari:</div>
        <div class="col-3">&euro;{{ $enrollment->terms[0]->amount }},-</div>
        <div class="col-3">GOK{{ $enrollment->terms[0]->slug }}</div>
        <div class="col-3 text-right">
        	@if($enrollment->terms[0]->state == App\Term::STATE_OPEN)
        		<span class="badge badge-warning">Nog niet betaald</span>
        	@else
        		<span class="badge badge-success">Betaald</span>
        	@endif
        </div>
    </div>
	@if(count($enrollment->terms) > 1)
		<div class="row">
	        <div class="col-3">Uiterlijk 1 mei:</div>
	        <div class="col-3">&euro;{{ $enrollment->terms[1]->amount }},-</div>
	        <div class="col-3">GOK{{ $enrollment->terms[1]->slug }}</div>
	        <div class="col-3 text-right">
	        	@if($enrollment->terms[1]->state == App\Term::STATE_OPEN)
	        		<span class="badge badge-warning">Nog niet betaald</span>
	        	@else
	        		<span class="badge badge-success">Betaald</span>
	        	@endif
	        </div>
	    </div>
	@endif
</div>


@endsection