@extends('layouts.app')

@section('content')
	
	<div class="activity-grid">
	
	@foreach($activities as $activity)
		<div class="card mb-4">
			@if(!empty($activity->image))
				<img class="card-img-top" src="{{ asset($activity->image) }}" alt="{{ $activity->title }}">
			@endif
		  	<div class="card-body">
		    	<h5 class="card-title">{{ $activity->title }}</h5>
		    	<p class="card-text text-muted">
		    		{{ ucfirst($activity->age) }}, {{ $activity->price }}<br />
		    		{{ $activity->location_generic }}, {{ $activity->duration }}
		    	</p>
		    	<p class="card-text">{{ $activity->description }}</p>
		    	<p class="card-text">
		    		<strong>Vaardigheden</strong><br>
		    		{{ $activity->skills }}
		    	</p>
		  	</div>
		</div>
	@endforeach

	</div>
@endsection
