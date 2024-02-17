@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Workspaces</h4>

    <div class="row mb-5">
      <div class="col-md-6 col-xxl-4">
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createWorkspaceModal"
          class="card mb-3 create-workspace-card">
          <div class="rounded text-primary text-center">
            <i class="bx bx-plus me-2"></i>
            Add Workspace
          </div>
        </a>
      </div>

      @foreach ($workspaces as $workspace)
        <div class="col-md-6 col-xxl-4">

          <a href="{{ route('workspaces.show', $workspace->id) }}" class="card mb-3 workspace-card">
            <div class="d-flex g-0">
              <div class="overflow-hidden rounded-3 workspace-card-img">
                @if (!empty($workspace->getFirstMediaUrl('icon')))
                  <img class="card-img "
                    src="{{ $workspace->getFirstMediaUrl('icon', 'icon') }}"
                    alt="Card image" />
                @else
                  <div
                    class="workspace-card-img-bg text-uppercase d-flex justify-content-center align-items-center fs-4 fw-bold text-white">
                    {{ Str::of($workspace->name)->limit(1, '') }}
                  </div>
                @endif
              </div>
              <div class="card-body">
                <h5 class="card-title text-truncate">{{ Str::of($workspace->name)->limit(20) }}</h5>
                <p class="card-text"><small class="text-muted">Last updated:
                    {{ $workspace->updated_at->diffForHumans() }}</small></p>
              </div>
            </div>
          </a>

        </div>
      @endforeach

    </div>

  </div>

  {{-- Create Workspace Modal --}}
  <div class="modal fade" id="createWorkspaceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create workspace</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('workspaces.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="workspace-name" class="form-label">Name</label>
              <input type="text" name="name" value="{{ old('name') }}" id="workspace-name"
                class="form-control @error('name', 'workspace') is-invalid @enderror" placeholder="Enter Name" required />
              @error('name', 'workspace')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="workspace-icon" class="form-label">Workspace Icon</label>
              <input class="form-control @error('icon', 'workspace') is-invalid @enderror" name="icon" type="file"
                id="workspace-icon" />
              <p class="form-text mb-0">Allowed JPG, GIF or PNG. Max size of 5mb (Max Dimensions: 500x500 px)</p>
              @error('icon', 'workspace')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Cover Image</label>
              <input class="form-control @error('cover', 'workspace') is-invalid @enderror" name="cover" type="file"
                id="formFile" />
              <p class="form-text mb-0">Allowed JPG, GIF or PNG. Max size of 5mb (Max Dimensions: 4250x886 px)</p>
              @error('cover', 'workspace')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- End Create Workspace Modal --}}
@endsection

@section('page-scripts')
  <script>
    $(document).ready(function() {
      // Toogle Workspace creation Modal on error
      @error('name', 'workspace')
        $('#createWorkspaceModal').modal('show')
      @enderror
      // End Toogle Workspace creation Modal on error
    });
  </script>
@endsection
