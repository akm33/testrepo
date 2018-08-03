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
  {{ Form::open(array('url' => '/user/password/reset','method'=>'POST')) }}
  <div class="row content">
    <div class="col-md-6 mx-auto">
      <div class="card input-form">
        <div class="card-header text-center">Reset Password</div>
        <div class="card-body col-md-8 mx-auto">
          @if (session()->has('error'))
          <div class="alert alert-danger text-center" role="alert">
            {{ session()->get('error') }}
          </div>
          @endif
          <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <label for="email" class="control-label">Email</label>
            {{ Form::email('email', null, array('class' => 'form-control')) }} 
            @if ($errors->has('email'))
              <span class="form-text">
                <strong>{{ $errors->first('email') }}</strong>
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