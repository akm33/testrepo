@extends('layouts.app')
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/') }}"> Back</a>
      </div>
    </div>
    <div class="col-md-10 mx-auto align-middle content">
      <div class="card card-default">
        <div class="card-header text-center"><strong>{{ $news->title }}</strong></div>
        <div class="card-body mx-auto">
          <p>{{ $news->message }}</p>
        </div>
        <div class="card-footer">
          <small>{{ Carbon\Carbon::parse($news->date)->diffForHumans() }}</small>
            @if(Auth::check())
            <div class="float-right">
              <a class="edit-btn" href="{{ url('/news/edit',$news->id) }}">
                <i class="far fa-edit"></i>
              </a>
              <a href="#" class="delete-btn" data-news-id="n-{{ $news->id }}" data-toggle="modal" data-target="#deleteConfirmBox">
                <i class="far fa-trash-alt"></i>
              </a>
            </div>
            @endif
        </div>
      </div>
    </div>
    <!-- Confirm delete Modal -->
    <div class="modal fade" id="deleteConfirmBox" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmBoxTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteConfirmBoxTitle">Confirm Delete?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{ Form::open(['method' => 'DELETE','url' => ['/news/delete/1'],'id' => 'news-delete-form']) }}
            <button type="submit" class="btn btn-primary">Confirm</button>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
