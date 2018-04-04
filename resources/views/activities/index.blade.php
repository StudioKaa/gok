@extends('layouts.app')

@section('content')
	
	<div class="activity-grid mb-4">
	
	@foreach($activities as $activity)
		<div class="card mb-4">
			@if(!empty($activity->image))
				<img class="card-img-top" src="{{ asset($activity->image) }}" alt="{{ $activity->title }}">
			@endif
		  	<div class="card-body">
		    	<h5 class="card-title">{{ $activity->title }}</h5>
		    	<?php if(isset($_GET['show'])): ?>
		    	<p class="card-text text-muted">
		    		{{ ucfirst($activity->age) }}, {{ $activity->price }}<br />
		    		{{ $activity->location_generic }}
		    	</p>
		    	<?php endif; ?>
		    	<p class="card-text">{{ $activity->description }}</p>
		    	<?php if(isset($_GET['show'])): ?>
		    	@if(!empty($activity->skills))
			    	<p class="card-text">
			    		<strong>Vaardigheden</strong><br>
			    		{{ $activity->skills }}
			    	</p>
			    @endif
				<?php endif; ?>
		  	</div>
		</div>
	@endforeach

	</div>
@endsection
