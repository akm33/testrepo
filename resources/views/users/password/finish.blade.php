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
  <div class="row content">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body mx-auto">
          <span class="col-md-12 text-center">
            {{ $msg }}
          </span>
          <br/>
          <div class="col-md-12 text-center login-btn">
            <a href="{{ url('/login') }}" class="btn btn-primary">Log In</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection