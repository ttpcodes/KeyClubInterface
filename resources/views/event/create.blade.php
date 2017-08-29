@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Create Event</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('events.store')}}">
                        {{ csrf_field() }}
                        <text-input label="Event Name" name="name" value="{{ old('name') }}" required></text-input>
                        <date-input label="Date" name="date" value="{{ old('date') }}" required></date-input>
                        <time-input label="Start Time" name="start" value="{{ old('start') }}" required></time-input>
                        <time-input label="End Time" name="end" value="{{ old('end') }}" required></time-input>
                        <text-input label="Hours" name="hours" value="{{ old('hours') }}" required></text-input>

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
                        <submit-button btn-style="btn-success" label="Create"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
