@extends('app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Register
                    </div>
                    <div class="panel-body">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong>There were some problems with your input.<br/><br/>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{url('/webauth/register')}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">User Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username" value="{{old('username')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Account</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="account" value="{{old('account')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection