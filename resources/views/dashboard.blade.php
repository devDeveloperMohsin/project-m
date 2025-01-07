@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2">Tasks</h5>
              <small class="text-muted">Status of Tasks</small>
            </div>
          </div>
          <div class="card-body">

            <ul class="p-0 m-0 mt-4">
              <li class="d-flex mb-4 pb-1">

                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info">
                      <i class="bx bx-task"></i>
                    </span>
                </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">To Do</h6>
                    <small class="text-muted">Task Need to be Done</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">10</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">

                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-time"></i></span>
                  </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">In Progress</h6>
                    <small class="text-muted">Task under developement</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">5</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">

                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-success">
                      <i class="bx bx-check-circle"></i>
                    </span>
                  </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Done</h6>
                    <small class="text-muted">Completed Tasked</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">30</small>
                  </div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-success">
                      <i class="bx bx-task"></i>
                    </span>
                  </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Ready For Deployment</h6>
                    <small class="text-muted">All Requirements Meet</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">10</small>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--/ Order Statistics -->

        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100">
            <div class="card-header">
                <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income"
                    aria-selected="true">
                    Income
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab">Expenses</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab">Profit</button>
                </li>
                </ul>
            </div>
            <div class="card-body px-0">
                <div class="tab-content p-0">
                <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                    <div class="d-flex p-4 pt-3">
                    <div class="avatar flex-shrink-0 me-3">
                        <img src="{{ asset('sneat/assets/img/icons/unicons/wallet.png') }}" alt="User" />
                    </div>
                    <div>
                        <small class="text-muted d-block">Total Balance</small>
                        <div class="d-flex align-items-center">
                        <h6 class="mb-0 me-1">$459.10</h6>
                        <small class="text-success fw-semibold">
                            <i class="bx bx-chevron-up"></i>
                            42.9%
                        </small>
                        </div>
                    </div>
                    </div>
                    <div id="incomeChart"></div>
                    <div class="d-flex justify-content-center pt-4 gap-2">
                    <div class="flex-shrink-0">
                        <div id="expensesOfWeek"></div>
                    </div>
                    <div>
                        <p class="mb-n1 mt-1">Expenses This Week</p>
                        <small class="text-muted">$39 less than last week</small>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!--/ Expense Overview -->

      {{-- ---------------- Number of workspace / Number of Task / Number of Users --------------- --}}




      {{-- ---------------- Number of workspace  --------------- --}}

      <div class="col-md-6 col-lg-4 col-xl-4 order-2 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between pb-0">
            <div class="card-title mb-0">
              <h5 class="m-0 me-2 text-center">NEXL Tech! Performa </h5>
              <small class="text-muted">We Prefer UI/UX with optimized Functionality</small>
            </div>
          </div>

                {{-- ---------------- end Number of workspace  --------------- --}}


          <div class="card-body">

            <ul class="p-0 m-0 mt-4">
              <li class="d-flex mb-4 pb-1">

                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary">
                      <i class="bx bx-briefcase"></i>
                    </span>
                </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Workspace</h6>
                    {{-- <small class="text-muted">Mobile, Earbuds, TV</small> --}}
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">10</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info">
                      <i class="bx bx-task"></i>
                    </span>
                </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Tasks</h6>
                    {{-- <small class="text-muted">T-shirt, Jeans, Shoes</small> --}}
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">30</small>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info">
                      <i class="bx bx-group"></i> <!-- Group of users icon -->
                    </span>
                  </div>

                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Users</h6>
                    {{-- <small class="text-muted">Fine Art, Dining</small> --}}
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">30</small>
                  </div>
                </div>
              </li>
              {{-- <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-football"></i></span>
                </div>
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">Sports</h6>
                    <small class="text-muted">Football, Cricket Kit</small>
                  </div>
                  <div class="user-progress">
                    <small class="fw-semibold">99</small>
                  </div>
                </div>
              </li> --}}
            </ul>
          </div>
        </div>
      </div>


      {{-- ---------------- end of USERS Card    --------------- --}}






    </div>

    {{-- Notifications --}}
    <div class="card">
      <h5 class="card-header">Notifications</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Details</th>
              <th>Read/Unread</th>
              <th></th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <tr>
              <td>
                <i class="bx bxl-angular bx-sm text-danger me-3"></i>
                <span class="fw-medium">Angular Project</span>
              </td>
              <td><span class="badge bg-label-primary me-1">Active</span></td>
              <td>
                <form action="">
                  <button type="button" class="btn btn-icon btn-outline-danger">
                    <span class="bx bx-trash"></span>
                  </button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    {{-- End Notifications --}}
  </div>
@endsection

@section('page-styles')
  <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
@endsection

@section('page-scripts')
  <script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>
@endsection
