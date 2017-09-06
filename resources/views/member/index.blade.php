@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Members</div>
                <div class="panel-body">
                    @switch (Session::get('type'))
                        @case ('delete')
                            <div class="alert alert-success">
                                User deleted successfully!
                            </div>
                            @break
                        @case ('self')
                            <div class="alert alert-danger">
                                You cannot delete yourself from the member list.
                            </div>
                            @break
                    @endswitch

                    @isset($status)
                        <div class="alert alert-success">
                            User added successfully! <a href="{{ route('members.create') }}" class="alert-link">Add another?</a>
                        </div>
                    @endisset

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
                                                <li><a href="{{ route('members.show', $member->id) }}">View Member</a></li>
                                                @auth
                                                <li><a href="{{ route('members.edit', $member->id) }}">Edit Member</a></li>
                                                <li>
                                                    <a href="{{ route('remind.classes.invitations.store') }}"
                                                        onclick="event.preventDefault();
                                                                 document.getElementById('memberID').value='{{$member->id}}';
                                                                 document.getElementById('classID').value=prompt('Class ID');
                                                                 document.getElementById('invite-form').submit();">
                                                        Send Remind Invite
                                                    </a>

                                                    <form id="invite-form" action="{{ route('remind.classes.invitations.store') }}"
                                                        method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                        <text-input name="memberID"></text-input>
                                                        <text-input name="classID"></text-input>
                                                    </form>
                                                </li>
                                                <li>
                                                    <a onclick="event.preventDefault();
                                                                document.getElementById('delete-form').action =
                                                                document.getElementById('delete-link').href =
                                                                '{{ route('members.destroy', $member->id) }}';"
                                                        data-toggle="modal" data-target="#deleteModal" style="cursor: pointer;">
                                                        Delete Member
                                                    </a>
                                                </li>
                                                @endauth
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
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Are you <strong>sure</strong> you want to delete this user?</p>
                    <form id="delete-form" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <a href="{{ route('members.create') }}" id="delete-link" class="btn btn-danger"
                        onclick="event.preventDefault();
                                document.getElementById('delete-form').submit();">
                        Delete Member
                    </a>
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
