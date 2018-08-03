@extends('layouts.app') 
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/') }}">Back</a>
      </div>
    </div>
  </div>
  {{ Form::open(array('url' => '/user/password/new','method'=>'POST')) }}
  <div class="row content">
    <div class="col-md-6 mx-auto">
      @if (isset($error))
      <div class="alert alert-danger text-center" role="alert">{{ $error }}</div>
      @else
      <div class="card input-form">
        <div class="card-header text-center">Enter New Password</div>
        <div class="card-body col-md-8 mx-auto">
          <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <label for="password" class="control-label">New Password</label>
              {{ Form::password('password', array('class' => 'form-control')) }} 
            @if (isset($token)) 
              {{ Form::hidden('token', $token) }}
            @endif 
            @if ($errors->has('password'))
            <span class="form-text">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
  {{ Form::close() }}
</div>
@endsection