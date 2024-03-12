@extends('layouts.app')

@section('page-styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
@endsection

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Project Header --}}
    <div class="d-flex pt-3">
      {{-- Project Details  --}}
      <div>
        <div class="d-flex mb-2">
          <a href="{{ route('project.show', $project->id) }}"><h4 class="fw-bol m-0 me-2 text-primary">{{ $project->name }}</h4></a>
          <button type="button" class=" me-1 btn btn-icon btn-sm btn-simple" data-bs-toggle="modal"
            data-bs-target="#projectInfoModal">
            <span class="tf-icons bx bx-info-circle"></span>
          </button>
        </div>
        <p class="text-truncate" style="max-width: 500px; width: 100%">
          {{ $project->description }}
        </p>
      </div>
      {{-- End Project Detials --}}
    </div>
    {{-- End Project Header --}}

    {{-- Board History --}}
    <div class="card mt-3">
      <h5 class="card-header">Boards History</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Sorting</th>
              <th>Status</th>
              <th>Contributors</th>
              <th>Created</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @forelse ($boards as $board)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $board->name }}</strong></td>
                <td>{{ $board->sorting }}</td>
                <td><span
                    class="badge {{ $board->closed ? 'bg-label-danger' : 'bg-label-primary' }} me-1">{{ $board->closed ? 'closed' : 'active' }}</span>
                </td>
                <td>
                  <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                      class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                      <img src="{{ asset('sneat/assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                      class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                      <img src="{{ asset('sneat/assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle">
                    </li>
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                      class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                      <img src="{{ asset('sneat/assets/img/avatars/7.png') }}" alt="Avatar" class="rounded-circle">
                    </li>
                  </ul>
                </td>
                <td>{{ $board->created_at->format('M d, Y h:i A') }}</td>
                <td>{{ $board->updated_at->diffForHumans() }}</td>

                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu" style="">
                      <button class="dropdown-item edit_board_btn" data-board-name="{{ $board->name }}" data-board-sorting="{{ $board->sorting }}" data-board-update-route="{{ route('board.update', $board->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</button>
                      <form action="{{ route('board.delete', $board->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6">
                  <div class="alert alert-primary">No boards have been added to this project</div>
                </td>
              </tr>
            @endforelse


          </tbody>
        </table>
      </div>
    </div>
    {{-- End Board History --}}

    {{-- Project Info Modal --}}
    <div class="modal fade" id="projectInfoModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Project Info</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            {{-- Details --}}
            <div>
              <h4>{{ $project->name }}</h4>
              <p>
                {{ nl2br($project->description) }}
              </p>
            </div>
            {{-- End Details --}}

            {{-- Members --}}
            <div class="mt-5">
              <h6>Members</h6>
              @foreach ($project->users as $user)
                <div class="d-flex mb-3 members-list">
                  <div class="flex-shrink-0  me-3">
                    <img
                      src="{{ !empty($user->getFirstMediaUrl()) ? $user->getFirstMediaUrl('default', 'preview') : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                      alt="user-avatar" class="d-block rounded-circle" style="object-fit: cover" height="30"
                      width="30" />
                  </div>
                  <div class="flex-grow-1 row">
                    <div class="col-9 mb-sm-0 mb-2">
                      @php
                        $r = $project->roleMapping($user->pivot->role);
                      @endphp
                      <h6 class="mb-0">{{ $user->name }} <span
                          class="badge rounded-pill bg-label-{{ Str::lower($r) == 'admin' ? 'primary' : 'secondary' }}"
                          style="font-size:0.7rem;">{{ $r }}</span> </h6>
                      <small class="text-muted">{{ $user->email }}</small>
                    </div>
                    <div class="col-3 text-end">
                      @if ($user->pivot->role !== $project::ROLE_ADMIN)
                        <form action="{{ route('project.revokeAccess', ['id' => $project->id, 'userId' => $user->id]) }}"
                          method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="right"
                            data-bs-html="false" title="Remove {{ $user->name }} from project">
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    {{-- End Project Info Modal --}}


    {{-- Edit Board Modal --}}
    <div class="modal fade" id="editBoardModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" id="editBoardForm" action="" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Edit Board</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-12 mb-3">
                <label for="edit-board-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" id="edit-board-name"
                  class="form-control @error('name', 'board') is-invalid @enderror" placeholder="Enter Name" required />
                @error('name', 'board')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col-12 mb-3">
                <label for="board-sorting" class="form-label">Sorting</label>
                <input type="text" name="sorting" value="{{ old('sorting') }}" id="edit-board-sorting"
                  class="form-control @error('sorting', 'board') is-invalid @enderror" placeholder="Enter Sorting"
                  required />
                @error('sorting', 'board')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col-12">
                <div class="form-check mt-3">
                  <input class="form-check-input" type="checkbox" value="1" id="close-board" name="close">
                  <label class="form-check-label" for="close-board"> Close the board </label>
                </div>
                @error('name', 'board')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
                <div class="alert alert-secondary mt-3" role="alert">
                  <span class="bx bx-bell"></span>
                  Closed boards are not displayed in Project details page. But you can always check the boards in the
                  Project's <a href="#">Board History</a> Page
                </div>
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
    {{-- End Edit Board Modal --}}

  </div>
@endsection


@section('page-scripts')
  <script>
    $(document).ready(function() {
      // Open Board Edit Modal
      $(document).on('click', '.edit_board_btn', function(e) {
        e.preventDefault();
        var updateRoute = $(this).attr('data-board-update-route');
        var boardName = $(this).attr('data-board-name');
        var boardSorting = $(this).attr('data-board-sorting');

        $('#editBoardForm').attr('action', updateRoute);
        $('#edit-board-name').val(boardName);
        $('#edit-board-sorting').val(boardSorting);

        $('#editBoardModal').modal('show');
      });
      // End Open Board Edit Modal
    });
  </script>
@endsection
