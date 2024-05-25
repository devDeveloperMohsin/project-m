<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
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
        ]);

        Task::create($validData);

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
        ]);

        $task = Task::findOrFail($id);
        $task->update($validData);

        return back()->withSuccess('Task has been updated');
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'min:1'],
        ]);

        $task = Task::findOrFail($request->get('id'));
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

        return back()->withSuccess('Comment has been added');
    }

    public function destroyComment($id)
    {
        $comment = TaskComment::where('user_id', Auth::id())->findOrFail($id);
        $comment->delete();

        return back()->withSuccess('Comment has been deleted');
    }

    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('project.show', $task->board->project->id)->withSuccess('Task has been deleted');
    }
}