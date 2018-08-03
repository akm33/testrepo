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
  {{ Form::model($news, ['method' => 'PATCH','url' => ['/news/update', $news->id]]) }}
  <div class="row content">
    <div class="col-md-6 mx-auto">
      <div class="card input-form">
        <div class="card-header text-center">Edit News</div>
        <div class="card-body col-md-11 mx-auto">
          <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="control-label">Title</label>
            {{ Form::text('title', $news->title, array('placeholder' => 'Title','class' => 'form-control')) }} 
            @if ($errors->has('title'))
            <span class="form-text">
              <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <label for="message" class="control-label">Message</label>
            {{ Form::textarea('message', $news->message, array('placeholder' => 'Message','class' => 'form-control','size' => '50x10')) }} 
            @if ($errors->has('message'))
            <span class="form-text">
              <strong>{{ $errors->first('message') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-check">
            {{ Form::checkbox('public_flag', '1', $news->public_flag, ['class'=>'form-check-input', 'id' =>'pub_flag_check' ]) }}
            <label class="form-check-label" for="pub_flag_check">
              Show on public?
            </label>
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection