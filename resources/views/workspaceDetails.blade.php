@extends('layouts.app')

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Workspace Details</h4>

    <div class="mb-5">
      {{-- Cover Image --}}
      <div class="mb-4 workspace-cover-wrapper">
        @if ($workspace->userIsAdmin(Auth::id()))
          <button type="button" data-bs-toggle="modal" data-bs-target="#coverModal"
            class="btn edit-btn btn-sm btn-icon btn-secondary">
            <span class="tf-icons bx bx-edit-alt"></span>
          </button>
        @endif

        <img class="img-fluid rounded-3 workspace-cover-img"
          src="{{ !empty($workspace->getFirstMediaUrl('cover', 'cover')) ? $workspace->getFirstMediaUrl('cover', 'cover') : 'https://images.unsplash.com/photo-1554774853-b3d587d95440?q=80&w=1949&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' }}"
          alt="workspace cover">
      </div>
      {{-- End Cover Image --}}

      <div class="card">
        <div class="card-body">
          {{-- Workspace Details --}}
          <div class="card border-0 shadow-none mb-4 workspace-card">
            <div class="d-flex g-0">
              <div class="overflow-hidden rounded-3 workspace-card-img">
                @if (!empty($workspace->getFirstMediaUrl('icon')))
                  <img class="card-img " src="{{ $workspace->getFirstMediaUrl('icon', 'icon') }}" alt="Card image" />
                @else
                  <div
                    class="workspace-card-img-bg text-uppercase d-flex justify-content-center align-items-center fs-4 fw-bold text-white">
                    {{ Str::of($workspace->name)->limit(1, '') }}
                  </div>
                @endif
              </div>
              <div class="card-body d-flex align-items-center">
                <div>
                  <div class="d-flex align-items-center mb-1">
                    <h5 class="card-title mb-0">{{ $workspace->name }}</h5>
                    <form action="{{ route('workspaces.starToggle', $workspace->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-icon btn-sm btn-simple ms-2">
                        <span
                          class="tf-icons bx bxs-star {{ in_array($workspace->id, $markedWorkspaces->pluck('id')->toArray()) ? 'text-warning' : '' }}"></span>
                      </button>
                    </form>
                  </div>
                  <p class="card-text"><small class="text-muted">Last updated:
                      {{ $workspace->updated_at->diffForHumans() }}</small></p>
                </div>

                <div class="ms-auto">
                  @if ($workspace->userIsAdmin(Auth::id()))
                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal"
                      class="btn btn-outline-primary">
                      <span class="tf-icons bx bx-edit-alt"></span>&nbsp; Edit
                    </button>
                  @endif

                  {{-- Dropdown --}}
                  <div class="btn-group ms-2">
                    <button type="button" class="btn btn-outline-primary btn-icon dropdown-toggle hide-arrow"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                          data-bs-target="#projectModal"><span class="bx bx-info-circle"></span>
                          Add Project</a>
                      </li>

                      @if ($workspace->userIsAdmin(Auth::id()))
                        <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasEnd"><span class="bx bx-user-plus"></span>
                            Invite</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#editModal"><span class="bx bx-edit-alt"></span> Edit</a>
                        </li>

                        {{-- <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-user-check"></span>
                        Permissions</a>
                    </li> --}}
                        <li>
                          <hr class="dropdown-divider" />
                        </li>
                        <li>
                          <form action="{{ route('workspaces.delete', $workspace->id) }}" method="POSt">
                            @csrf
                            @method('DELETE')
                            <button class="dropdown-item text-danger">
                              <span class="bx bx-trash"></span> Delete
                            </button>
                        </li>
                      @endif
                      </form>

                    </ul>
                  </div>
                  {{-- End Dropdown --}}
                </div>

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
                  @forelse ($workspace->projects as $project)
                    <a href="{{ route('project.show', $project->id) }}"
                      class="list-group-item d-flex align-items-center list-group-item-action">
                      <i class="bx bx-purchase-tag-alt me-2"></i>
                      {{ $project->name }}
                      <span class="text-muted fw-light ms-auto">last edited:
                        {{ $project->updated_at->diffForHumans() }}</span>
                    </a>
                  @empty
                    <div class="alert alert-primary">
                      <strong><i class="bx bx-error-circle"></i> Info</strong> <br />
                      No project has been created in this workspace yet. Start <a href="#" data-bs-toggle="modal"
                        data-bs-target="#projectModal" class="text-decoration-underline">creating</a> one now!
                    </div>
                  @endforelse
                </div>
              </div>
              {{-- End Projects --}}

              {{-- Members --}}
              <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                @foreach ($workspace->users as $user)
                  <div class="d-flex mb-3 border-bottom">
                    <div class="flex-shrink-0  me-3">
                      <img
                        src="{{ !empty($user->getFirstMediaUrl()) ? $user->getFirstMediaUrl('default', 'preview') : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        alt="user-avatar" class="d-block rounded-circle" style="object-fit: cover" height="30"
                        width="30" />
                    </div>
                    <div class="flex-grow-1 row">
                      <div class="col-9 mb-sm-0 mb-2">
                        @php
                          $r = $workspace->roleMapping($user->pivot->role);
                        @endphp
                        <h6 class="mb-0">{{ $user->name }} <span
                            class="badge rounded-pill bg-label-{{ Str::lower($r) == 'admin' ? 'primary' : 'secondary' }}"
                            style="font-size:0.7rem;">{{ $r }}</span> </h6>
                        <small class="text-muted">{{ $user->email }}</small>
                      </div>
                      <div class="col-3 text-end">
                        @if ($user->pivot->role !== $workspace::ROLE_ADMIN && $workspace->userIsAdmin(Auth::id()))
                          <form
                            action="{{ route('workspaces.revokeAccess', ['id' => $workspace->id, 'userId' => $user->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                              data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="right"
                              data-bs-html="false" title="Remove {{ $user->name }} from workspacce">
                              <span class="tf-icons bx bx-trash"></span>
                            </button>
                          </form>
                        @endif

                      </div>
                    </div>
                  </div>
                @endforeach
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
  @if ($workspace->userIsAdmin(Auth::id()))
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('workspaces.update', $workspace->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Edit Workspace</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="workspace-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $workspace->name) }}" id="workspace-name"
                  class="form-control @error('name', 'workspace') is-invalid @enderror" placeholder="Enter Name"
                  required />
                @error('name', 'workspace')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="workspace-icon" class="form-label">Workspace Icon</label>
                <input class="form-control @error('icon', 'workspace') is-invalid @enderror" name="icon"
                  type="file" id="workspace-icon" />
                <p class="form-text mb-0">Allowed JPG, GIF or PNG. Max size of 5mb (Max Dimensions: 500x500 px)</p>
                @error('icon', 'workspace')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
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
  @endif
  {{-- End Edit Modal --}}

  {{-- Project Modal --}}
  <div class="modal fade" id="projectModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('project.store') }}" method="POST">
        @csrf
        <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
        <div class="modal-header">
          <h5 class="modal-title" id="backDropModalTitle">Create Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="project-name" class="form-label">Name</label>
              <input type="text" name="name" value="{{ old('name') }}" id="project-name"
                class="form-control @error('name', 'workspace') is-invalid @enderror" placeholder="Enter Name"
                required />
              @error('name', 'project')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="project-description" class="form-label">Description</label>
              <textarea name="description" id="project-description" rows="5"
                class="form-control @error('description', 'project') is-invalid @enderror" placeholder="Enter Description" required>{{ old('description') }}</textarea>
              @error('description', 'project')
                <div class="form-text text-danger">
                  {{ $message }}
                </div>
              @enderror
            </div>
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
  {{-- End Project Modal --}}

  {{-- Cover Modal --}}
  @if ($workspace->userIsAdmin(Auth::id()))
    <div class="modal fade" id="coverModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('workspaces.updateCover', $workspace->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Edit Cover</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <label for="formFile" class="form-label">Cover Image</label>
                <input class="form-control @error('cover', 'workspace') is-invalid @enderror" name="cover"
                  type="file" id="formFile" />
                <p class="form-text mb-0">Allowed JPG, GIF or PNG. Max size of 5mb (Max Dimensions: 4250x886 px)</p>
                @error('cover', 'workspace')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  @endif
  {{-- End Cover Modal --}}

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

      <form action="{{ route('invitations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="workspace">
        <input type="hidden" name="id" value="{{ $workspace->id }}">

        <div class="mb-3">
          <label for="invitation-email" class="form-label">Email address</label>
          <div class="input-group">
            <span class="input-group-text" id="invitation-addon">
              <span class="bx bx-envelope"></span>
            </span>
            <input type="email" name="email" value="{{ old('email') }}"
              class="form-control @error('email', 'invitation') is-invalid @enderror" placeholder="Enter Email"
              aria-label="Enter Email" aria-describedby="invitation-addon" required>
          </div>
          @error('email', 'invitation')
            <div class="form-text text-danger">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">
            <span class="tf-icons bx bx-paper-plane"></span>&nbsp; Send Invite
          </button>

          <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
            Cancel
          </button>
        </div>
      </form>

      @if (count($workspace->invites) > 0)
        <hr>
        <h5 class="offcanvas-title">
          <span class="bx bx-time mt-n1"></span>
          Invitation History
        </h5>
        <ul class="list-group list-group-flush">
          @foreach ($workspace->invites as $invite)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <p class="mb-0">{{ $invite->email }}</p>
                <small class="text-dark">Expires: {{ $invite->expires->format('M d, Y') }}</small>
              </div>

              <div class="d-flex">
                <form action="{{ route('invitations.resend', $invite->id) }}" method="POST" class="me-2">
                  @csrf

                  <button type="submit" class="btn rounded-pill btn-icon btn-outline-primary" data-bs-toggle="tooltip"
                    data-bs-offset="0,4" data-bs-placement="right" data-bs-html="false"
                    title="Resend invitation email">
                    <span class="tf-icons bx bx-redo"></span>
                  </button>
                </form>
                <form action="{{ route('invitations.delete', $invite->id) }}" method="POST">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn rounded-pill btn-icon btn-outline-danger" data-bs-toggle="tooltip"
                    data-bs-offset="0,4" data-bs-placement="right" data-bs-html="false"
                    title="Revoke and delete Invitation">
                    <span class="tf-icons bx bx-trash"></span>
                  </button>
                </form>
              </div>
            </li>
          @endforeach
        </ul>
      @endif

    </div>
  </div>
  {{-- End Invite Member offcanvas --}}
@endsection


@section('page-scripts')
  <script src="{{ asset('sneat/assets/js/form-basic-inputs.js') }}"></script>
@endsection
