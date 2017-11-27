@extends('layouts.app')

@section('content')
<h1>Inschrijven G.O.K. 2018</h1>
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p>Vragen over het inschrijven? Neem contact op via <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje op <a target="_blank" href="http://m.me/scoutingrveer">Facebook</a>.</p>

@include('layouts.errors')

<form method="POST" action="/enrollments">
    {{ csrf_field() }}
    <fieldset>
        <legend>Kampeermiddel</legend>
        <ul>
            <li>U kunt ook aangeven dat u een tent wilt <strong>huren</strong>. U krijgt dan altijd een tent voor uw gezin alleen. Deze tent is in principe niet opgezet bij aankomst. Het huren van een tent kost &euro;15,-.</li>
            <li><strong>Staf en explorers</strong>: wil je gebruik maken van de gratis gezamenlijke tent? Geef aan dat je met je eigen tent komt, inventarisatie volgt later.</li>
        </ul>
        <div class="form-group row">
            <label for="equipment" class="col-sm-3 col-form-label">Wij komen met een:</label>
            <div class="col-sm-9">
                <select name="equipment" id="equipment" class="form-control">
                    <option value="caravan">Caravan</option>
                    <option value="vouwwagen">Vouwwagen</option>
                    <option value="camper">Camper</option>
                    <option value="tent">Eigen tent</option>
                    <option value="hire">Tent huren (kosten &euro;15,-) </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="equipment_size" class="col-sm-3 col-form-label">Lengte of grootte:</label>
            <div class="col-sm-9">
                <input type="text" name="equipment_size" id="equipment_size" class="form-control">
                <small class="form-text text-muted">Voor caravans, vouwwagens of campers: lengte van dissel tot achterzijde.</small>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Deelnemers</legend>
        <div class="form-group row">
            <label for="participants" class="col-sm-3 col-form-label">Wij komen met:</label>
            <div class="col-sm-9">
                <select name="participants" id="participants" class="form-control">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }} deelnemer{{ ($i > 1 ? 's': '') }}</option>
                    @endfor
                </select>
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
