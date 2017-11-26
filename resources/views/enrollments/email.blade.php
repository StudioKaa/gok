<h1>Inschrijving #GOK{{ $enrollment->slug }}</h1>

<p>Uw inschrijving is succesvol afgerond. Bewaar deze mail goed! Met vragen kunt u altijd mailen naar gok@scoutingrveer.nl.</p>

<h3>Betaalinstructie</h3>
@if(count($enrollment->terms) == 1)
    <p>U heeft ervoor gekozen om in &eacute;&eacute;n keer te betalen.</p>
    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $payment['total'] }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
@else
    <p>U heeft ervoor gekozen om in twee termijnen te betalen.</p>
    <p>Maak zo snel mogelijk, maar uiterlijk 1 februari het bedrag van <strong>&euro;{{ $enrollment->terms[0]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[0]->slug }}</strong></p>
    <p>Maak uiterlijk 1 mei het bedrag van <strong>&euro;{{ $enrollment->terms[1]->amount }},-</strong> over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <strong>GOK{{ $enrollment->terms[1]->slug }}</strong></p>
@endif

<h3>Overzicht inschrijving</h3>
<table class="table">
    @foreach($payment['lines'] as $line)
    <tr>
        <td>{{ $line['name'] }}</td>
        <td>&euro;{{ $line['price'] }},-</td>
    </tr>
    @endforeach
    <tr class="bg-secondary">
        <td><strong>Totaal</strong></td>
        <td><strong>&euro;{{ $payment['total'] }},-</strong></td>
    </tr>
</table>