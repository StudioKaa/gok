	@extends('layouts.print')

	@section('pages')

		@foreach($enrollments as $enrollment)
			<div class="page front">
				<header>
		            <img src="{{ asset('img/logo-zw.png') }}" alt="logo">
		        </header>
		        <div class="address" style="font-size: 1.5em;">
		            <p>{{ $enrollment->address->title }}</p>
		            <p>#GOK{{ $enrollment->slug }}</p>
		        </div>
				<div class="content">
					<p>Welkom op de G.O.K.!</p>
					
					<p>Er is dit jaar geen vaste indeling op de camping. Volg wel de aanwijzingen van onze vrijwilligers, als je een plekje uitzoekt.</p>
					
					<p>In deze envelop vind je de tickets voor zaterdagmiddag. Raak deze niet kwijt! Op de tickets lees je hoe laat en waar je moet verzamelen. Als jullie je voor 1 maart hebben aangemeld, vind je hier ook de gratis muntjes!</p>
					
					<h3>Programma - vrijdag</h3>
					<p>Rond 20:30u is er een welkomstwoordje bij het kampvuur. Daarna gaat de bar open. 's Avonds hebben we nog iets te eten voor de liefhebbers (gratis).</p>

					<h3>Programma - zaterdag</h3>
					<p>
						08:00u - 10:00u Ontbijtbuffet geopend<br/ >
						11:30u - 12:00u Opening<br/ >
						12:00u - 13:00u Lunchbuffet geopend<br/ >
						13:00u - 17:30u Ticket-activiteiten<br/ >
						18:00u - 20:00u Avondeten geopend<br/ >
						20:00u - 22:00u Verassingsprogramma<br/ >
						Vanaf 22:00u Kampvuur
					</p>
					
					<h3>Vragen?</h3>
					<p>Kom naar het hoofdkwartier, daar is altijd iemand die je vraag kan beantwoorden!</p>

					<p>
						We wensen jullie heel veel plezier dit weekend!<br />
						Organistatieteam G.O.K.
					</p>
					
				</div>
			</div>
		@endforeach

	@endsection
