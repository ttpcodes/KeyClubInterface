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
                                                <li>
                                                    <a href="{{ route('remind.classes.invitations.store') }}"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('memberID').value='{{$member->id}}';
                                                                 document.getElementById('classID').value=prompt('Class ID');
                                                                 document.getElementById('invite-form').submit();">
                                                        Send Remind Invite
                                                    </a>

                                                    <form id="invite-form" action="{{ route('remind.classes.invitations.store') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        <text-input name="memberID"></text-input>
                                                        <text-input name="classID"></text-input>
                                                    </form>
                                                </li>
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
