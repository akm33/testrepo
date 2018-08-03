@extends('layouts.app')
@section('content')
<div class="container main-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ url('/') }}"> Back</a>
      </div>
    </div>
    <div class="col-md-6 mx-auto align-middle content">
      <div class="card card-default">
        <div class="card-header text-center">User Profile</div>
        <div class="card-body col-md-10 mx-auto">
          @if (session()->has('msg'))
          <div id="alert-success" class="alert alert-success text-center" role="alert">
            {{ session()->get('msg') }}
          </div>
          @endif
          <div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                  <span class="mb-2">Name : </span>
                  <span>{{ $user->name }}</span>
                </div>
              </li>
              <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                  <span class="mb-2">Email : </span>
                  <span>{{ $user->email }}</span>
                </div>
              </li>
              <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                  <span class="mb-2">Gender : </span>
                  @if($user->gender == 'm')
                  <span>Male</span>
                  @else
                  <span>Female</span>
                  @endif
                </div>
              </li>
              <li class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                  <span class="mb-2">Address : </span>
                  <span>{{ $user->address }}</span>
                </div>
              </li>
            </ul>
          </div>
          <div class="profile-btns">
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmBox">Deactivate</a>
            <a href="{{ url('/user/edit') }}" class="btn btn-light float-right edit-profile-btn">Edit Profile</a>
            <a href="{{ url('/user/password/change') }}" class="btn btn-light float-right">Change Password</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirm Modal Box -->
  <div class="modal fade" id="deleteConfirmBox" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmBoxTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmBoxTitle">Confirm Deactivate?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{ Form::open(['method' => 'DELETE','url' => ['/user/deactivate'],'id' => 'user-delete-form']) }}
          <button type="submit" class="btn btn-primary">Confirm</button>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
