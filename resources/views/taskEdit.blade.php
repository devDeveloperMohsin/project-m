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

<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel3">{{ $task->board->project->name }} - Task {{ $task->id }}
    <button style="margin-top: -6px" class="btn btn-icon btn-sm btn-simple">
      <span class="text-primary bx bx-link"></span>
    </button>
  </h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="row">
    {{-- Left --}}
    <div class="col-md-8 col-lg-7">
      <div class="row">
        <div class="col mb-3">
          <label for="edit-task-title" class="form-label">Title</label>
          <input type="text" id="edit-task-title" class="form-control @error('title', 'task') is-invalid @enderror"
            placeholder="Write a task title" name="title" value="{{ old('title', $task->title) }}" />
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
          <textarea id="editor-edit" name="description">{{ old('description', $task->description) }}</textarea>
          @error('description', 'task')
            <div class="form-text text-danger">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      {{-- Tabs --}}
      <div class="nav-align-top mb-4 no-shadow-tabs">
        <ul class="nav nav-tabs nav-fill" role="tablist">
          <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
              <i class="tf-icons bx bx-message-square"></i> Messages
              <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-dark">3</span>
            </button>
          </li>
          <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
              data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
              <i class="tf-icons bx bx-home"></i> History
            </button>
          </li>
        </ul>
        <div class="tab-content">
          {{-- History --}}
          <div class="tab-pane fade" id="navs-justified-home" role="tabpanel">
            <div>
              @for ($i = 0; $i < 10; $i++)
                <div class="comments history">
                  <div class="user-icon">
                    <a href="">
                      <img src="https://ui-avatars.com/api/?name=Mohsin+Ali" alt="">
                    </a>
                  </div>
                  <div class="comment-body">
                    <div class="comment-title">
                      <a href="">Mohsin Ali</a>
                      <span>1 day ago</span>
                    </div>
                    <p>
                      Updated status ---->> Pending
                    </p>
                  </div>
                </div>
              @endfor
            </div>
          </div>
          {{-- End History --}}

          {{-- Comments/Discussions --}}
          <div class="tab-pane fade show active" id="navs-justified-messages" role="tabpanel">
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-message">Write a comment message</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-message2" class="input-group-text"><i class="bx bx-comment"></i></span>
                <textarea id="basic-icon-default-message" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"
                  aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
              </div>
            </div>
            <div class="mb-3">
              <input class="form-control" type="file" id="formFileMultiple" multiple />
            </div>

            <hr>

            <div>
              @for ($i = 0; $i < 10; $i++)
                <div class="comments">
                  <div class="user-icon">
                    <a href="">
                      <img src="https://ui-avatars.com/api/?name=Mohsin+Ali" alt="">
                    </a>
                  </div>
                  <div class="comment-body">
                    <div class="comment-title">
                      <a href="">Mohsin Ali</a>
                      <span>1 day ago</span>
                      <button type="button" class=" me-1 btn btn-icon btn-sm btn-simple">
                        <span class="tf-icons bx bx-trash"></span>
                      </button>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit quae dolore illum
                      commodi dolorem beatae maiores sequi libero numquam itaque? Ducimus error in dicta
                      voluptate
                      asperiores, nesciunt voluptatem laboriosam modi!
                    </p>
                    <div class="attachments">
                      <small class="text-light fw-semibold">Attachments</small>
                      <div class="demo-inline-spacing mt-3">
                        <div class="list-group">
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action">Bonbon
                            toffee muffin</a>
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action">Dragée
                            tootsie roll</a>
                          <a href="javascript:void(0);" class="list-group-item list-group-item-action">Dragée
                            tootsie roll</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endfor
            </div>
          </div>
          {{-- End Comments Discussions --}}
        </div>
      </div>
      {{-- End Tabs --}}
    </div>
    {{-- End Left --}}

    {{-- Right --}}
    <div class="col-md-4 col-lg-5">
      <div class="row g-2">
        <div class="col mb-3">
          <label for="edit-status-select" class="form-label">Select Status</label>
          <select class="form-select @error('status', 'task') is-invalid @enderror" id="edit-status-select"
            aria-label="select task status" name="status">
            @foreach ($taskStatuses as $status)
              <option value="{{ $status }}" class="text-capitalize" @selected($task->status == $status)>
                {{ $status }}</option>
            @endforeach
          </select>
          @error('status', 'task')
            <div class="form-text text-danger">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="col mb-3">
          <label for="edit-priority-select" class="form-label">Select Priority</label>
          <select class="form-select @error('priority', 'task') is-invalid @enderror" id="edit-priority-select"
            aria-label="select task priority" name="priority">
            @foreach ($taskPriorities as $priority)
              <option value="{{ $priority }}" class="text-capitalize" @selected($task->priority == $priority)>
                {{ $priority }}</option>
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
          <label for="edit-task-type" class="form-label">Task Type</label>
          <select class="form-select @error('type', 'task') is-invalid @enderror" id="edit-task-type"
            aria-label="select task type" name="type">
            @foreach ($taskTypes as $type)
              <option value="{{ $type }}" @selected($task->type == $type)>{{ $type }}</option>
            @endforeach
          </select>
          @error('type', 'task')
            <div class="form-text text-danger">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="col mb-3">
          <label for="edit-due-date" class="form-label">Due Date</label>
          <input class="form-control @error('due_date', 'task') is-invalid @enderror" type="date"
            value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" id="edit-due-date" name="due_date" />
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
          <select class="form-select" id="assigned-to" aria-label="Default select example">
            <option selected>None</option>
          </select>
        </div>
      </div>
    </div>
    {{-- End Right --}}
  </div>



</div>
<div class="modal-footer">
  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
    Close
  </button>
  <button type="button" class="btn btn-primary">Save changes</button>
</div>



{{-- We are using script tag as this page will be loaded via Ajax Request --}}
<script>
  $(document).ready(function() {
    ClassicEditor
      .create(document.querySelector('#editor-edit'))
      .catch(error => {
        console.error(error);
      });
  });
</script>
