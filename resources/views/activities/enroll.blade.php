@extends('layouts.app')

@section('content')
<h1>Aanmelden keuze-activiteiten</h1>
<p>Heb je vragen over het aanmelden? Stuur een berichtje op <a target="_blank" href="http://m.me/scoutingrveer">Facebook</a> of via <a href="mailto:gok@scoutingrveer.nl">gok@scoutingrveer.nl</a>.</p>

@include('layouts.errors')

<form method="POST" action="{{ route('activities.save') }}">

    {{ csrf_field() }}
    <input type="hidden" name="enrollment" value="{{ $enrollment->id }}">

    <fieldset>
        <legend>Aankomst</legend>
        <p>Eerst willen we graag weten of jullie op vrijdag of zaterdag denken aan te komen.</p>
        <div class="form-group row">
            <label for="arrival" class="col-sm-3 col-form-label">Wij komen op:</label>
            <div class="col-sm-9">
                <select name="arrival" id="arrival" class="form-control">
                    <option value="vrijdag">Vrijdag 19:00 - 22:00</option>
                    <option value="zaterdag">Zaterdag 09:00 - 11:00</option>
                    <option value="weetniet">Weet ik echt nog niet</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Keuze-activiteiten</legend>

        <p>Hieronder kun je jezelf en je gezin opgeven voor de keuze-activiteiten op zaterdagmiddag. Er zijn twee rondes van twee uur. Je kunt dus twee verschillende activiteiten doen. Daarnaast maak je nog een reserve-keuze.</p>

        <p>Hoewel we ons best doen om iedereen bij zijn/haar favoriete activiteit te plaatsen, kan het zijn dat je uiteindelijk een ander ticket krijgt. Je wordt wel altijd ingedeeld met dezelfde personen als je hieronder aangeeft.</p>
        
        <p>Hier vind je nog een keer alle activiteiten:</p>

        <ul>
            @foreach($activities as $activity)
                <li>
                    <strong><a data-toggle="collapse" href="#act_{{ $activity->id }}" aria-expanded="false" aria-controls="act_{{ $activity->id }}">{{ $activity->order }}. {{ $activity->title }}</a></strong>
                    <span id="act_{{ $activity->id }}" class="collapse">
                        <span class="text-muted">{{ $activity->age }} | {{ $activity->location_generic }} | {!! $activity->prettyPrice() !!} | {{ $activity->skills }}</span><br />
                        {{ $activity->description }}
                    </span>
                </li>
            @endforeach
        </ul>
    </fieldset>
    
    @if(count($adults) < 1)
        <fieldset>
        <legend>Opgeven</legend>
            <p><strong>In deze inschrijving werden geen volwassenen gevonden, je kunt je niet opgeven voor de keuze-activiteiten.</strong></p>
        </fieldset>
    @elseif(count($adults) == 1)
        <fieldset>
        <legend>Opgeven</legend>
            <p>In deze inschrijving werd &eacute;&eacute;n volwassene gevonden. Omdat deelnemers onder de 18 nooit alleen naar een activiteit mogen, kun je je alleen met heel je gezin voor dezelfde activiteiten opgeven.</p>
            
            @include('activities.list', ['participant' => $adults[0]])

            @foreach($kids as $kid)
                <input type="hidden" name="dep[{{ $kid->id }}]" value="{{ $adults[0]->id }}">
            @endforeach
        </fieldset>
        
    @else
        <fieldset>
            <legend>Opgeven</legend>
            <ul>
                <li>Jullie kunnen met heel je gezin opgeven voor dezelfde activiteit, maar je kunt ook opsplitsen.</li>
                <li>Deelnemers onder de 18 moeten onder begeleiding van een volwassene naar een activiteit.</li>
                <li>Eerst geven alle volwassenen hun voorkeuren op, daarna kun je per kind aangeven met welke volwassene zij mee zullen gaan.</li>
            </ul>
        </fieldset>

        @foreach($adults as $key => $participant)
            <fieldset>
                <legend>{{ $participant->name }}</legend>
                @if($key != 0)
                    <input type="checkbox" id="dep_{{ $participant->id }}" name="dep[{{ $participant->id }}]" value="{{ $adults[0]->id }}">
                    <label style="display: inline;" for="dep_{{ $participant->id }}">Ik wil hetzelfde doen als {{ $adults[0]->name }}, negeer mijn voorkeuren.</label>
                    <script type="text/javascript">
                        $('#dep_{{ $participant->id }}').change(function(){
                           if (this.checked == true){
                              $('#pref_{{ $participant->id }}').prop('disabled', true);
                           }
                           else{
                             $('#pref_{{ $participant->id }}').prop('disabled', false);
                           }
                        });
                    </script>
                @endif
                
                <fieldset id="pref_{{ $participant->id }}">
                    @include('activities.list', ['participant' => $participant])
                </fieldset>
            </fieldset>
        @endforeach

        @foreach($kids as $participant)
            <fieldset>
                <legend>{{ $participant->name }}</legend>
                <div class="form-group row">
                    <label for="dep_{{ $participant->id }}" class="col-sm-3 col-form-label">Gaat mee met:</label>
                    <div class="col-sm-9">
                        <select name="dep[{{ $participant->id }}]" id="dep_{{ $participant->id }}" class="form-control">
                            @foreach($adults as $adult)
                                <option value="{{ $adult->id }}">{{ $adult->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>
        @endforeach
    @endif
            
    <div class="form-group row">
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success">Ga verder &gt;</button>
        </div>
    </div>
</form>
@endsection
