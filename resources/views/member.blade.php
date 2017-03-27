@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Good evening {{ $first . " " . $last }}</h1>
    <div class="row">
        <div class="col-md-4">
            <h2>{{ $first . " " . $last }}</h2>
        </div>
        <div class="col-md-8">
            <h2>Recent News</h2>
            <p></p>
        </div>
    </div>
</div>
@endsection
