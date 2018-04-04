@if($participant->activity_preference)
    <p><strong>Let op:</strong> voor deze deelnemer is al een voorkeur opgeslagen. Je gaat deze voorkeur nu overschrijven.</p>
@endif

<div class="form-group row">
    <label for="pref_{{ $participant->id }}_1" class="col-sm-3 col-form-label">Voorkeur ronde 1:</label>
    <div class="col-sm-9">
        <select name="pref[{{ $participant->id }}][1]" id="pref_{{ $participant->id }}_1" class="form-control">
            <option selected="selected" value="0"> - kies - </option>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}">{{ $activity->order }}. {{ $activity->title }}</option>
            @endforeach
            <option value="0">Ik wil deze ronde niets doen</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="pref_{{ $participant->id }}_2" class="col-sm-3 col-form-label">Voorkeur ronde 2:</label>
    <div class="col-sm-9">
        <select name="pref[{{ $participant->id }}][2]" id="pref_{{ $participant->id }}_2" class="form-control">
            <option selected="selected" value="0"> - kies - </option>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}">{{ $activity->order }}. {{ $activity->title }}</option>
            @endforeach
            <option value="0">Ik wil deze ronde niets doen</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="pref_{{ $participant->id }}_3" class="col-sm-3 col-form-label">Reserve-keuze:</label>
    <div class="col-sm-9">
        <select name="pref[{{ $participant->id }}][3]" id="pref_{{ $participant->id }}_3" class="form-control">
            <option selected="selected" value="0"> - kies - </option>
            @foreach($activities as $activity)
                <option value="{{ $activity->id }}">{{ $activity->order }}. {{ $activity->title }}</option>
            @endforeach
        </select>
    </div>
</div>