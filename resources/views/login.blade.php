@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Inschrijving bekijken</h3>

    @include('layouts.errors')

    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
            <label for="slug" class="col-sm-4 control-label">Nummer inschrijving:</label>

            <div class="col-sm-8">
                <div class="input-group">
                  <span class="input-group-addon">#GOK</span>
                  <input type="text" class="form-control" placeholder="12345" name="slug" id="slug" required>
                </div>

                @if ($errors->has('slug'))
                    <span class="help-block">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-sm-4 control-label">E-mail contactpersoon:</label>

            <div class="col-sm-8">
                <input id="email" type="email" class="form-control" name="email" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
