@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Members</div>
                <div class="panel-body">
                    <table id="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 45%;">First Name</th>
                                <th style="width: 45%;">Last Name</th>
                                <th style="width: 5%;">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>{{$member->id}}</td>
                                    <td>{{$member->first}}</td>
                                    <td>{{$member->last}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown">
                                            </span>
                                            <ul class="dropdown-menu">
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
