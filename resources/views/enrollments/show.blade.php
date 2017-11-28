@extends('layouts.app')

@section('content')
<h1>Inschrijving #GOK{{ $enrollment->slug }}</h1>

@if(Request::session()->has('finished'))
	<div class="alert alert-success">
	    <p>Yes, de inschrijving is afgerond!</p>
	</div>
@elseif(Request::session()->has('ideal_payed'))
	<div class="alert alert-success">
		<p><strong>De iDEAL betaling is geslaagd!</strong></p>
	</div>
@elseif(Request::session()->has('ideal_error'))
	<div class="alert alert-danger">
		<p><strong>Er is een fout opgetreden bij de betaling!</strong></p>
	</div>
@endif

<div class="my-table">
	<div class="row">
		<div class="col-sm-4">
			<strong>Adres</strong>
			<span>{{ $enrollment->address->title }}</span>
			<span>{{ $enrollment->address->street }}</span>
			<span>{{ $enrollment->address->postal_code }} {{ $enrollment->address->city }}</span>
		</div>
		<div class="col-sm-4">
			<strong>Contactpersoon</strong>
			<span>{{ $enrollment->cp()->name }}</span>
			<span>{{ $enrollment->cp_email }}</span>
			<span>{{ $enrollment->cp_phone }}</span>
		</div>
		<div class="col-sm-4">
			<strong>Kampeermiddel</strong>
			<span>{{ ucfirst($enrollment->equipment) }}</span>
			<span>{{ ucfirst($enrollment->equipment_size) }}</span>
		</div>
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
	<div class="row d-none d-sm-flex">
		<div class="col-sm-3"><em>Datum:</em></div>
		<div class="col-sm-2"><em>Bedrag:</em></div>
		<div class="col-sm-3"><em>Betalingskenmerk:</em></div>
		<div class="col-sm-4 text-right"><em>Status:</em></div>
	</div>
	<div class="row">
        <div class="col-10 col-sm-3">Uiterlijk 1 februari:</div>
        <div class="col-2">&euro;{{ $enrollment->terms[0]->amount }},-</div>
        <div class="col-12 col-sm-3">GOK{{ $enrollment->terms[0]->slug }}</div>
        <div class="col-12 col-sm-4 text-right">
        	@if($enrollment->terms[0]->state == App\Term::STATE_OPEN)
        		<span class="badge badge-warning"><a href="{{ route('ideal.pay', $enrollment->terms[0]->slug) }}">Betaal nu met iDEAL</a></span>
        	@else
        		<span class="badge badge-success">Betaald</span>
        	@endif
        </div>
    </div>
	@if(count($enrollment->terms) > 1)
		<div class="row">
	        <div class="col-10 col-sm-3">Uiterlijk 1 mei:</div>
	        <div class="col-2">&euro;{{ $enrollment->terms[1]->amount }},-</div>
	        <div class="col-12 col-sm-3">GOK{{ $enrollment->terms[1]->slug }}</div>
	        <div class="col-12 col-sm-4 text-right">
	        	@if($enrollment->terms[1]->state == App\Term::STATE_OPEN)
	        		<span class="badge badge-warning"><a href="{{ route('ideal.pay', $enrollment->terms[1]->slug) }}">Betaal nu met iDEAL</a></span>
	        	@else
	        		<span class="badge badge-success">Betaald</span>
	        	@endif
	        </div>
	    </div>
	@endif
</div>

<div class="alert alert-success mt-4">
	<h3>Betaalinstructie</h3>
	@if(count($enrollment->terms) == 1)
	    <p>Klik hierboven op <em>Betaal nu met iDEAL</em>, of maak het bedrag over:</p>
	    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $payment['total'] }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
	@else
	    <p>Klik hierboven op <em>Betaal nu met iDEAL</em>, of maak het bedrag over:</p>
	    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $enrollment->terms[0]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
	    <p>Maak uiterlijk 1 mei het bedrag van <strong>&euro;{{ $enrollment->terms[1]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[1]->slug }}</strong></p>
	@endif
	<p>U ontvangt de betaalinstructie ook op het e-mailadres van de contactpersoon.</p>
</div>

@endsection