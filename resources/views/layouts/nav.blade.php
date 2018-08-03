<nav class="navbar navbar-light">
  <div class="container justify-content-end">
    @if(!Auth::check())
    <div class="">
      <a class="btn btn-outline-primary" href="{{ url('/login')}}">Log in</a>
      <a class="btn btn-outline-primary register-btn" href="{{ url('/register')}}">Register</a>
    </div>
    @else
    <div class="dropdown">
      <a class="nav-link dropdown-toggle user-icon" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <i class="fas fa-user-circle fa-lg"></i>
        <span class="username">{{ Auth::user()->name }}</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ url('/profile')}}">Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ url('/logout') }}" href="{{ url('/logout') }}">Log out</a>
      </div>
    </div>
    @endif
  </div>
</nav>