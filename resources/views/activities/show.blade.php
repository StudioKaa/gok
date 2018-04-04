@extends('layouts.app')

@section('content')
	<div class="mb-5">
		<h3>Mijn keuze-activiteiten</h3>
		<p><strong>Let op:</strong> hieronder zie je de <em>voorkeuren</em> die je hebt opgegeven. We doen ons best om iedereen bij zijn voorkeur in te delen, maar we geven geen garantie. <a href="{{ route('activities.enroll') }}">Verander je voorkeuren &gt;.</a></p>

		@foreach($enrollment->participants as $participant)
			<p class="mb-0"><strong>{{ $participant->name }}</strong></p>
			@if($participant->activity_preference && !$participant->activity_preference->depends_on)
				<ul>
					<li>Ronde 1: {{ $participant->activity_preference->activity('round_1')->title }}</li>
					<li>Ronde 2: {{ $participant->activity_preference->activity('round_2')->title }}</li>
					<li>Reserve: {{ $participant->activity_preference->activity('spare')->title }}</li>
				</ul>
			@elseif($participant->activity_preference && $participant->activity_preference->depends_on)
				<p>Gaat mee met {{ $participant->activity_preference->parent()->name }}.</p>
			@else
				<p>Nog geen voorkeuren bekend. <a href="{{ route('activities.enroll') }}">Nu je voorkeuren opgeven &gt;.</a></p>
			@endif
		@endforeach
	</div>
		
	@if(!empty($payment))
		<div class="mb-5">
			<h3>Kosten</h3>
			<p>Geschatte extra kosten voor de keuze-activiteiten. Je ontvangt een betaalinstructie als de keuzes definitief zijn geworden.</p>

			<table>
				@foreach($payment as $row)
					<tr>
						<td>{{ $row[0] }}</td>
						<td>&euro;{{ $row[1] }}</td>
					</tr>
				@endforeach
				<tr>
					<td><strong>Totaal</strong></td>
					<td><strong>&euro;{{ $total }}</strong></td>
				</tr>
			</table>
		</div>
	@endif

	@if($enrollment->paymentHTML['color'] != 'success')
		<p>Ps.: van het deelnemersgeld heb je deze termijnen nog open staan:</p>
		@include('enrollments.partial_payment')
	@endif
@endsection