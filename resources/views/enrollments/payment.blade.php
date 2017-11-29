@extends('layouts.app')

@section('content')
<h1>Inschrijven G.O.K. 2018</h1>
<div class="progress">
  <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p>Vragen over het inschrijven? Neem contact op via <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a> of stuur een berichtje op <a target="_blank" href="http://m.me/scoutingrveer">Facebook</a>.</p>

@include('layouts.errors')

<table class="table">
    @foreach($payment['lines'] as $line)
    <tr>
        <td>{{ $line['name'] }}</td>
        <td>&euro;{{ $line['price'] }},-</td>
    </tr>
    @endforeach
    <tr class="bg-light">
        <td><strong>Totaal</strong></td>
        <td><strong>&euro;{{ $payment['total'] }},-</strong></td>
    </tr>
</table>

<form method="POST" action="/enrollments/{{ $enrollment->slug }}/payment">
    {{ csrf_field() }}
    <fieldset>
        <legend>Betaalwijze</legend>
        <div class="form-group row">
            <label for="terms" class="col-sm-3 col-form-label">Termijnen:</label>
            <div class="col-sm-9">
                <select name="terms" id="terms" class="form-control">
                    <option value="1">Ik betaal in &eacute;&eacute;n keer (uiterlijk 1 februari, &euro;0,20 transactiekosten)</option>
                    <option value="2">Ik betaal in twee termijnen (uiterlijk 1 februari / 1 mei, &euro;0,40 transactiekosten)</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="method" class="col-sm-3 col-form-label">Methode:</label>
            <div class="col-sm-9">
                <select name="method" id="method" class="form-control">
                    <option value="ideal">Ik betaal met iDEAL</option>
                    <option value="bank">Ik maak het geld zelf over</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-success">Afronden &gt;</button>
            </div>
        </div>
    </fieldset>
</form>

@endsection
