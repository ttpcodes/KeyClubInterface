@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Event List</div>
                <div class="panel-body">
                    <table id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Hours</th>
                                <th>Officer</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{$event->id}}</td>
                                    <td>{{$event->name}}</td>
                                    <td>{{$event->date}}</td>
                                    <td>{{$event->start}}</td>
                                    <td>{{$event->end}}</td>
                                    <td>{{$event->hours}}</td>
                                    <td>{{$event->officer_id}}</td>
                                    <td><a class="btn btn-primary" href=" {{ route('events.edit', $event->id) }}">Manage</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@endsection
