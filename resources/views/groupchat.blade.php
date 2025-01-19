@extends('layouts.app')

@section('page-styles')
    <style>
        img.rounded-circle {
            object-fit: cover;
        }

        .chat-window {
            height: 400px;
            overflow-y: auto;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
    </style>
@endsection

@section('page-content')
    <div class="container">
        <div class="row">
            <!-- Groups Sidebar -->
            <div class="col-md-4">
                <h4>Groups</h4>
                <!-- Search Groups -->
                <div class="mb-3">
                    <input type="text" id="groupSearch" class="form-control" placeholder="Search Groups...">
                </div>
                <ul class="list-group" id="groupList">
                    @foreach ($groups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <form method="GET" action="{{ route('groups.show', $group->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">{{ $group->name }}</button>
                            </form>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#manageGroupModal-{{ $group->id }}">
                                Manage
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Create Group Button -->
                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                    Create Group
                </button>
            </div>

            <!-- Group Chat Window -->
            <div class="col-md-8">
                <h4>Group Chat</h4>
                <div id="chatWindow" class="border p-3 chat-window">
                    @if (!empty($messages))
                        @foreach ($messages as $message)
                            <div
                                class="d-flex {{ $message->user_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                                @if ($message->user_id !== auth()->id())
                                    <img src="{{ $message->user->getFirstMediaUrl('default', 'preview') ?: 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) }}"
                                        class="message-avatar rounded-circle" alt="{{ $message->user->name }}">
                                @endif
                                <div>
                                    <div
                                        class="message-content {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }} p-2 rounded">
                                        {{ $message->message }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $message->user->name }} • {{ $message->created_at->format('d M Y, h:i A') }}
                                        @if ($message->user_id === auth()->id())
                                            <form method="POST"
                                                action="{{ route('groups.messages.delete', ['group' => $group->id, 'message' => $message->id]) }}"
                                                class="ms-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm text-danger p-0">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Select a group to view messages.</p>
                    @endif
                </div>

                <!-- Chat Input -->
                @if (!empty($group))
                    <form method="POST" action="{{ route('groups.sendMessage', $group->id) }}" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type a message..."
                                required>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('groups.create') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createGroupModalLabel">Create Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="groupName" class="form-label">Group Name</label>
                            <input type="text" class="form-control" id="groupName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="users" class="form-label">Add Users</label>
                            <select class="form-select" name="user_ids[]" id="users" multiple required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Manage Group Modals -->
    @foreach ($groups as $group)
        <div class="modal fade" id="manageGroupModal-{{ $group->id }}" tabindex="-1"
            aria-labelledby="manageGroupModalLabel-{{ $group->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manageGroupModalLabel-{{ $group->id }}">Manage Group:
                            {{ $group->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Group Members</h6>
                        <!-- Search Users in Group -->
                        <div class="mb-3">
                            <input type="text" class="form-control" id="groupMembersSearch-{{ $group->id }}" placeholder="Search group members...">
                        </div>
                        <ul class="list-group" id="groupMembersList-{{ $group->id }}">
                            @foreach ($group->users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $user->name }}
                                    @if ($user->id !== $group->created_by)
                                        <form method="POST" action="{{ route('group.removeUser', ['group' => $group->id, 'user' => $user->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    
                        <!-- Add Users -->
                        <h6 class="mt-4">Add Users</h6>
                        <!-- Search Users to Add -->
                        <div class="mb-3">
                            <input type="text" class="form-control" id="addUsersSearch-{{ $group->id }}" placeholder="Search users to add...">
                        </div>
                        <form method="POST" action="{{ route('groups.addUsers', $group->id) }}">
                            @csrf
                            <select class="form-select mb-3" name="user_ids[]" id="addUsersList-{{ $group->id }}" multiple required>
                                @foreach ($users as $user)
                                    @if (!$group->users->contains($user->id))
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Add Users</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach

    <script>
        // Real-Time Search for Groups
        const groupSearch = document.getElementById('groupSearch');
        const groupList = document.getElementById('groupList');

        groupSearch.addEventListener('input', function() {
            const searchValue = groupSearch.value.toLowerCase();
            Array.from(groupList.children).forEach(group => {
                const groupName = group.textContent.toLowerCase();
                group.style.display = groupName.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($groups as $group)
                // Real-Time Search for Group Members
                const groupMembersSearch{{ $group->id }} = document.getElementById('groupMembersSearch-{{ $group->id }}');
                const groupMembersList{{ $group->id }} = document.getElementById('groupMembersList-{{ $group->id }}');
    
                groupMembersSearch{{ $group->id }}.addEventListener('input', function () {
                    const searchValue = groupMembersSearch{{ $group->id }}.value.toLowerCase();
                    Array.from(groupMembersList{{ $group->id }}.children).forEach(member => {
                        const memberName = member.textContent.toLowerCase();
                        member.style.display = memberName.includes(searchValue) ? '' : 'none';
                    });
                });
    
                // Real-Time Search for Adding Users
                const addUsersSearch{{ $group->id }} = document.getElementById('addUsersSearch-{{ $group->id }}');
                const addUsersList{{ $group->id }} = document.getElementById('addUsersList-{{ $group->id }}');
    
                addUsersSearch{{ $group->id }}.addEventListener('input', function () {
                    const searchValue = addUsersSearch{{ $group->id }}.value.toLowerCase();
                    Array.from(addUsersList{{ $group->id }}.options).forEach(option => {
                        const userName = option.textContent.toLowerCase();
                        option.style.display = userName.includes(searchValue) ? '' : 'none';
                    });
                });
            @endforeach
        });
    </script>
    
@endsection
