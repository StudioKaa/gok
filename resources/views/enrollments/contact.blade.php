@extends('layouts.app')

@section('content')
<h1>Inschrijven G.O.K. 2018</h1>
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p>Vragen over het inschrijven? Neem contact op via <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje op <a target="_blank" href="http://m.me/scoutingrveer">Facebook</a>.</p>

@include('layouts.errors')

<form method="POST" action="/enrollments/{{ $enrollment->slug }}/contact">
    {{ csrf_field() }}
    <fieldset>
        <legend>Contactpersoon</legend>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Naam:</label>
            <div class="col-sm-9">
                <input name="cp_name" readonly class="form-control-plaintext" value="{{ $enrollment->cp()->name }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="cp_email" class="col-sm-3 col-form-label">E-mailadres:</label>
            <div class="col-sm-9">
                <input type="email" name="cp_email" id="cp_email" class="form-control" placeholder="ik@gmail.com" value="{{ old('cp_email') }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="cp_phone" class="col-sm-3 col-form-label">06-nummer:</label>
            <div class="col-sm-9">
                <input type="tel" name="cp_phone" id="cp_phone" class="form-control" placeholder="0612345678" value="{{ old('cp_phone') }}">
                <small class="text-muted">Telefoonnummer waarop contactpersoon ook tijdens het weekend bereikbaar is.</small>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Adres</legend>
        <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label">(Familie)naam:</label>
            <div class="col-sm-9">
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $address->title) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="street" class="col-sm-3 col-form-label">Straat + huisnr:</label>
            <div class="col-sm-9">
                <input type="text" name="street" id="street" class="form-control" value="{{ old('street', $address->street) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="postal_code" class="col-sm-3 col-form-label">Postcode:</label>
            <div class="col-sm-9">
                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code', $address->postal_code) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="city" class="col-sm-3 col-form-label">Plaats:</label>
            <div class="col-sm-9">
                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $address->city) }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-success">Ga verder &gt;</button>
            </div>
        </div>
    </fieldset>
</form>
@endsection
