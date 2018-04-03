@extends('layouts.admin')

@section('content')
	
	<a class="btn btn-success mb-2" href="{{ route('admin.activities.create') }}"><i class="fa fa-plus"></i> Nieuw</a>

	<table class="table table-striped table-hover">
		<tr>
			<th>&nbsp;</th>
			<th>#</th>
			<th>Titel</th>
			<th>Aantal x voorkeur</th>
			<th>Acties</th>
		</tr>
		@foreach($activities as $activity)
			<tr>
				<td></td>
				<td>{{ $activity->order }}</td>
				<td>{{ $activity->title }}</td>
				<td>&nbsp;</td>
				<td>
					<div class="btn-group">
						<a class="btn btn-secondary" href="{{ route('admin.activities.edit', $activity->id) }}"><i class="fa fa-eye"></i></a>
						<a class="btn btn-danger" href="#"><i class="fa fa-ban"></i></a>
					</div>
				</td>
			</tr>
		@endforeach
	</table>

@endsection