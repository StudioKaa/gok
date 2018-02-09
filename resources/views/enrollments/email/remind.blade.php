<h1>Betalingsherinnering #GOK{{ $enrollment->slug }}</h1>

<p>Een of meer termijnen zijn verlopen. Wij verzoeken u onderstaande betalingen zo snel mogelijk te voldoen.</p>

<h3>Betaalinstructie</h3>
@foreach($enrollment->terms as $term)
    <p>Termijn van &euro;{{ $term->amount }} te betalen uiterlijk {{ $term->date }} - 
    @if($term->state == \App\Term::STATE_OPEN)
        maak het bedrag over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <em>GOK{{ $term->slug }}</em>.</p>
    @else
        <strong>de betaling is al afgerond</strong>.
    @endif
    </p>
@endforeach

@if($enrollment->paymentHTML['color'] != 'success')
    <p>U kunt ook <a href="{{ url('/login/' . $base64) }}">direct online betalen met iDEAL</a>.</p>
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