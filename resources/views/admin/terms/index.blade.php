@extends('layouts.admin')

@section('content')
	
	<table class="table table-striped table-hover">
		<tr>
			<th>#</th>
			<th>Inschrijving</th>
			<th>Status</th>
			<th>Bedrag</th>
			<th>Acties</th>
		</tr>
		@foreach($terms as $term)
			<tr>
				<td>{{ $term->slug }}</td>
				<td>{{ $term->enrollment->slug }}</td>
				<td>
					@if($term->state == \App\Term::STATE_PAYED)
						Betaald
					@else
						<span class="badge badge-danger">Open</span>
					@endif
				</td>
				<td>&euro;{{ $term->amount }},-</td>
				<td>
					@if($term->state == \App\Term::STATE_OPEN)
						<a href="{{ route('admin.terms.pay', $term->id) }}"><i class="fa fa-check"></i> betalen</a>
					@endif
				</td>
			</tr>
		@endforeach
	</table>

@endsection