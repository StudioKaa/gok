@extends('layouts.print')

@section('pages')

	@foreach($members as $member)

		@if(!$member->hasCompleteEnrollment())
			<div class="page front">
				<header>
		            <img src="{{ asset('img/logo-zw.png') }}" alt="logo">
		        </header>
				<div class="content pull-up">
					<p>{{ $member->{'Speleenheid'} }} - {{ $member->{'Lid voornaam'} }} {{ $member->{'Lid tussenvoegsel'} }} {{ $member->{'Lid achternaam'} }} en gezin</p>
					<p>In het weekend van 1, 2 en 3 juni 2018 organiseert Scouting Raamsdonksveer de G.O.K.: <em>Gezin op Kamp</em>. We nodigen jullie van harte uit om met heel je gezin mee te doen aan de tweede editie van dit gave weekend!</p>
					
					<h3>Wat is Gezin op Kamp?</h3>
					<p>Ergens in een mooie bosrijke omgeving bouwen we speciaal voor het G.O.K.-weekend een camping op. Met je hele gezin kun je daar een weekend naartoe komen. Wij zorgen voor een plekje, eten en drinken en supergave activiteiten. Zelf neem je een tent of caravan mee. Als je zelf geen kampeermiddel hebt, kun je ook bij ons een tent huren. Ook met een vouwwagen, camper, piratenschip, etc. kun je natuurlijk meedoen. De activiteiten worden vrijblijvend aangeboden en je kunt ook met een deel van je gezin meedoen.</p>

					<h3>Wanneer is dat?</h3>
					<p>In het weekend van 1, 2 en 3 juni 2018. De camping gaat op vrijdag al open. De officiële opening is zaterdag om 11:30u. Je kunt dus ook op zaterdag pas komen.</p>

					<h3>Wat kost dat?</h3>
					<p>Je betaalt per persoon één prijs voor het hele weekend: &euro;35,-. Daarvoor zorgen wij het hele weekend voor eten, drinken en gave activiteiten. Deze prijs is wellicht iets hoger dan je gewend bent van een Scouting-weekend. Het is dan ook niet zomaar een kamp, maar een heuse camping waar jullie gezin welkom is! Voor kinderen van 0 t/m 3 jaar betaalt u alleen de overnachting: &euro;15,-.</p>

					<h3>Inschrijven</h3>
					<p>Inschrijven kan vanaf nu via onze website: <a href="http://scoutingrveer.nl/gok">www.scoutingrveer.nl/gok</a>! Schrijft u zich in vóór 1 maart? Dan ontvangt u per persoon een muntje voor een consumptie gratis.</p>

					<h3>Ik heb nog een vraag!</h3>
					<p>Op de achterkant van deze brief staan een aantal veelgestelde vragen, maar aarzel vooral niet om contact op te nemen! Mail ons op <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje via Facebook. Op 27 januari van 12:00u tot 13:00u kunt u binnenlopen op Scouting om al uw vragen te stellen.</p>

					<p>We zien uw inschrijving of vragen graag tegemoet!<br />
					Organisatieteam G.O.K.: Bart, Harvey, Isabel, Jordi, Marjolein, Michiel, Roxanne en Ruud</p>
				</div>
			</div>
		@else
			<div class="page front">
				<header>
		            <img src="{{ asset('img/logo-zw.png') }}" alt="logo">
		        </header>
				<div class="content pull-up">
					<p>{{ $member->{'Speleenheid'} }} - {{ $member->{'Lid voornaam'} }} {{ $member->{'Lid tussenvoegsel'} }} {{ $member->{'Lid achternaam'} }} en gezin</p>
					<p>Wat gaaf dat jullie je al hebben ingeschreven voor <em>Gezin op Kamp</em>! Vandaag ontvangt iedereen de officiële uitnodiging, maar die hebben jullie natuurlijk niet meer nodig. We bedanken jullie voor het vertrouwen, en wij hebben er net zoveel zin in als jullie!</p>

					<p>Op de achterkant van deze brief vind je nog een overzicht van de meest gestelde vragen, wellicht is dat voor jullie ook nog interessant. Heb je nog andere vragen? Aarzel dan niet om contact op te nemen! Mail ons op <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje via Facebook: <a href="https://m.me/scoutingrveer">facebook.com/scoutingrveer</a></p>
					
					<h3 class="mt-4">Overzicht inschrijving</h3>
					<table class="table table-sm mb-4">
						<?php $payment = $member->enrollment->paymentLines(); ?>
					    @foreach($payment['lines'] as $line)
					    <tr>
					        <td>{{ $line['name'] }}</td>
					        <td>&euro;{{ $line['price'] }},-</td>
					    </tr>
					    @endforeach
					    <tr class="bg-light">
					        <td><strong>Totaal</strong></td>
					        <td><strong>&euro;{{ $payment['total'] }},-</strong></td>
					    </tr>
					</table>

					<h3>Betaalinstructie</h3>
					@foreach($member->enrollment->terms as $term)
					    <p>Termijn van &euro;{{ $term->amount }} te betalen uiterlijk {{ $term->date }} - 
					    @if($term->state == \App\Term::STATE_OPEN)
					        maak het bedrag over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <em>GOK{{ $term->slug }}</em>.</p>
					    @else
					        <strong>de betaling is al afgerond</strong>.
					    @endif
					    </p>
					@endforeach

					<p>Organisatieteam G.O.K.: Bart, Harvey, Isabel, Jordi, Marjolein, Michiel, Roxanne en Ruud</p>
				</div>
			</div>
		@endif
		<div class="page back columns content">
			<div>
				<h3>Geen eigen tent of caravan?</h3>
				<p>Geen nood, wij hebben een aantal tenten te huur tegen een kleine vergoeding! Op het inschrijfformulier kunt u aangeven of u hier gebruik van wilt maken.</p>

				<h3>Wat is er vrijdagavond te doen?</h3>
				<p>Je hoeft je niet te vervelen als je vrijdag al komt! Onze camping ligt in een prachtig bosgebied waar je mooi kunt wandelen. Uiteraard is er vrijdagavond al een kampvuurtje en gaat de bar vast open.</p>
				
				<h3>Waar gaan we eigenlijk heen?</h3>
				<p>We bouwen onze camping op in een prachtig bosgebied bij Sint-Anthonis in Oost-Brabant. Dat is ongeveer een uur rijden vanaf Raamsdonksveer. Hier vindt je "de Beugense Peel", een staatsbosbeheer-kampeerterrein. Voor de G.O.K. hebben we dit hele terrein tot onze beschikking. Het kampeerterrein ligt deels in het bos en bestaat voor een deel uit grasveld.</p>
				
				<h3>Kan onze zoon/dochter niet alleen mee?</h3>
				<p>Het weekend is opgezet als gezinsweekend. Onze vrijwilligers zijn druk met de activiteiten. Anders dan bij een gewoon kamp zijn wij daarom geen leiding, maar camping-staf. Leden kunnen dus niet alleen inschrijven.</p> <p>Het is wel mogelijk dat leden met een ander gezin meedoen, of dat ze hun oom, tante, opa of oma meenemen. Voor de explorers zijn hierover aparte afspraken gemaakt.</p>

				<h3>Mag mijn hond/huisdier mee?</h3>
				<p>Ja, maar we moedigen dit niet aan. Omdat het grootste deel van de camping speelterrein is zijn er beperkte mogelijkheden voor uitlaten. Ook zal uw hond waarschijnlijk niet los mogen lopen.</p>

			</div>
			<div>
				<h3>Wie organiseren de G.O.K. eigenlijk?</h3>
				<p>Al onze vrijwilligers werken mee aan de G.O.K. Het kernteam bestaat uit: Bart, Harvey, Isabel, Jordi, Marjolein, Michiel, Roxanne en Ruud. Spreek ons gerust eens aan als je een vraag hebt!</p>

				<h3>Hoe zit het met eten en drinken?</h3>
				<p>Het weekend is all-in: behalve uw slaapspullen hoeft u verder niets mee te nemen. Wij zorgen voor al het eten, van het ontbijt op zaterdag tot de lunch op zondag. U hoeft niet zelf te koken. Er is de hele dag gratis koffie, thee en ranja.</p>
				<p>Daarnaast is er de bar waar je de hele dag fris en wat lekkers kunt halen, en 's avonds ook bier en wijn. Hiervoor betaal je met muntjes (tegen kostprijs). Schrijf je je voor 1 maart in, dan ontvang je per persoon een muntje gratis!</p>

				<h3>Wat voor activiteiten zijn er?</h3>
				<p>Op zaterdag zijn er, na de opening en de lunch, keuze-activiteiten. Een paar weken voor de G.O.K. sturen we het activiteitenboekje rond en kunt u voorkeuren aangeven. Denk bijvoorbeeld aan: vlot bouwen, speurtocht, koken op houtvuur, sauna bouwen, zeskamp, schilderen, geocaching, en nog veel meer!</p>
				<p> Na het avondeten is er het avondprogramma, daarna gaat het kampvuur aan en is de bar open. Zondag kun je als gezin meedoen aan een groot spel, en daarna sluiten we alweer af! Activiteiten zijn altijd vrijblijvend, nooit verplicht.</p>

				<img class="bottle" src="{{ asset('img/bottle.png') }}" alt="bottle">
			</div>
		</div>
	@endforeach

@endsection