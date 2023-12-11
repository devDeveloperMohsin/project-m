@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Workspaces</h4>

    <div class="row mb-5">
      @for ($i = 0; $i < 5; $i++)
        <div class="col-md-6 col-xxl-4">

          <a href="{{ route('workspaces.details') }}" class="card mb-3 workspace-card">
            <div class="d-flex g-0">
              <div class="overflow-hidden rounded-3 workspace-card-img">
                <img class="card-img " src="{{ asset('sneat/assets/img/elements/12.jpg') }}"
                  alt="Card image" />
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </a>

        </div>

        <div class="col-md-6 col-xxl-4">

          <a href="#" class="card mb-3 workspace-card">
            <div class="d-flex g-0">
              <div class="overflow-hidden rounded-3 workspace-card-img">
                <div class="workspace-card-img-bg d-flex justify-content-center align-items-center fs-4 fw-bold text-white">M</div>
              </div>
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              </div>
            </div>
          </a>

        </div>
      @endfor

    </div>

  </div>
@endsection
