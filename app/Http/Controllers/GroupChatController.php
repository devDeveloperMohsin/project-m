<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\User;
use App\Events\GroupMessageSent;

class GroupChatController extends Controller
{
    public function index()
    {
        $groups = Group::with('users')->get();
        $users = User::where('id', '!=', auth()->id())->get();

        return view('groupchat', compact('groups', 'users'));
    }

    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        $group->users()->syncWithoutDetaching($request->user_ids);

        return redirect()->back()->with('success', 'Group created successfully!');
    }

    public function addUsersToGroup(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $group->users()->syncWithoutDetaching($request->input('user_ids'));

        return redirect()->back()->with('success', 'Users added to the group successfully!');
    }

    public function sendGroupMessage(Request $request, $groupId)
    {
        $group = Group::findOrFail($groupId);

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = GroupMessage::create([
            'group_id' => $groupId,
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        broadcast(new GroupMessageSent($message))->toOthers();

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function show($groupId)
    {
        $group = Group::with(['users', 'messages.user'])->findOrFail($groupId);
        $groups = Group::with('users')->get();

        $users = User::where('id', '!=', auth()->id())->get();
        $messages = $group->messages()->with('user')->orderBy('created_at', 'asc')->get();
    $users = User::where('id', '!=', auth()->id())->get();

    if ($messages->isEmpty()) {
        session()->flash('info', 'No messages found in this group.');
    }

        return view('groupchat', compact('group','messages', 'users','groups'));
    }

    public function removeUser(Group $group, User $user)
    {
        if ($group->created_by === $user->id) {
            return redirect()->back()->with('error', 'The group creator cannot be removed.');
        }

        $group->users()->detach($user->id);

        return redirect()->back()->with('success', 'User removed successfully.');
    }
    public function deleteGroupMessage($groupId, $messageId)
    {
        $message = GroupMessage::findOrFail($messageId);

        // Ensure the user is authorized to delete the message
        if ($message->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this message.');
        }

        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully.');
    }
}
