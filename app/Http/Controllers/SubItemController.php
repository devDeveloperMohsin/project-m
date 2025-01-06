<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subtask;

class SubItemController extends Controller
{
    public function store(Request $request)
    {
        $validData = $request->validateWithBag('task', [
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'title' => ['required', 'string', 'max:400'],
            'description' => ['nullable', 'present'],
            'status' => ['required', 'string', 'max: 191'],
            'priority' => ['required', 'string', 'max: 191'],
            'type' => ['required', 'string', 'max: 191'],
            'due_date' => ['required', 'string', 'max: 191'],
            'assigned_to' => ['required', 'integer', 'min:0', 'exists:users,id'],
        ]);

        // dd($validData);

        $subtask = Subtask::create($validData);

        // Assign User
        // $subtask->users()->attach($validData['assigned_to'], ['role' => Subtask::ROLE_MEMBER]);

        // Add History
        // $subtask->history()->create(['user_id' => Auth::id(), 'type' => SubtaskHistory::TYPE_TASK_CREATED, 'data' => json_encode(['title' => $task->title])]);

        return back()->withSuccess('Task has been added');
    }
}
