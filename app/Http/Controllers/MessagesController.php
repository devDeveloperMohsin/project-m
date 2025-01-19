<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use App\Events\MessageSent;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        // Fetch users with whom the authenticated user has chatted
        $chattedUserIds = Message::where('from_id', auth()->id())
            ->orWhere('to_id', auth()->id())
            ->pluck('from_id', 'to_id')
            ->keys()
            ->merge(
                Message::where('from_id', auth()->id())
                    ->orWhere('to_id', auth()->id())
                    ->pluck('to_id', 'from_id')
                    ->keys()
            )
            ->unique();
    
        // Get user details for those with whom the user has chatted
        $users = User::whereIn('id', $chattedUserIds)
            ->where('id', '!=', auth()->id())
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                }
            })
            ->get();
    
        // Fetch groups the user belongs to
        $groups = Group::with('users')->get();
    
        $activeChat = null;
        $messages = collect();
    
        if ($request->has('to_id')) {
            // Handle individual chat
            $activeChat = User::find($request->to_id);
    
            if ($activeChat) {
                Message::where('to_id', auth()->id())
                    ->where('from_id', $request->to_id)
                    ->whereNull('is_read')
                    ->update(['is_read' => now()]);
    
                $messages = Message::where(function ($query) use ($request) {
                        $query->where('from_id', auth()->id())
                              ->where('to_id', $request->to_id);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('from_id', $request->to_id)
                              ->where('to_id', auth()->id());
                    })
                    ->orderBy('created_at')
                    ->get();
            }
        } elseif ($request->has('group_id')) {
            // Handle group chat
            $activeChat = Group::find($request->group_id);
    
            if ($activeChat) {
                $messages = GroupMessage::where('group_id', $request->group_id)
                    ->orderBy('created_at')
                    ->get();
            }
        }
    
        $notifications = auth()->user()->unreadNotifications;
    
        return view('chat', compact('users', 'groups', 'activeChat', 'messages', 'notifications'));
    }
    
public function search(Request $request)
    {
        if ($request->ajax()) {
                $search = $request->get('search');
                $data = User::where('name', 'LIKE', "%{$search}%")
                             ->orWhere('email', 'LIKE', "%{$search}%")
                             ->get();
                 $output='';
                 if(count($data)>0){
                    $output ='
                    <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">name</th>
                        
                    </tr>
                    </thead>
                    <tbody>';
                    foreach($data as $row){
                        $output .='
                        <tr>
                        <th scope="row"><a href="' . route('one-to-one.index', ['to_id' => $row->id]) . '" class="d-flex align-items-center">
                        <img src="' . ($row->getFirstMediaUrl('default', 'preview') ?: 'https://ui-avatars.com/api/?name=' . urlencode($row->name)) . '" 
                             alt="user-avatar" class="rounded-circle me-2" height="30" width="30">
                        <span class="user-name">' . $row->name . '</span>
                    </a></th>
                        
                        </tr>
                        ';
                    }
                    $output .= '
                    </tbody>
                   </table>';
                }else{

                    $output .='No results';
            
                }
            
                return $output;
                 }            

                
            
        }
    



    public function send(Request $request)
    {
        $message = Message::create([
            'message' => $request->message,
            'from_id' => auth()->id(),
            'to_id' => $request->to_id,
        ]);

        // broadcast(new MessageSent($message))->toOthers();

        return redirect()->back()->with('success', 'Message send successfully!');

    }

    public function markAsRead(Request $request)
    {
        if ($request->has('to_id')) {
            Message::where('to_id', auth()->id())
                ->where('from_id', $request->to_id)
                ->whereNull('is_read')
                ->update(['is_read' => now()]);
        } elseif ($request->has('group_id')) {
            Message::where('group_id', $request->group_id)
                ->whereNull('is_read')
                ->update(['is_read' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function createGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name' => $validated['name'],
            'created_by' => auth()->id(),
        ]);

        $group->users()->attach($validated['user_ids']);

        return redirect()->route('chat.index')->with('success', 'Group created successfully!');
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);

        // Ensure the authenticated user is the sender
        if ($message->from_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully.');
    }

    public function addUsers(Request $request, Group $group)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $group->users()->attach($request->user_ids);

        return redirect()->back()->with('success', 'Users added to the group successfully.');
    }

    public function removeUser(Group $group, User $user)
{
    if (!$group->users()->where('users.id', $user->id)->exists()) {
        abort(404, 'User not found in this group.');
    }

    $group->users()->detach($user->id);

    return redirect()->back()->with('success', 'User removed from the group.');
}

}
