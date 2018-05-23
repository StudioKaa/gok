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
			<div id="participant-graph"></div>
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
	<div class="row">
		<div class="col-12">
			<div id="equipment-graph"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div id="arrival-graph"></div>
		</div>
	</div>
	<div class="row">
		<p><strong>Dieeten</strong></p>
		<div class="col-12">
			<table class="table table-striped">
				@foreach($diets as $diet)
					<tr>
						<td>{{ $diet->diet }}</td>
						<td>{{ $diet->n }}</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class="row" id="tickets">
		<p><strong>Aantal groepen per activiteit</strong></p>
		<div class="col-12">
			<table class="table table-striped">
				<tr>
					<th>Nr.</th>
					<th>Naam</th>
					<th>Ronde</th>
					<th># groepen</th>
					<th># deelnemers</th>
				</tr>
				@foreach($tickets as $row)
					<tr>
						<td>{{ $row->activity_id }}</td>
						<td>{{ $row->activity }}</td>
						<td>{{ $row->round }}</td>
						<td>{{ $row->count_enrollments }}</td>
						<td>{{ $row->count_participants }}</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class="row">
		<p><strong>Voorkeuren keuze-activiteiten</strong></p>
		<div class="col-12">
			<table class="table table-striped">
				@foreach($preferences as $title => $count)
					<tr>
						<td>{{ $title }}</td>
						<td>{{ $count }}</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>

@areachart('participants', 'participant-graph')
@piechart('equipment', 'equipment-graph')
@piechart('arrival', 'arrival-graph')

@endsection
