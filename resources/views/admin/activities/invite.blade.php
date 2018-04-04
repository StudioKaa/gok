@extends('layouts.admin')

@section('content')
	
	<h2>Uitnodigingen voor opgeven keuze-activiteiten</h2>
	
	<p>Je gaat <strong>{{ $count }}</strong> mails versturen met een uitnodiging om voorkeuren door te geven voor de keuze-activiteiten. Dit kan een paar minuten duren!</p>

    <form method="POST" action="{{ route('admin.activities.invite_send') }}">
       {{ csrf_field() }}
	   <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Verstuur uitnodigingen</button>
    </form>

@endsection