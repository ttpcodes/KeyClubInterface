@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Manage Event</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="/officer/events/manage/{{ $id }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                        <label for="id" class="col-md-4 control-label">Event ID</label>

                        <div class="col-md-6">
                            <input id="id" type="number" class="form-control" name="id" value="{{ $id }}" readonly>

                            @if ($errors->has('id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Event Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $event->name }}" required autofocus>

                            @if ($errors->has('id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Date</label>

                        <div class="col-md-6">
                            <input id="date" type="date" class="form-control" name="password" value="{{ $event->date }}" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="start" class="col-md-4 control-label">Start Time</label>

                        <div class="col-md-6">
                            <input id="start" type="time" class="form-control" name="password" value="{{ $event->start }}" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="end" class="col-md-4 control-label">End Time</label>

                        <div class="col-md-6">
                            <input id="end" type="time" class="form-control" name="password" value="{{ $event->end }}" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="hours" class="col-md-4 control-label">Hours</label>

                        <div class="col-md-6">
                            <input id="hours" type="number" class="form-control" name="hours" value="{{ $event->hours }}" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Officer</label>

                        <div class="col-md-6">
                            <select class="form-control">
                                <option disabled selected value>Select Officer</option>
                                @foreach($officers as $officer)
                                    <option value="{{ $officer->id }}">{{ $officer->member->first . " " . $officer->member->last }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
