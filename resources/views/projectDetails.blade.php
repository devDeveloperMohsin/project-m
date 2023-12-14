@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Project Header --}}
    <div class="d-flex pt-3">
      {{-- Project Details  --}}
      <div>
        <div class="d-flex mb-2">
          <h4 class="fw-bol m-0 me-2">PixelProject</h4>
          <button type="button" class=" me-1 btn btn-icon btn-sm btn-simple">
            <span class="tf-icons bx bx-info-circle"></span>
          </button>
          <button type="button" class="btn btn-icon btn-sm btn-simple">
            <span class="tf-icons bx bxs-star"></span>
          </button>
        </div>
        <p class="text-truncate" style="max-width: 500px; width: 100%">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perspiciatis impedit, libero quae saepe iure deleniti
          voluptatum aliquid fugit blanditiis sit perferendis architecto veniam est qui! Dolorum dolor distinctio aliquam
          vitae.
        </p>
      </div>
      {{-- End Project Detials --}}

      {{-- Project Actions --}}
      <div style="min-width: 150px" class="ms-auto">
        {{-- Invite Button --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd"
          aria-controls="offcanvasEnd">
          <span class="tf-icons bx bx-user-plus"></span>&nbsp; Invite
        </button>
        {{-- End Invite Button --}}

        {{-- Dropdown --}}
        <div class="btn-group">
          <button type="button" class="btn btn-outline-primary btn-icon dropdown-toggle hide-arrow"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-info-circle"></span> Details</a>
            </li>
            <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-edit-alt"></span> Edit</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-user-plus"></span> Invite</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-user-check"></span> Permissions</a>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item text-danger" href="javascript:void(0);">
                <span class="bx bx-trash"></span> Delete
              </a></li>
          </ul>
        </div>
        {{-- End Dropdown --}}
      </div>
      {{-- End Project Actions --}}
    </div>
    {{-- End Project Header --}}

    {{-- Invite Member offcanvas --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
      <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title">
          <span class="bx bx-user-plus mt-n1"></span>
          Invite Member
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0">

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Email address</label>
          <div class="input-group">
            <span class="input-group-text" id="basic-addon11">
              <span class="bx bx-envelope"></span>
            </span>
            <input type="text" class="form-control" placeholder="Enter Email" aria-label="Enter Email"
              aria-describedby="basic-addon11">
          </div>
        </div>

        <div class="d-grid gap-2">
          <button type="button" class="btn btn-primary">
            <span class="tf-icons bx bx-paper-plane"></span>&nbsp; Send Invite
          </button>

          <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
            Cancel
          </button>
        </div>        
      </div>
    </div>
    {{-- End Invite Member offcanvas --}}

    <hr>

    <div class="mb-5" id="project-board"></div>

  </div>
@endsection
