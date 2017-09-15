@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Meeting</div>
                <div class="panel-content">
                    <p><strong>Note:</strong> The JSON input should only be used when meeting upload has malfunctioned.</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('meetings.update', $meeting->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <text-area label="Meeting JSON" name="meeting_json"></text-area>

                        <date-time label="Date & Time" name="date_time" value="{{ $meeting->date_time }}"></date-time>
                        <text-area label="Information" name="information" value="{{ $meeting->information }}"></text-area>

                        <!-- <data-list-input datalist="memberlist"></data-list-input>

                        <datalist id="memberlist">
                        @foreach ($members as $member)
                            <option value="{{$member->id}}">{{ $member->first . ' ' . $member->last }}</option>
                        @endforeach
                        </datalist> -->

                        <submit-button btn-style="btn-primary" label="Update"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
