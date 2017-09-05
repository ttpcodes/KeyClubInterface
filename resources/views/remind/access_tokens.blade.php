@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Generate Access Token</div>
                <div class="panel-body">
                    @isset ($status)
                        <div class="alert alert-success" style="word-wrap: break-word;">
                            Token generated successfully! Token is <strong>{{$data['token']}}</strong>
                        </div>
                    @endisset
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('remind.access_tokens.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="settings" value="true">
                        <text-input label="Email" name="email" required
                            value="{{ old('email') }}"
                            @if ($errors->has('email'))
                                error="{{$errors->first('email')}}"
                            @endif></text-input>
                        <password-input label="Password" name="password"></password-input>
                        <submit-button btn-style="btn-success" label="Generate"></submit-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
