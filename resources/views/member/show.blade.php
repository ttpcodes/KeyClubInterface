@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Member Information for {{ $member->first }} {{ $member->last }}</div>
                <div class="panel-body">
                    <p><strong>Name: </strong>{{$member->first}} {{$member->last}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
