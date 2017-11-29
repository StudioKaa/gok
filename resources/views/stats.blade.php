@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <h2>{{ count($participants) }}</h2>
        <p>Deelnemers</p>
    </div>
    <div class="col-lg-6">
        <h2>{{ count($enrollments) }}</h2>
        <p>Inschrijvingen</p>
    </div>
</div>

<div id="pop_div"></div>
@areachart('inschrijvingen', 'pop_div')

@endsection
