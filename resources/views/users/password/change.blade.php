@extends('layouts.app')
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/profile') }}">Back</a>
      </div>
    </div>
  </div>
  {{ Form::open(array('url' => '/user/password/change','method'=>'POST')) }}
  <div class="row content">
    <div class="col-md-6 mx-auto">
      <div class="card input-form">
        <div class="card-header text-center">Change Password</div>
        <div class="card-body col-md-8 mx-auto">
          @if (session()->has('error'))
          <div class="alert alert-danger text-center" role="alert">
            {{ session()->get('error') }}
          </div>
          @endif
          <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <label for="title" class="control-label">Old Password</label>
            {{ Form::password('oldPassword', array('class' => 'form-control')) }}
            @if ($errors->has('oldPassword'))
            <span class="form-text">
              <strong>{{ $errors->first('oldPassword') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="newPassword" class="control-label">New Password</label>
            {{ Form::password('newPassword', array('class' => 'form-control')) }}
            @if($errors->has('newPassword'))
            <span class="form-text">
              <strong>{{ $errors->first('newPassword') }}</strong>
            </span>
            @endif
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}
</div>
@endsection
