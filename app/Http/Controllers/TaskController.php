<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

use App\Models\Reply;
use App\Models\TaskComment;
use App\Models\TaskHistory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Contracts\Validation\Rule;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validData = $request->validateWithBag('task', [
            'board_id' => ['required', 'integer', 'exists:boards,id'],
            'title' => ['required', 'string', 'max:400'],
            'description' => ['nullable', 'present'],
            'status' => ['required', 'string', 'max: 191'],
            'priority' => ['required', 'string', 'max: 191'],
            'type' => ['required', 'string', 'max: 191'],
            'due_date' => ['required', 'string', 'max: 191'],
            'assigned_to' => ['required', 'integer', 'min:0', 'exists:users,id'],
        ]);

        $task = Task::create($validData);

        // Assign User
        $task->users()->attach($validData['assigned_to'], ['role' => Task::ROLE_MEMBER]);

        // Add History
        $task->history()->create(['user_id' => Auth::id(), 'type' => TaskHistory::TYPE_TASK_CREATED, 'data' => json_encode(['title' => $task->title])]);

        return back()->withSuccess('Task has been added');
    }



    public function update(Request $request, $id)
    {
        $validData = $request->validateWithBag('task', [
            'title' => ['required', 'string', 'max:400'],
            'description' => ['nullable', 'present'],
            'status' => ['required', 'string', 'max: 191'],
            'priority' => ['required', 'string', 'max: 191'],
            'type' => ['required', 'string', 'max: 191'],
            'due_date' => ['required', 'string', 'max: 191'],
            'assigned_to' => ['required', 'integer', 'min:0', 'exists:users,id'],
        ]);

        $task = Task::findOrFail($id);
        $task->update($validData);

        // Assign User
        $task->users()->sync([$validData['assigned_to'] => ['role' => Task::ROLE_MEMBER]]);

        // Add History
        $changedData = $task->getChanges();
        unset($changedData["updated_at"]);
        $task->history()->create(['user_id' => Auth::id(), 'type' => TaskHistory::TYPE_TASK_Updated, 'data' => json_encode($changedData)]);

        return back()->withSuccess('Task has been updated');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'min:1'],
        ]);

        $task = Task::with('subItems','users', 'board.tasks', 'board.tasks.users', 'history', 'history.user')->findOrFail($request->get('id'));
        $project = $task->board->project;
        $comments = TaskComment::with('user')->where('task_id', $task->id)->latest()->get();
        return view('taskDetails', compact('task', 'project', 'comments'));
    }
    public function storeComment(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'task_id' => ['required', 'integer', 'exists:tasks,id'],
        'comment' => ['required', 'string', 'max:5000'],
        'attachments' => ['nullable', 'array'],
        'attachments.*' => [
            'file',
            'mimes:jpg,jpeg,png,pdf',
            'max:10240', // 10 MB
        ],
    ]);

    // Check if the user pressed the "Show Users" button
    if ($request->has('show_users') && $request->input('show_users') == '1') {
        preg_match_all('/@(\w+)/', $validated['comment'], $matches);
        $mentions = $matches[1];

        // Fetch users whose names match the mention
        $users = DB::table('users')
            ->where(function ($query) use ($mentions) {
                foreach ($mentions as $mention) {
                    $query->orWhere('name', 'like', "%{$mention}%");
                }
            })
            ->limit(10)
            ->get(['id', 'name']);

        // Pass the suggestions back to the form
        return redirect()->back()->with('user_suggestions', $users);
    }

    // Otherwise, store the comment
    $task = Task::findOrFail($validated['task_id']);
    $comment = $task->comments()->create([
        'user_id' => Auth::id(),
        'comment' => $validated['comment'],
    ]);

    // Handle attachments
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $attachment) {
            $comment->addMedia($attachment)->toMediaCollection('attachments');
        }
    }

    return back()->withSuccess('Comment has been added.');
}



    public function storeReply(Request $request)
    {
        $validData = $request->validate([
            'task_comment_id' => ['required', 'integer', 'exists:task_comments,id'], // Updated field name
            'reply' => ['required', 'string', 'max:5000'],
        ]);

        $comment = TaskComment::findOrFail($validData['task_comment_id']); // Updated field name

        // Save the reply
        $reply = $comment->replies()->create([
            'user_id' => Auth::id(),
            'comment' => $validData['reply'],
        ]);


        $task = $comment->task; // Assuming Comment has a relationship with Task
    $task->history()->create([
        'user_id' => Auth::id(),
        'type' => TaskHistory::TYPE_REPLIED, // Assuming TYPE_REPLIED exists in your TaskHistory model
        'data' => json_encode(['reply' => $reply->comment]),
    ]);

        return back()->withSuccess('Reply has been added.');
    }



    public function destroyComment($id)
    {
        $comment = TaskComment::where('user_id', Auth::id())->findOrFail($id);

        // Add History
        $comment->task->history()->create(['user_id' => Auth::id(), 'type' => TaskHistory::TYPE_DELETED_COMMENTED]);

        // Delete
        $comment->delete();
        return back()->withSuccess('Comment has been deleted');
    }
    public function destroyReply($id)
    {
        // Retrieve the reply that belongs to the authenticated user
        $reply = Reply::where('user_id', Auth::id())->findOrFail($id);

        // Access the comment associated with the reply
        // $task = $reply->task;
        // // Add History
        // $task->history()->create([
        //     'user_id' => Auth::id(),
        //     'type' => TaskHistory::TYPE_DELETED_REPLIED, // Ensure this constant is defined
        //     'data' => json_encode(['reply' => $reply->comment]), // Log the reply content
        // ]);

        // Delete the reply
        $reply->delete();

        return back()->withSuccess('Reply has been deleted.');
    }




    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('project.show', $task->board->project->id)->withSuccess('Task has been deleted');
    }
    public function details($id)
    {
        $task = Task::findOrFail($id); // Fetch task details by ID
        $project = Project::findOrFail($id); // Fetch task details by ID
        $comments = TaskComment::where('user_id', Auth::id())->findOrFail($id);

        return view('taskDetails', compact('task','project','comments'));
    }

    public function getSuggestions(Request $request)
{
    $query = $request->input('query', '');

    // Fetch users whose names match the query
    $users = DB::table('users')
        ->where('name', 'like', "%{$query}%")
        // ->limit(10)
        ->get(['id', 'name']); // Only return necessary fields

    return response()->json($users);
}





}
