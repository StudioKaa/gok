<table class="table table-striped table-hover">
	<tr>
		<th>#</th>
		<th>Status</th>
		<th>Naam</th>
		<th>Deelnemers</th>
		<th>Betaling</th>
		<th>Inschrijfdatum</th>
		<th>Acties</th>
	</tr>
	@foreach($enrollments as $enrollment)
		<tr>
			<td>{{ $enrollment->slug }}</td>
			<td>
				@if($enrollment->state == \App\Enrollment::STATE_ENROLLED)
					Aangemeld
				@else
					<span class="badge badge-{{ $enrollment->stateHTML['color'] }}">{{ $enrollment->stateHTML['title'] }}</span>
				@endif
			</td>
			<td>{{ $enrollment->address->title or '' }}</td>
			<td>{{ count($enrollment->participants) }}</td>
			<td>
				@if($enrollment->paymentHTML['color'] == 'success')
					Betaald
				@else
					<span class="badge badge-{{ $enrollment->paymentHTML['color'] }}">{{ $enrollment->paymentHTML['title'] }}</span>
				@endif
			</td>
			<td>{{ $enrollment->created_at }}</td>
			<td>
				<div class="btn-group">
					<a class="btn btn-secondary" target="_blank" href="{{ route('enrollments.show', $enrollment->slug) }}"><i class="fa fa-eye"></i></a>
					<a class="btn btn-danger" href="#"><i class="fa fa-ban"></i></a>
				</div>
			</td>
		</tr>
	@endforeach
</table>