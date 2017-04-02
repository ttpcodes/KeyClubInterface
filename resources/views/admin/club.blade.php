@extends('layouts.app')

@section('navbar')
<li class="active"><a href="#">Home</a></li>
<li><a href="/officer/events">Event Management</a></li>
<li><a href="#">Officer Management</a></li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    My Tasks
                </div>
                <div class="panel-body">
                    Welcome to the officer panel!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
