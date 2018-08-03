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
        <div class="card-header text-center">Create New Account</div>
        <div class="card-body">
          @if (session()->has('error'))
          <div class="alert alert-danger text-center" role="alert">
            {{ session()->get('error') }}
          </div>
          @endif
          {{ Form::open(array('url' => '/user/create','method'=>'POST')) }}
          <div class="form-horizontal col-md-9 mx-auto">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="control-label">Name</label>
              {{ Form::text('name', null, array('class' => 'form-control', 'autofocus')) }} 
              @if ($errors->has('name'))
              <span class="form-text">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="control-label">Email</label>
              {{ Form::email('email', null, array('class' => 'form-control', 'required')) }} 
              @if ($errors->has('email'))
              <span class="form-text">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="control-label">Password</label>
              {{ Form::password('password', array('class' => 'form-control', 'autofocus')) }} 
              @if ($errors->has('password'))
              <span class="form-text">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
              <div class="form-check form-check-inline">
                {{ Form::radio('gender', 'm', 1, ['class' => 'form-check-input', 'id' => 'gender-male']) }}
                <label for="gender-male" class="form-check-label">Male</label>
              </div>
              <div class="form-check form-check-inline">
                {{ Form::radio('gender', 'f', false, ['class' => 'form-check-input', 'id' => 'gender-female']) }}
                <label for="gender-female" class="form-check-label">Female</label>
              </div>
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              <label for="address" class="control-label">Address</label>
              {{ Form::text('address', null, array('class' => 'form-control')) }} 
              @if ($errors->has('address'))
              <span class="form-text">
                <strong>{{ $errors->first('address') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group col-md-12 text-center">
              <button type="submit " class="btn btn-primary">Register</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection