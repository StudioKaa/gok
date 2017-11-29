<h3>Betaalinstructie</h3>
@foreach($enrollment->terms as $term)
	@if($term->state == \App\Term::STATE_OPEN)
	<div class="alert alert-success mt-4">
		<p>Termijn van <strong>&euro;{{ $term->amount }}</strong> te betalen uiterlijk <strong>{{ $term->date }}</strong>:</p>
		<div class="row d-flex align-items-center">
			<div class="col-sm-4 text-center"><a class="btn btn-primary" href="{{ route('ideal.pay', $term->slug) }}">Betaal nu met iDEAL</a></div>
			<div class="col-sm-8"><p>Maak het bedrag over naar de contributierekening: NL27RABO0143010840 onder vermelding van het betalingskenmerk: <em>GOK{{ $term->slug }}</em>.</p></div>
		</div>
		    
	</div>
	@endif
@endforeach