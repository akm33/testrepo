@extends('layouts.app')
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/') }}"> Back</a>
      </div>
    </div>
  </div>
  {{ Form::open(array('url' => '/news/create','method'=>'POST')) }}
  <div class="row content">
    <div class="col-md-6 mx-auto">
      <div class="card input-form">
        <div class="card-header text-center">Create News</div>
        <div class="card-body">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="control-label">Title</label>
            {{ Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) }}
            @if ($errors->has('title'))
            <span class="form-text">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="message" class="control-label">Message</label>
            {{ Form::textarea('message', null, array('placeholder' => 'Message','class' => 'form-control','size' => '50x10')) }}
            @if($errors->has('message'))
            <span class="form-text">
              <strong>{{ $errors->first('message') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-check">
            {{ Form::checkbox('public_flag', 1, null, ['class'=>'form-check-input', 'id' =>'pub_flag_check', 'checked']) }}
            <label class="form-check-label" for="pub_flag_check">
              Show on public?
            </label>
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
