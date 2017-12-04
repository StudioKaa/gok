<div class="my-table">
	<div class="row">
		<div class="col-sm-4">
			<strong>Adres</strong>
			<span>{{ $enrollment->address->title }}</span>
			<span>{{ $enrollment->address->street }}</span>
			<span>{{ $enrollment->address->postal_code }} {{ $enrollment->address->city }}</span>
		</div>
		<div class="col-sm-4">
			<strong>Contactpersoon</strong>
			<span>{{ $enrollment->cp()->name }}</span>
			<span>{{ $enrollment->cp_email }}</span>
			<span>{{ $enrollment->cp_phone }}</span>
		</div>
		<div class="col-sm-4">
			<strong>Kampeermiddel</strong>
			<span>{{ ucfirst($enrollment->equipment) }}</span>
			<span>{{ ucfirst($enrollment->equipment_size) }}</span>
		</div>
	</div>
	<div class="row my-header">
		<div class="col-12">Deelnemers</div>
	</div>
	<?php $payment = $member->enrollment->paymentLines(); ?>
	@foreach($payment['lines'] as $line)
	    <div class="row">
	        <div class="col-9">{{ $line['name'] }}</div>
	        <div class="col-3 text-right">&euro;{{ $line['price'] }},-</div>
	    </div>
	@endforeach
	<div class="row my-header">
	    <div class="col-9">Totaal</div>
	    <div class="col-3 text-right">&euro;{{ $payment['total'] }},-</div>
	</div>
	<div class="row my-header">
		<div class="col-12">Termijnen</div>
	</div>
	<div class="row d-none d-sm-flex">
		<div class="col-sm-3"><em>Datum:</em></div>
		<div class="col-sm-2"><em>Bedrag:</em></div>
		<div class="col-sm-3"><em>Betalingskenmerk:</em></div>
		<div class="col-sm-4 text-right"><em>Status:</em></div>
	</div>
	@foreach($enrollment->terms as $term)
	<div class="row">
        <div class="col-10 col-sm-3">Uiterlijk {{ $term->date }}:</div>
        <div class="col-2">&euro;{{ $term->amount }}</div>
        <div class="col-12 col-sm-3">GOK{{ $term->slug }}</div>
        <div class="col-12 col-sm-4 text-right">
        	@if($term->state == App\Term::STATE_OPEN)
        		<span class="badge badge-warning">Nog niet betaald</span>
        	@else
        		<span class="badge badge-success">Betaald</span>
        	@endif
        </div>
    </div>
    @endforeach
</div>