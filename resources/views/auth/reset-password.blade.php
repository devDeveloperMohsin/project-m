@extends('auth.layout')

@section('main_content')
  <h4 class="mb-2">Reset Password 🔒</h4>
  <p class="mb-4">Fill the following form to reset your password</p>

  <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
        value="{{ old('email', $request->email) }}" placeholder="Enter your email" required autocomplete="email" />
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
        <input type="password" id="password_confirmation"
          class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
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

    <button class="btn btn-primary d-grid w-100">{{ __('Reset Password') }}</button>
  </form>
@endsection
