@extends('auth.layout')

@section('main_content')
  <h4 class="mb-2">Welcome to {{ config('app.name') }}! 👋</h4>
  <p class="mb-4">Please sign-in to your account and start the adventure</p>

  <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="email" name="email"
        placeholder="Enter your email or username" required autofocus autocomplete="email" tabindex="0" />
      @error('name')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="mb-3 form-password-toggle">
      <div class="d-flex justify-content-between align-items-center">
        <label class="form-label" for="password">{{ __('Password') }}</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="btn btn-link btn-xs" tabindex="2">
            <small>{{ __('Forgot your password?') }}</small>
          </a>
        @endif
      </div>
      <div class="input-group input-group-merge" tabindex="1">
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
          aria-describedby="password" required autocomplete="current-password" />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
      </div>
      @error('password')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
        <label class="form-check-label" for="remember-me"> {{ __('Remember me') }} </label>
      </div>
    </div>
    <div class="mb-3">
      <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Log in') }}</button>
    </div>
  </form>

  <p class="text-center">
    <span>New on our platform?</span>
    <a href="{{ route('register') }}">
      <span>Create an account</span>
    </a>
  </p>
@endsection
