@extends('layouts.app')

@section('title', 'Register')

@section('content')

  <div class="container">
    <div class="col-6 offset-md-3">
      <form class="form-horizontal" method="post" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
          <label for="name">Nombre</label>
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
          @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email">Nombre</label>
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
          <label for="password">Password</label>
          <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>
          @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group">
          <label for="password-confirm">Confirm Password</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Register</button>
        <a class="btn btn-link" href="{{ url('login') }}">
          Login
        </a>
      </div>
    </form>
  </div>

@endsection
