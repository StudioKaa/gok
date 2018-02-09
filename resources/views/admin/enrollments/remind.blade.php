@extends('layouts.admin')

@section('content')
	<h2>Betaling nog niet binnen</h2>
	<p>Van onderstaande inschrijvingen zijn een of meer termijnen nog niet betaald:</p>
	@include('admin.enrollments.partial_table')
	<form action="{{ route('admin.remind.send') }}" method="POST">
		{{ csrf_field() }}
		<button type="submit" class="btn btn-danger"><i class="fa fa-envelope"></i> Stuur betalingsherinnering</button>
	</form>
@endsection