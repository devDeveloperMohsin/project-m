@extends('layouts.app')

@section('page-content')
  {{-- @dd(Auth::user()->getMedia()); --}}
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settingNotifications') }}"><i class="bx bx-bell me-1"></i>
              Notifications</a>
          </li>
        </ul>

        {{-- Profile Details --}}
        <div class="card mb-4">
          <h5 class="card-header">{{ __('Profile Information') }}</h5>
          <div class="card-body">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
              @csrf
            </form>
            <p>
              {{ __("Update your account's profile information and email address.") }}
            </p>

            @if (session('status') === 'profile-updated')
              <div class="alert alert-success alert-dismissible" role="alert">
                Your profile information has been updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
              enctype="multipart/form-data">
              @csrf
              @method('patch')
              <div class="row">
                <div class="col-md-6 col-lg-7">
                  <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                      name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus
                      autocomplete="name" />
                    @error('name')
                      <div class="form-text text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                      name="email" value="{{ old('email', Auth::user()->email) }}" required autofocus
                      autocomplete="email" />
                    @error('email')
                      <div class="form-text text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

                  @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mb-3">
                      <div class="d-flex align-items-center gap-2">
                        <p class="text-danger m-0">
                          {{ __('Your email address is unverified.') }}
                        </p>
                        <button form="send-verification" class="btn btn-outline-primary btn-sm">
                          {{ __('Click here to re-send the verification email.') }}
                        </button>
                      </div>

                      @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success alert-dismissible" role="alert">
                          {{ __('A new verification link has been sent to your email address.') }}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                    </div>
                  @endif
                </div>
                <div class="col-md-6 col-lg-5">
                  <div class="d-flex align-items-start align-items-sm-center gap-4">
                    {{-- <img src="{{ asset('sneat/assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block rounded"
                    height="100" width="100" id="uploadedAvatar" /> --}}
                    <img
                      src="{{ !empty(Auth::user()->getFirstMediaUrl()) ? Auth::user()->getFirstMediaUrl('default', 'preview') : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                      alt="user-avatar" class="d-block rounded" style="object-fit: cover" height="100" width="100"
                      id="uploadedAvatar" />
                    <div class="button-wrapper">
                      <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" class="account-file-input" hidden
                          accept="image/png, image/jpeg" name="profile" />
                      </label>
                      <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                        <i class="bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                      </button>

                      <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                      @error('profile')
                        <div class="form-text text-danger">
                          {{ $message }}
                        </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
              </div>
            </form>
          </div>
        </div>
        {{-- End Profile Details --}}

        {{-- Change Password --}}
        <div class="card mb-4">
          <h5 class="card-header">{{ __('Update Password') }}</h5>
          <div class="card-body">
            <p>
              {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>

            @if (session('status') === 'password-updated')
              <div class="alert alert-success alert-dismissible" role="alert">
                Your password has been updated
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
              @csrf
              @method('put')

              <div class="row">
                <div class="mb-3 col-md-12">
                  <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                  <input class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    type="password" id="update_password_current_password" name="current_password"
                    autocomplete="current-password" />
                  @error('current_password', 'updatePassword')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                  <input class="form-control @error('password', 'updatePassword') is-invalid @enderror" type="password"
                    id="update_password_password" name="password" autocomplete="new-password" />
                  @error('password', 'updatePassword')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="update_password_password_confirmation"
                    class="form-label">{{ __('Confirm Password') }}</label>
                  <input class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                    type="password" id="update_password_password_confirmation" name="password_confirmation"
                    autocomplete="new-password" />
                  @error('password_confirmation', 'updatePassword')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">{{ __('Save') }}</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
        {{-- End Change Password --}}

        {{-- Delete Account --}}
        <div class="card">
          <h5 class="card-header">{{ __('Delete Account') }}</h5>
          <div class="card-body">
            <div class="mb-3 col-12 mb-0">
              <div class="alert alert-danger">
                <p class="mb-0">
                  {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
              </div>
            </div>
            <form id="formAccountDeactivation" onsubmit="return false">

              <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#accountDeletionModal">
                {{ __('Delete Account') }}
              </button>
            </form>
          </div>
        </div>
        {{-- End Delete Account --}}
      </div>
    </div>
  </div>

  {{-- Delete Account Modal --}}
  <div class="modal fade" id="accountDeletionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">{{ __('Are you sure you want to delete your account?') }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
          @csrf
          @method('delete')
          <div class="modal-body">
            <p>
              {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>
            <div class="mb-3">
              <label for="account_deletion_pwd" class="form-label">{{ __('Password') }}</label>
              <input type="password" id="account_deletion_pwd" name="password"
                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                placeholder="{{ __('Password') }}" />
              @error('password', 'userDeletion')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="confirmDeletion" id="confirmDeletion" />
                <label class="form-check-label" for="confirmDeletion">I confirm my account deletion</label>
              </div>
              @error('confirmDeletion', 'userDeletion')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ __('Cancel') }}
            </button>
            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End Delete Account Modal --}}
@endsection

@section('page-scripts')
  <script src="{{ asset('sneat/assets/js/pages-account-settings-account.js') }}"></script>>

  <script>
    $(document).ready(function() {
      // Toogle Account Deletion Modal on error
      @error('password', 'userDeletion')
        $('#accountDeletionModal').modal('show')
      @enderror
      // End Toogle Account Deletion Modal on error
    });
  </script>
@endsection
