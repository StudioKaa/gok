@extends('layouts.admin')

@section('content')
	
	<h2>Uitnodigingen voor opgeven keuze-activiteiten</h2>
	
	<p>Let op: het versturen kan een paar minuten duren!</p>

    <form method="POST" action="{{ route('admin.activities.invite_send') }}">
       {{ csrf_field() }}
	   <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Stuur uitnodiging naar <em>alle</em> {{ $count_invite }} inschrijvingen.</button>
    </form>

    <form class="mt-3" method="POST" action="{{ route('admin.activities.invite_remind') }}">
       {{ csrf_field() }}
	   <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Stuur herinnering naar {{ $count_remind }} inschrijvingen.</button>
    </form>

@endsection