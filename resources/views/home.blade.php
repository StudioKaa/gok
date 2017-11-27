@extends('layouts.app')

@section('content')
<div class="jumbotron">
  <h1><img src="{{ asset('img/logo.png') }}" alt="Gezin op Kamp"></h1>
  <p><a class="btn btn-lg btn-success" href="/enrollments/create" role="button">Schrijf je nu in</a></p>
</div>

<div class="row marketing">
  <div class="col-lg-6">
    <h4>Datum</h4>
    <p>Gezin op Kamp vindt plaats in het weekend van 1, 2 en 3 juni 2018.</p>

    <h4>Subheading</h4>
    <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

    <h4>Subheading</h4>
    <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
  </div>

  <div class="col-lg-6">
    <h4>Subheading</h4>
    <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

    <h4>Subheading</h4>
    <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

    <h4>Subheading</h4>
    <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
  </div>
</div>
@endsection
