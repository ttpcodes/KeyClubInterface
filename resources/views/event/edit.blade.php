@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Event</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('events.update', $event->id)}}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <text-input label="Event Name" name="name" value="{{ old('name') . $event->name }}" required></text-input>
                        <date-input label="Date" name="date" value="{{ old('date') . $event->date }}" required></date-input>
                        <time-input label="Start Time" name="start" value="{{ old('start') . $event->start }}" required></time-input>
                        <time-input label="End Time" name="end" value="{{ old('end') . $event->end }}" required></time-input>
                        <text-input label="Hours" name="hours" value="{{ old('hours') . $event->hours }}" required></text-input>

                        <div class="form-group{{ $errors->has('officer_id') ? ' has-error' : '' }}">
                            <label for="officer_id" class="col-md-4 control-label">Officer</label>

                            <div class="col-md-6">
                                <select class="form-control" name="officer_id" required>
                                    <option disabled selected>Select Officer</option>
                                    @foreach($officers as $officer)
                                        <option value="{{ $officer->id }}">{{ $officer->member->first . " " . $officer->member->last }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('officer_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('officer_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <data-list-input datalist="memberlist"></data-list-input>

                        <!-- <div class="form-group{{ $errors->has('members') ? ' has-error' : '' }}">
                            <label for="members" class="col-md-4 control-label">Event Members</label>

                            <div class="col-md-6">
                                <input name="members[]" type="text" list="memberlist"> -->
                                <datalist id="memberlist">
                                @foreach ($members as $member)
                                    <option value="{{$member->id}}">{{ $member->first . ' ' . $member->last }}</option>
                                @endforeach
                                </datalist>
                            <!-- </div>
                        </div> -->
                        <submit-button btn-style="btn-primary" label="Update"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
