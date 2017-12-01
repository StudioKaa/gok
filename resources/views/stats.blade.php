@extends('layouts.app')

@section('content')
<div class="stats">
	<div class="row">
	    <div class="col-sm-6">
	        <h2>{{ $count['total'] }}</h2>
	        <p>Deelnemers</p>
	    </div>
	    <div class="col-sm-6">
	        <h2>{{ $enrollments->count() }}</h2>
	        <p>Inschrijvingen</p>
	    </div>
	</div>
	<div class="row">
		<div class="col-12">
			<div id="enrollment-graph"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<h4>{{ $count['e35'] }}</h4>
			<p>Deelnemers &euro;35,-</p>
		</div>
		<div class="col-sm-4">
			<h4>{{ $count['e15'] }}</h4>
			<p>Deelnemers &euro;15,-</p>
		</div>
		<div class="col-sm-4">
			<h4>{{ $count['ideal'] }}</h4>
			<p>Betaald met iDEAL</p>
		</div>
	</div>
</div>

@areachart('inschrijvingen', 'enrollment-graph')

@endsection
