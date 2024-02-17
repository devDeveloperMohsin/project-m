@extends('auth.layout')

@section('main_content')
  <h4 class="mb-2">Adventure starts here 🚀</h4>
  <p class="mb-4">Make your task management easy and fun!</p>

  <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}"
        placeholder="Enter your full name" required autofocus autocomplete="name" />

      @error('name')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}"
        placeholder="Enter your email" required autocomplete="email" />
      @error('email')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="mb-3 form-password-toggle">
      <label class="form-label" for="password">{{ __('Password') }}</label>
      <div class="input-group input-group-merge">
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
          aria-describedby="password" required autocomplete="password" />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
      </div>
      @error('password')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="mb-3 form-password-toggle">
      <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
      <div class="input-group input-group-merge">
        <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
          aria-describedby="confirm-password" required autocomplete="new-password" />
        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
      </div>
      @error('password_confirmation')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>

    <button class="btn btn-primary d-grid w-100">{{ __('Register') }}</button>
  </form>

  <p class="text-center">
    <span>{{ __('Already registered?') }}</span>
    <a href="{{ route('login') }}">
      <span>{{ __('Sign in instead') }}</span>
    </a>
  </p>
@endsection
