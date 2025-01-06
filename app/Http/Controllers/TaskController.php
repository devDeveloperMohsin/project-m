<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        $validData = $request->validate([
            'task_id' => ['required', 'integer', 'min:0'],
            'comment' => ['required', 'string', 'max: 5000'],
            'attachments' => ['nullable', 'array'],
            'attachment.*' => [
                'required',
                File::types(['jpg', 'png', 'jpeg', 'pdf'])
                    ->min('1kb')
                    ->max('10mb')
            ],
        ]);

        $task = Task::findOrFail($validData['task_id']);

        $comment = $task->comments()->create(['user_id' => Auth::id(), 'comment' => $validData['comment']]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $comment->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        // Add History
        $task->history()->create(['user_id' => Auth::id(), 'type' => TaskHistory::TYPE_COMMENTED, 'data' => json_encode(['comment' => $comment->comment])]);

        return back()->withSuccess('Comment has been added');
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

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('project.show', $task->board->project->id)->withSuccess('Task has been deleted');
    }
}