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
				<p>Hoi <em>naam</em>,</p>
				<p>In het weekend van 1, 2 en 3 juni 2018 organiseert Scouting Raamsdonksveer de G.O.K.: <em>Gezin op Kamp</em>. We nodigen jullie van harte uit om met heel je gezin mee te doen aan de tweede editie van dit gave weekend!</p>
				
				<h3>Wat is Gezin op Kamp?</h3>
				<p>Ergens in een mooie bosrijke omgeving bouwen we speciaal voor het G.O.K.-weekend een camping op. Met je hele gezin kun je daar een weekend naartoe komen. Wij zorgen voor een plekje, eten en drinken en supergave activiteiten. Zelf neem je een tent of caravan mee, of je huurt bij ons een tent. Ook met een vouwwagen, camper, etc. kun je natuurlijk meedoen. De activiteiten worden vrijblijvend aangeboden en je kunt ook met een deel van je gezin meedoen.</p>

				<h3>Wanneer is dat?</h3>
				<p>In het weekend van 1, 2 en 3 juni 2018. De camping gaat op vrijdag om 19:00u open. De officiële opening is zaterdag om 12:00u. Zaterdag en zondag zijn er georganiseerde activiteiten.</p>

				<h3>Wat kost dat?</h3>
				<p>Je betaalt per persoon één prijs voor het hele weekend: &euro;35,-. Daarvoor zorgen wij voor eten en drinken van het ontbijt op zaterdag tot en met de lunch op zondag. Het hele weekend is er gratis koffie, thee en ranja en u kunt meedoen aan talloze activiteiten. Deze prijs is wellicht iets hoger dan je gewend bent van een Scouting-weekend. Het is dan ook niet zomaar een kamp, maar een heuse camping waar jullie gezin welkom is! Voor kinderen van 0 t/m 3 jaar betaalt u overigens alleen de overnachtingskosten: &euro;15,-.</p>

				<h3>Inschrijven</h3>
				<p>Inschrijven kan vanaf nu via onze website <a href="http://scoutingrveer.nl/gok">www.scoutingrveer.nl/gok</a>. Schrijft u zich in vóór 1 maart? Dan ontvangt u een muntje voor een consumptie gratis.</p>

				<h3>Ik heb nog een vraag!</h3>
				<p>Twijfelt u nog? Heeft u een vraag? Heeft uw gezin bijzondere eisen als u gaat kamperen? Op de achterkant van deze brief staan een aantal veelgestelde vragen. Nog steeds een vraag? Mail ons op <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur ons een berichtje via Facebook: <a href="https://m.me/scoutingrveer">facebook.com/scoutingrveer</a>.</p>
			</div>
		</div>
		<div class="page back">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus pariatur, non ratione rerum labore molestiae, sapiente, aliquam blanditiis quaerat, amet quas! Ratione voluptas sapiente, sit illum vero nihil sunt ducimus.</p>
			<p>Itaque laudantium magni distinctio doloremque sit natus veniam quod ratione, voluptas dicta ipsa alias hic ad nemo omnis ullam consequatur officiis repellendus recusandae debitis voluptates placeat enim cum. Tempora, ab.</p>
			<p>Reprehenderit eligendi eaque quas debitis, unde reiciendis. Laborum possimus placeat vitae impedit dicta perspiciatis ullam, modi veniam necessitatibus, quibusdam sed eligendi, fugit ipsa. Laboriosam dolores repellendus laborum id repellat cupiditate!</p>
			<p>Fuga numquam, nobis architecto, vel, quam vero delectus optio quasi hic modi voluptas? Iusto voluptatum, quia laborum quidem nulla excepturi delectus fugit, maiores ullam unde totam eius rem hic distinctio.</p>
			<p>Omnis perferendis, voluptatem repellat, beatae cupiditate reiciendis cumque asperiores neque, debitis fuga quidem laboriosam quasi et illum atque mollitia nesciunt sunt ex minus praesentium aliquid suscipit deleniti. Repellat, eligendi, tempora.</p>
			<p>Corrupti delectus omnis libero laboriosam, officia perferendis magni id. Neque molestias est aliquid repellendus illum a, fugit nobis voluptatem nostrum iusto sapiente odio animi assumenda repellat quo distinctio deleniti voluptas.</p>
		</div>
	@endforeach

@endsection