@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Workspace Details</h4>

    <div class="mb-5">
      {{-- Cover Image --}}
      <div class="mb-4 workspace-cover-wrapper">
        <button type="button" data-bs-toggle="modal" data-bs-target="#coverModal" class="btn edit-btn btn-sm btn-icon btn-secondary">
          <span class="tf-icons bx bx-edit-alt"></span>
        </button>
        <img class="img-fluid rounded-3 workspace-cover-img"
          src="https://images.unsplash.com/photo-1554774853-b3d587d95440?q=80&w=1949&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt="workspace cover">
      </div>
      {{-- End Cover Image --}}

      <div class="card">
        <div class="card-body">
          {{-- Workspace Details --}}
          <div class="card border-0 shadow-none mb-4 workspace-card">
            <div class="d-flex g-0">
              <div class="overflow-hidden rounded-3 workspace-card-img">
                <img class="card-img " src="{{ asset('sneat/assets/img/elements/12.jpg') }}" alt="Card image" />
              </div>
              <div class="card-body d-flex align-items-center">
                <div>
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
                <button type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                  class="ms-auto btn btn-outline-primary">
                  <span class="tf-icons bx bx-edit-alt"></span>&nbsp; Edit
                </button>
              </div>
            </div>
          </div>
          {{-- End Workspace Details --}}

          {{-- Tabs --}}
          <div class="nav-align-top mb-4 workspace-tabs">
            <ul class="nav nav-tabs nav-fill" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link shadow-none active" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                  <i class="tf-icons bx bx-columns"></i> Projects
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link shadow-none" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                  <i class='tf-icons bx bxs-user-detail'></i> Members
                </button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link shadow-none" role="tab" data-bs-toggle="tab"
                  data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                  <i class='tf-icons bx bx-check-shield'></i> Permissions
                </button>
              </li>
            </ul>
            <div class="tab-content shadow-none ps-0 pe-0">
              {{-- Projects --}}
              <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <div class="list-group list-group-flush">
                  <a href="#" class="list-group-item d-flex align-items-center list-group-item-action">
                    <i class="bx bx-tv me-2"></i>
                    Soufflé pastry pie ice
                    <span class="text-muted fw-light ms-auto">last edited 54 minutes ago</span>
                  </a>
                  <a href="#" class="list-group-item d-flex align-items-center list-group-item-action">
                    <i class="bx bx-bell me-2"></i>
                    Bear claw cake biscuit
                    <span class="text-muted fw-light ms-auto">last edited 54 minutes ago</span>
                  </a>
                  <a href="#" class="list-group-item d-flex align-items-center list-group-item-action">
                    <i class="bx bx-support me-2"></i>
                    Tart tiramisu cake
                    <span class="text-muted fw-light ms-auto">last edited 54 minutes ago</span>
                  </a>
                  <a href="#" class="list-group-item d-flex align-items-center list-group-item-action">
                    <i class="bx bx-purchase-tag-alt me-2"></i>
                    Bonbon toffee muffin
                    <span class="text-muted fw-light ms-auto">last edited 54 minutes ago</span>
                  </a>
                  <a href="#" class="list-group-item d-flex align-items-center list-group-item-action">
                    <i class="bx bx-closet me-2"></i>
                    Dragée tootsie roll
                    <span class="text-muted fw-light ms-auto">last edited 54 minutes ago</span>
                  </a>
                </div>
              </div>
              {{-- End Projects --}}

              {{-- Members --}}
              <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                @for ($i = 0; $i < 4; $i++)
                  <div class="d-flex mb-3 border-bottom">
                    <div class="flex-shrink-0">
                      <img src="{{ asset('sneat/assets/img/icons/brands/google.png') }}" alt="google" class="me-3"
                        height="30" />
                    </div>
                    <div class="flex-grow-1 row">
                      <div class="col-9 mb-sm-0 mb-2">
                        <h6 class="mb-0">Google</h6>
                        <small class="text-muted">Calendar and contacts</small>
                      </div>
                      <div class="col-3 text-end">
                        <div class="form-check form-switch">
                          <input class="form-check-input float-end" type="checkbox" role="switch" />
                        </div>
                      </div>
                    </div>
                  </div>
                @endfor
              </div>
              {{-- End Members --}}

              {{-- Permissions --}}
              <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                <p class="mb-0">
                  Comming soon
                </p>
              </div>
              {{-- End Permissions --}}
            </div>
          </div>
          {{-- End Tabs --}}
        </div>
      </div>

    </div>

  </div>

  {{-- Edit Modal --}}
  <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Edit Workspace</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBackdrop" class="form-label">Name</label>
              <input type="text" id="nameBackdrop" class="form-control" placeholder="Enter Name" />
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="formFile" class="form-label">Image</label>
              <input class="form-control" type="file" id="formFile" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
  {{-- End Edit Modal --}}

  {{-- Edit Modal --}}
  <div class="modal fade" id="coverModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Edit Cover</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label for="formFile" class="form-label">Cover Image</label>
              <input class="form-control" type="file" id="formFile" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
  {{-- End Edit Modal --}}
@endsection


@section('page-scripts')
  <script src="{{ asset('sneat/assets/js/form-basic-inputs.js') }}"></script>
@endsection
