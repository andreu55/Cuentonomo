@extends('layouts.app')

@section('title', 'Login')

@section('content')

  <div class="container">
    <div class="col-md-6 offset-md-3">
      <form class="form-horizontal" method="post" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email">Email address</label>
          <input id="email" type="email" class="form-control" name="email" aria-describedby="emailHelp" value="{{ old('email') }}" placeholder="Enter email" required autofocus>
          @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @else
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
          <label for="password">Password</label>
          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
          @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>
        <div class="custom-control custom-checkbox mt-3 mb-3">
          <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="custom-control-label" for="remember">Recuérdame!</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a class="btn btn-link" href="{{ url('register') }}">
          Register
        </a>
        <a class="btn btn-link" href="{{ route('password.request') }}">
          Forgot Your Password?
        </a>
      </div>
    </form>
  </div>

@endsection
