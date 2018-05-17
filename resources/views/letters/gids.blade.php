@extends('layouts.print')

@section('pages')

	@foreach($enrollments as $enrollment)
		<div class="page front">
			<header>
	            <img src="{{ asset('img/logo-zw.png') }}" alt="logo">
	        </header>
	        <div class="address">
	            <p>{{ $enrollment->address->title }}</p>
	            <p>{{ $enrollment->address->street }}</p>
	            <p>{{ $enrollment->address->postal_code }} {{ $enrollment->address->city }}</p>
	        </div>
			<div class="content">
				<p>Beste G.O.K.'ers,</p>
				<p>Het is bijna zover, over twee weken barst het feest los! In deze enveloppe vindt je de campinggids met daarin allerlei praktische informatie in die je voor én tijdens het weekend nodig hebt. Lees de gids dus van tevoren door en neem 'm zeker ook mee naar de G.O.K.!</p>
				
				<h3>Tickets</h3>
				<p>De tickets voor de activiteiten op zaterdag krijg je bij aankomst. Helaas konden niet alle activiteiten doorgaan. Hieronder zie je alvast welke tickets jullie krijgen.</p>
				
				<table style="width: 100%">
					<tr>
						<td>Bart Roos</td>
						<td>Blaat</td>
					</tr>
				</table>
				
				<div class="entrance-ticket">
					<hr>
					<h2>TOEGANGSBEWIJS <strong>#GOK{{ $enrollment->slug }}</strong></h2>
					<p>Neem dit toegangsbewijs mee naar de G.O.K., deze moet je bij aankomst laten zien. Hier ontvang je ook het welkomstpakket met de tickets voor zaterdag en de laatste info. Vervolgens wordt je naar het kampeerterrein gewezen.</p>

					<table style="width: 100%;">
						<tr>
							<th>Contactpersoon</th>
							<th>Aantal deelnemers</th>
							<th>Kampeermiddel</th>
						</tr>
						<tr>
							<td>{{ $enrollment->cp()->name }}</td>
							<td>{{ $enrollment->participants->count() }}</td>
							<td>
								{{ ucfirst($enrollment->equipment) }} 
								@unless(empty($enrollment->equipment_size))
									/ {{ $enrollment->equipment_size }} 
								@endunless
							</td>
						</tr>
					</table>	
				</div>
			</div>
		</div>
	@endforeach

@endsection