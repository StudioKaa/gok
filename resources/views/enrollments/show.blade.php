@extends('layouts.app')

@section('content')
<h1>Inschrijving #GOK{{ $enrollment->slug }}</h1>

@if($finished)
	<div class="alert alert-success">
	    <p>Yes, de inschrijving is afgerond!</p>
	</div>
@endif

@if(Request::session()->has('ideal_payed'))
	<div class="alert alert-success">
		<p>De iDEAL betaling is geslaagd!</p>
	</div>
@elseif(Request::session()->has('ideal_pending'))
	<div class="alert alert-danger">
		<p><strong>De status van uw betaling is nog niet bekend.</strong> Wacht een moment, ververs deze pagina en probeer het eventueel opnieuw.</p>
	</div>
@elseif(Request::session()->has('ideal_error'))
	<div class="alert alert-danger">
		<p><strong>Er is een fout opgetreden bij de betaling, probeer het opnieuw!</strong></p>
	</div>
@endif

@if($enrollment->paymentHTML['color'] != 'success')
	@include('enrollments.partial_payment')
@endif

@include('enrollments.partial_table')

@endsection