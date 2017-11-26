@extends('layouts.app')

@section('content')
<h1>Inschrijven G.O.K. 2018</h1>
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p>Vragen over het inschrijven? Neem contact op via <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje op <a target="_blank" href="http://m.me/scoutingrveer">Facebook</a>.</p>

@include('layouts.errors')

<form method="POST" action="{{ route('participants.store', $enrollment->slug) }}">
    {{ csrf_field() }}
    @for($i = 1; $i <= $n; $i++)
    
        <fieldset>
            <legend>Deelnemer {{ $i }}</legend>
            <div class="form-group row">
                <label for="name_{{ $i }}" class="col-sm-3 col-form-label">Naam:</label>
                <div class="col-sm-9">
                    <input type="text" id="name_{{ $i }}" name="participants[{{ $i }}][name]" class="form-control" value="{{ old('participants.'.$i.'.name') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="bd_{{ $i }}" class="col-sm-3 col-form-label">Geboortedatum:</label>
                <div class="col-sm-9">
                    <input type="text" placeholder="dd-mm-jjjj" id="bd_{{ $i }}" name="participants[{{ $i }}][birthday]" class="form-control"  value="{{ old('participants.'.$i.'.birthday') }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="diet_{{ $i }}" class="col-sm-3 col-form-label">Dieet:</label>
                <div class="col-sm-9">
                    <input type="text" id="diet_{{ $i }}" name="participants[{{ $i }}][diet]" class="form-control" value="{{ old('participants.'.$i.'.diet') }}">
                    <small class="text-muted">Leeg laten indien geen dieet. Bijv.: glutenvrij, vegetarisch, etc.</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Opties:</label>
                <div class="col-sm-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="cp" value="{{ $i }}" type="radio" {{{ ($n == 1 ? 'checked' : '') }}}> Deze deelnemer is contactpersoon
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="participants[{{ $i }}][member]"  type="checkbox" {{{ ($n == 1 ? 'checked' : '') }}}> Deze deelnemer is lid van Scouting Raamsdonskveer
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>

    @endfor
    
    <fieldset>
        <div class="form-group row">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-success">Ga verder &gt;</button>
            </div>
        </div>
    </fieldset>
</form>
@endsection
