@extends('layouts.app')
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/profile') }}">Back</a>
      </div>
    </div>
    <div class="col-lg-6 mx-auto content">
      <div class="card card-default input-form">
        <div class="card-header text-center">Edit Profile</div>
        <div class="card-body">
          {{ Form::open(array('url' => '/user/update','method'=>'POST')) }}
          <div class="form-horizontal col-md-9 mx-auto">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="control-label">Name</label>
              {{ Form::text('name', $user->name , array('class' => 'form-control', 'autofocus')) }}
              @if ($errors->has('name'))
              <span class="form-text">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="control-label">Email</label>
              {{ Form::email('email', $user->email, array('class' => 'form-control')) }}
              @if ($errors->has('email'))
              <span class="form-text">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
              <div class="form-check form-check-inline">
                {{ Form::radio('gender', 'm', ($user->gender == 'm') ? ' 1' : '', ['class' => 'form-check-input', 'id' => 'gender-male']) }}
                <label for="gender-male" class="form-check-label">Male</label>
              </div>
              <div class="form-check form-check-inline">
                {{ Form::radio('gender', 'f', ($user->gender == 'f') ? ' 1' : '', ['class' => 'form-check-input', 'id' => 'gender-female']) }}
                <label for="gender-female" class="form-check-label">Female</label>
              </div>
              @if ($errors->has('address'))
              <span class="form-text">
                <strong>{{ $errors->first('address') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              <label for="address" class="control-label">Address</label>
              {{ Form::text('address', $user->address, array('class' => 'form-control')) }}
              @if ($errors->has('address'))
              <span class="form-text">
                <strong>{{ $errors->first('address') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group col-md-12 text-center">
              <button type="submit " class="btn btn-primary">Update</button>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
