@extends('layouts.admin')

@section('content')
	
	<h2><?php echo $activity->exists ? 'Activiteit aanpassen' : 'Nieuwe activiteit'; ?></h2>
	
	@include('layouts.errors')

    @if($activity->exists)
	<form method="POST" action="{{ route('admin.activities.update', $activity->id) }}" enctype="multipart/form-data">
	    {{ csrf_field() }}
        {{ method_field('PATCH') }}
    @else
    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
    @endif

		<div class="form-group row">
            <label for="order" class="col-sm-3 col-form-label">Nummer *:</label>
            <div class="col-sm-9">
                <input type="text" name="order" id="order" class="form-control" value="{{ old('order', $activity->order) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label">Titel *:</label>
            <div class="col-sm-9">
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $activity->title) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="duration" class="col-sm-3 col-form-label">Duur *:</label>
            <div class="col-sm-9">
                <select name="duration" id="duration" class="form-control">
                    <option value="1" <?php echo old('duration', $activity->duration) == 1 ? 'selected' : ''; ?>>1 ronde / 2 uur</option>
                    <option value="2" <?php echo old('duration', $activity->duration) == 2 ? 'selected' : ''; ?>>2 rondes / 4 uur</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="price" class="col-sm-3 col-form-label">Prijs:</label>
            <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-addon">&euro;</span>
                  <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $activity->price) }}">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="age" class="col-sm-3 col-form-label">Leeftijd *:</label>
            <div class="col-sm-9">
                <input type="text" name="age" id="age" class="form-control" value="{{ old('age', $activity->age) }}">
                <small class="form-text text-muted">Vrije invoer.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="skills" class="col-sm-3 col-form-label">Vaardigheden:</label>
            <div class="col-sm-9">
                <input type="text" name="skills" id="skills" class="form-control" value="{{ old('skills', $activity->skills) }}">
                <small class="form-text text-muted">Vrije invoer.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="particulars" class="col-sm-3 col-form-label">Bijzonderheden:</label>
            <div class="col-sm-9">
                <input type="text" name="particulars" id="particulars" class="form-control" value="{{ old('particulars', $activity->particulars) }}">
                <small class="form-text text-muted">Vrije invoer.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="location_generic" class="col-sm-3 col-form-label">Locatie algemeen *:</label>
            <div class="col-sm-9">
                <input type="text" name="location_generic" id="location_generic" class="form-control" value="{{ old('location_generic', $activity->location_generic) }}">
                <small class="form-text text-muted">Voor in het activiteitenboekkje.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="location_specific" class="col-sm-3 col-form-label">Locatie specifiek:</label>
            <div class="col-sm-9">
                <input type="text" name="location_specific" id="location_specific" class="form-control" value="{{ old('location_specific', $activity->location_specific) }}">
                <small class="form-text text-muted">Voor op het ticket.</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label">
                @if($activity->exists)
                    Afbeelding:
                @else
                    Afbeelding *:
                @endif
            </label>
            <div class="col-sm-9">
                <input type="file" name="image" id="image" class="form-control-file">
                @if($activity->exists)
                    <small class="form-text text-muted">Vervangt eventueel de huidige afbeelding bij deze activiteit.</small>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">Beschrijving *:</label>
            <div class="col-sm-9">
                <textarea rows="6" name="description" id="description" class="form-control">{{ old('description', $activity->description) }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
            </div>
        </div>
    </form>

@endsection