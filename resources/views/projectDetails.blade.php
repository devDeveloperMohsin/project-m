@extends('layouts.app')

@section('page-styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
@endsection

@php
  $taskStatuses = [
      'To Do',
      'In Progress',
      'Done',
      'Blocked',
      'Ready for Testing',
      'Testing in Progress',
      'Failed Testing',
      'Ready for Deployment',
      'Deployed',
      'Reopened',
  ];

  $taskPriorities = ['Low', 'Medium', 'High', 'Critical'];

  $taskTypes = ['Bug', 'Feature', 'Task', 'Improvement', 'Epic', 'Sub-task'];
@endphp

@section('page-content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Project Header --}}
    <div class="d-flex pt-3">
      {{-- Project Details  --}}
      <div>
        <div class="d-flex mb-2">
          <h4 class="fw-bol m-0 me-2">{{ $project->name }}</h4>
          <button type="button" class=" me-1 btn btn-icon btn-sm btn-simple" data-bs-toggle="modal"
            data-bs-target="#projectInfoModal">
            <span class="tf-icons bx bx-info-circle"></span>
          </button>
          <form action="{{ route('project.starToggle', $project->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-icon btn-sm btn-simple ms-2">
              <span
                class="tf-icons bx bxs-star {{ in_array($project->id, $markedProjects->pluck('id')->toArray()) ? 'text-warning' : '' }}"></span>
            </button>
          </form>
        </div>
        <p class="text-truncate" style="max-width: 500px; width: 100%">
          {{ $project->description }}
        </p>
      </div>
      {{-- End Project Detials --}}

      {{-- Project Actions --}}
      <div style="min-width: 150px" class="ms-auto">
        {{-- Add Group Button --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBoardModal"
          aria-controls="createBoardModal">
          <span class="tf-icons bx bx-plus"></span>&nbsp; Add Board
        </button>
        {{-- End Add Group Button --}}

        {{-- Invite Button --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#invitationOffCanvas"
          aria-controls="invitationOffCanvas">
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
            <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#projectInfoModal"><span class="bx bx-info-circle"></span> Details</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('board.history', $project->id) }}"><span
                  class="bx bx-info-circle"></span> Boards History</a>
            </li>
            <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                data-bs-target="#editModal"><span class="bx bx-edit-alt"></span> Edit</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="offcanvas"
                data-bs-target="#invitationOffCanvas"><span class="bx bx-user-plus"></span> Invite</a></li>
            {{-- <li><a class="dropdown-item" href="javascript:void(0);"><span class="bx bx-user-check"></span> Permissions</a> --}}
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="invitationOffCanvas" aria-labelledby="offcanvasEndLabel">
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
          <input type="hidden" name="type" value="project">
          <input type="hidden" name="id" value="{{ $project->id }}">

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

        @if (count($project->invites) > 0)
          <hr>
          <h5 class="offcanvas-title">
            <span class="bx bx-time mt-n1"></span>
            Invitation History
          </h5>
          <ul class="list-group list-group-flush">
            @foreach ($project->invites as $invite)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <p class="mb-0">{{ $invite->email }}</p>
                  <small class="text-dark">Expires: {{ $invite->expires->format('M d, Y') }}</small>
                </div>

                <div class="d-flex">
                  <form action="{{ route('invitations.resend', $invite->id) }}" method="POST" class="me-2">
                    @csrf

                    <button type="submit" class="btn rounded-pill btn-icon btn-outline-primary"
                      data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="right" data-bs-html="false"
                      title="Resend invitation email">
                      <span class="tf-icons bx bx-redo"></span>
                    </button>
                  </form>
                  <form action="{{ route('invitations.delete', $invite->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn rounded-pill btn-icon btn-outline-danger"
                      data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="right" data-bs-html="false"
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

    <hr>

    {{-- <div class="mb-5" id="project-board"></div> --}}

    <div class="project-details">
      {{-- Project Board --}}
      @forelse ($project->boards as $board)
        <div class="project-group">
          <div class="d-flex  mb-3">
            <h5 class="m-0">{{ $board->name }}</h5>
            <div class="ms-auto">
              <button type="button" class="btn btn-sm btn-primary add_task_btn" data-board-id="{{ $board->id }}">
                <span class="tf-icons bx bx-plus"></span>&nbsp; Add Task
              </button>
              <button type="button" class="btn btn-sm btn-icon btn-outline-primary edit_board_btn"
                data-board-name="{{ $board->name }}" data-board-sorting="{{ $board->sorting }}"
                data-board-update-route="{{ route('board.update', $board->id) }}">
                <span class="tf-icons bx bx-edit-alt"></span>
              </button>
            </div>
          </div>

          @if (is_countable($board->tasks) && count($board->tasks) > 0)
            <div class="p-group-body mb-5">
              <div class="card">
                <div class="card-body">
                  <table class="hover row-border order-column compact datatable">
                    <thead>
                      <tr>
                        <th></th>
                        <td>Title</td>
                        <td>Status</td>
                        <td>Priority</td>
                        <td>Due Date</td>
                        <td>Type</td>
                        <td>Assigned to</td>
                        <td>Created at</td>
                        <td>last updated</td>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($board->tasks as $task)
                        <tr id="task-{{ $task->id }}">
                          <td></td>
                          <td>{{ $task->title }}</td>
                          <td>{{ $task->status }}</td>
                          <td>{{ $task->priority }}</td>
                          <td>{{ $task->due_date->format('d/M/Y') }}</td>
                          <td>{{ $task->type }}</td>
                          <td></td>
                          <td>{{ $task->created_at->format('d/M/Y') }}</td>
                          <td>{{ $task->updated_at->diffForHumans() }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          @else
            <div class="alert alert-primary">
              <p>
                <span class="bx bx-bell"></span>
                <strong>No Data</strong>
              </p>
              Start adding tasks to this board by clicking the <a href="javascript:void(0)" data-bs-toggle="modal"
                data-bs-target="#addTaskModal" class="text-decoration-underline fw-bold">Add Task</a> button
            </div>
          @endif

        </div>
      @empty
        <div class="card mb-4">
          <h5 class="card-header">
            <span class="bx bx-bell"></span>
            Create Your First Board!
          </h5>
          <div class="card-body">
            <p class="card-text">
              Congratulations on taking the first step to supercharge your productivity! Let's create your first board and
              kickstart your journey to organized and efficient task management.
            </p>
            <p>
              Hit the <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#createBoardModal"
                aria-controls="createBoardModal">Create Board</a> button below and customize your board to match your
              workflow. Get ready to experience a whole new level of collaboration and productivity!
            </p>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createBoardModal"
              aria-controls="createBoardModal">
              Let's create the first board
            </button>
          </div>
        </div>
      @endforelse
      {{-- End Project Board --}}
    </div>

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
                        <form
                          action="{{ route('project.revokeAccess', ['id' => $project->id, 'userId' => $user->id]) }}"
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('project.update', $project->id) }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Edit Project</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="project-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" id="project-name"
                  class="form-control @error('name', 'project') is-invalid @enderror" placeholder="Enter Name"
                  required />
                @error('name', 'project')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="project-description" class="form-label">Description</label>
                <textarea name="description" id="project-description"
                  class="form-control @error('description', 'project') is-invalid @enderror" rows="5">{{ old('description', $project->description) }}</textarea>
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
    {{-- End Edit Modal --}}

    {{-- Create Task Modal --}}
    <div class="modal fade" id="addTaskModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="add-task-modal-title">Add Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <form action="{{ route('task.store') }}" method="POST">
            @csrf
            <input type="hidden" name="board_id" id="add-task-board-id">
            <div class="modal-body">
              <div class="row">
                <div class="col mb-3">
                  <label for="task-title" class="form-label">Title</label>
                  <input type="text" id="task-title"
                    class="form-control @error('title', 'task') is-invalid @enderror" placeholder="Write a task title"
                    name="title" value="{{ old('title') }}" />
                  @error('title', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label class="form-label">Description</label>
                  <textarea id="editor" name="description">{{ old('description') }}</textarea>
                  @error('description', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row g-2">
                <div class="col mb-3">
                  <label for="status-select" class="form-label">Select Status</label>
                  <select class="form-select @error('status', 'task') is-invalid @enderror" id="status-select"
                    aria-label="select task status" name="status">
                    @foreach ($taskStatuses as $status)
                      <option value="{{ $status }}" class="text-capitalize">{{ $status }}</option>
                    @endforeach
                  </select>
                  @error('status', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col mb-3">
                  <label for="priority-select" class="form-label">Select Priority</label>
                  <select class="form-select @error('priority', 'task') is-invalid @enderror" id="priority-select"
                    aria-label="select task priority" name="priority">
                    @foreach ($taskPriorities as $priority)
                      <option value="{{ $priority }}" class="text-capitalize">{{ $priority }}</option>
                    @endforeach
                  </select>
                  @error('priority', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row g-2">
                <div class="col mb-3">
                  <label for="task-type" class="form-label">Task Type</label>
                  <select class="form-select @error('type', 'task') is-invalid @enderror" id="task-type"
                    aria-label="select task type" name="type">
                    @foreach ($taskTypes as $type)
                      <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                  </select>
                  @error('type', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col mb-3">
                  <label for="due-date" class="form-label">Due Date</label>
                  <input class="form-control @error('due_date', 'task') is-invalid @enderror" type="date"
                    value="{{ old('due_date') }}" id="due-date" name="due_date" />
                  @error('due_date', 'task')
                    <div class="form-text text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="col mb-3">
                  <label for="assigned-to" class="form-label">Assigned To</label>
                  <select class="form-select @error('task_user', 'task') is-invalid @enderror" id="assigned-to"
                    aria-label="assign task" name="task_user">
                    @foreach ($project->users as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                  </select>
                  @error('task_user', 'task')
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
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>

        </div>
      </div>
    </div>
    {{-- End Create Task Modal --}}

    {{-- Edit Task Modal --}}
    <div class="modal fade" id="editTaskModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="edit-task-content">

        </div>
      </div>
    </div>
    {{-- End Edit Task Modal --}}

    {{-- Create Board Modal --}}
    <div class="modal fade" id="createBoardModal" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" action="{{ route('board.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Create Board</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <label for="board-name" class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" id="board-name"
                  class="form-control @error('name', 'board') is-invalid @enderror" placeholder="Enter Name" required />
                @error('name', 'board')
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
    {{-- End Create Board Modal --}}

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
                  class="form-control @error('name', 'board') is-invalid @enderror" placeholder="Enter Name"
                  required />
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
                  Project's <a href="{{ route('board.history', $project->id) }}">Board History</a> Page
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
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>

  <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

  <script>
    $(document).ready(function() {
      let table = $('.datatable').DataTable({
        fixedColumns: true,
        paging: false,
        scrollCollapse: true,
        scrollX: false,
        rowId: 'id',
        rowReorder: {
          dataSrc: 1
        },
        columnDefs: [{
          className: 'reorder',
          render: () => '≡',
          targets: 0
        }, {
          width: "200px",
          targets: 1
        }],
      });

      table.on('click', 'tbody tr', function() {
        let data = table.row(this).data();
        let taskId = table.row(this).id();
        taskId = parseInt(taskId.match(/\d+/)[0]);
        $.ajax({
          url: '{{ route('task.show') }}',
          data: {
            id: taskId,
          },
          success: function(result) {
            $("#edit-task-content").html(result);
            $('#editTaskModal').modal('show');
          }
        });
      });

      table.on('row-reorder', function(e, diff, edit) {
        if (table.data('tabs')) {
          var rows = table.rows().data();
          var ord = new Array();
          for (var i = 0, ien = rows.length; i < ien; i++) {
            ord[i] = rows[i].DT_RowId;
          }
          console.log(ord, table.data('tabs'));
        }
      });
    });

    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });

    // ClassicEditor
    //   .create(document.querySelector('#editor-edit'))
    //   .catch(error => {
    //     console.error(error);
    //   });
  </script>

  <script>
    $(document).ready(function() {
      // $('#editTaskModal').modal('show');

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

      // Open Add Task Modal
      $(document).on('click', '.add_task_btn', function(e) {
        e.preventDefault();
        var boardId = $(this).attr('data-board-id');
        $('#add-task-board-id').val(boardId);

        $('#addTaskModal').modal('show');
      });
      // End Open Add Task Modal

    });
  </script>
@endsection
