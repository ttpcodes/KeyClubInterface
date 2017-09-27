@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Meetings Table</div>
                <div class="panel-body">
                    <table id="table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Member</th>
                                @foreach($meetings as $meeting)
                                <th style="width: {{90 / $meetings->count()}}%;">{{$meeting->date_time}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                               <tr>
                                    <td>{{ $member->first . ' ' . $member->last }}</td>
                                    @foreach($meetings as $meeting)
                                        @if($member->meetings()->find($meeting->id))
                                            <td>X</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endforeach
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
        $('#table').DataTable({
            fixedHeader: true
        });
    });
</script>
@endsection
