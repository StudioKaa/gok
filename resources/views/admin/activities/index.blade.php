@extends('layouts.admin')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')
	
	<form action="{{ route('admin.activities.delete') }}" method="POST">
		{{ method_field('DELETE') }}
		{{ csrf_field() }}
		<div class="btn-group mb-2">
			<button type="submit" class="btn btn-danger">
				<i class="fa fa-trash"></i> Verwijderen
			</button>
			<a class="btn btn-success" href="{{ route('admin.activities.create') }}">
				<i class="fa fa-plus"></i> Nieuw
			</a>
		</div>
		

		<table class="table table-striped table-hover" id="check-table">
			<tr>
				<th>&nbsp;</th>
				<th>#</th>
				<th>Titel</th>
				<th>Aantal x voorkeur</th>
				<th>Acties</th>
			</tr>

			@foreach($activities as $activity)
				<tr>
					<td><input type="checkbox" name="delete[]" value="{{ $activity->id }}"></td>
					<td>{{ $activity->order }}</td>
					<td>{{ $activity->title }}</td>
					<td>&nbsp;</td>
					<td>
						<a class="btn btn-primary" href="{{ route('admin.activities.edit', $activity->id) }}"><i class="fa fa-pencil"></i></a>
					</td>
				</tr>
			@endforeach
		</table>
	</form>

@endsection