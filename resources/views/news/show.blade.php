@extends('layouts.app')
@section('content')
@include('layouts.nav')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <h2 class="float-left">Bulletin Board</h2>
      <div class="float-right">
        @if(Auth::check())
        <a class="btn btn-primary" href="{{ url('/news/create') }}">Add News</a>
        @endif
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card-columns">
        @foreach ($news as $single_news)
        <div class="card news-card {{ (!$single_news->public_flag) ? 'not-public-news' : '' }}">
          <a href="{{ url('/news/view',$single_news->id) }}">
            <div class="card-header">
              <span class="card-title">
                <strong>{{ $single_news->title }}</strong>
              </span>
            </div>
            <div class="card-body">
              <p class="card-text">{{ mb_strimwidth($single_news->message, 0, 200, ' [...]') }}</p>
            </div>
          </a>
          <div class="card-footer">
            <small class="text-muted">{{ Carbon\Carbon::parse($single_news->date)->diffForHumans() }}</small>
            @if(Auth::check())
            <span class="float-right">
              <a class="edit-btn" href="{{ url('/news/edit',$single_news->id) }}">
                <i class="far fa-edit"></i>
              </a>
              <a href="#" class="delete-btn" data-news-id="n-{{ $single_news->id }}" data-toggle="modal" data-target="#deleteConfirmBox">
                <i class="far fa-trash-alt"></i>
              </a>
            </span>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      <nav class="page-navigation text-center">
        {{ $news->render() }}
      </nav>
      <!-- Delete Confrim Modal -->
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
</div>
@endSection
