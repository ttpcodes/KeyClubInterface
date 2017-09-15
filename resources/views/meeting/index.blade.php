@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Meetings</div>
                <div class="panel-body">
                    <table id="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Date</th>
                                <th style="width: 75%;">Information</th>
                                <th style="width: 5%;">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr>
                                    <td>{{$meeting->date_time}}</td>
                                    <td>{{$meeting->information}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown">
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('meetings.show', $meeting->id) }}">View Details</a></li>
                                                <li><a href="{{ route('meetings.edit', $meeting->id) }}">Edit</a></li>
                                            </ul>
                                        </div>
                                    </td>
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
    $(document).ready(() => {
        $('#table').DataTable();
    });
</script>
@endsection
