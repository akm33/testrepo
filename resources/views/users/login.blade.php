@extends('layouts.app') 
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/') }}">Back</a>
      </div>
    </div>
    <div class="col-lg-6 mx-auto content">
      <div class="card card-default input-form">
        <div class="card-header text-center">Login</div>
        <div class="card-body">
          {{ Form::open(array('url' => '/login','method'=>'POST')) }}
          <div class="form-horizontal col-md-9 mx-auto">
            @if (session()->has('error'))
            <div class="alert alert-danger text-center" role="alert">
              {{ session()->get('error') }}
            </div>
            @endif 
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="control-label">E-Mail Address</label>
              {{ Form::email('email', null, array('class' => 'form-control', 'autofocus')) }} 
              @if ($errors->has('email'))
              <span class="form-text">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="control-label">Password</label>
              {{ Form::password('password', array('class' => 'form-control')) }} 
              @if ($errors->has('password'))
              <span class="form-text">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember" {{ old( 'remember') ? 'checked' : '' }}> Remember Me
                </label>
              </div>
            </div>
            <div class="form-group">
              <a href="{{ url('/user/password/reset') }}">Forgot Your Password?</a>
            </div>
            <div class="form-group col-md-12 text-center">
              <button type="submit " class="btn btn-primary">Login</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection