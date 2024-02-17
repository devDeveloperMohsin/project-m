<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <div class="nav-item d-flex align-items-center">
        <i class="bx bx-search fs-4 lh-0"></i>
        <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
          aria-label="Search..." />
      </div>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Place this tag where you want the button to render. -->
      {{-- <li class="nav-item lh-1 me-3">
        <a class="github-button" href=""
          data-icon="octicon-star" data-size="large" data-show-count="true"
          aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Notifications</a>
      </li> --}}



      <!-- Notification -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow btn btn-simple" href="javascript:void(0);"
          data-bs-toggle="dropdown">
          <i class="bx bx-bell bx-sm bx-tada"></i>
          <span class="badge rounded-pill bg-primary">5</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li class="border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
              <p class="fs-6 mb-0 me-auto">Notifications</p>
              <a href="javascript:void(0)" class="text-muted" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a>
            </div>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <i class="bx bx-notification me-2"></i>
              <span class="align-middle">Mohsin assigned you task</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);">
              <i class="bx bx-notification me-2"></i>
              <span class="align-middle">Ticket has been updated</span>
            </a>
          </li>

          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('settingNotifications') }}">
              <i class="bx bx-bell me-2"></i>
              <span class="align-middle">View All Notifications</span>
            </a>
          </li>
        </ul>
      </li>
      <!--/ End Notification -->

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            {{-- <img src="{{ asset('sneat/assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" /> --}}
            <img
              src="{{ !empty(Auth::user()->getFirstMediaUrl()) ? Auth::user()->getFirstMediaUrl('default', 'preview') : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
              alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    {{-- <img src="{{ asset('sneat/assets/img/avatars/1.png') }}" alt
                      class="w-px-40 h-auto rounded-circle" /> --}}
                    <img
                      src="{{ !empty(Auth::user()->getFirstMediaUrl()) ? Auth::user()->getFirstMediaUrl('default', 'preview') : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                      alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block text-capitalize">{{ Auth::user()->name }}</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('settingNotifications') }}">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item">
                <i class="bx bx-power-off me-2"></i>
                <span class="align-middle">Log Out</span>
              </button>
            </form>

          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>
