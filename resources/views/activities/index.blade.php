@extends('layouts.app')

@section('content')
	
	<h3>Keuze-activiteiten</h3>
	<p><a href="{{ route('activities.enroll') }}">Geef nu je voorkeuren door &gt;</a></p>

	<div class="activity-grid mb-4">
	@foreach($activities as $activity)
		<div class="card mb-4">
			@if(!empty($activity->image))
				<img class="card-img-top" src="{{ asset($activity->image) }}" alt="{{ $activity->title }}">
			@endif
		  	<div class="card-body">
		    	<h5 class="card-title">{{ $activity->order }}. {{ $activity->title }}</h5>
		    	<p class="card-text text-muted">
		    		{{ ucfirst($activity->age) }}, {!! $activity->prettyPrice() !!}<br />
		    		{{ $activity->location_generic }}
		    	</p>
		    	<p class="card-text">{{ $activity->description }}</p>
		    	@if(!empty($activity->skills))
			    	<p class="card-text">
			    		<strong>Dit moet je kunnen:</strong><br>
			    		{{ $activity->skills }}
			    	</p>
			    @endif
		  	</div>
		</div>
	@endforeach
	</div>
@endsection
