<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request) {
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

    public function show(Request $request) {
        $request->validate([
            'id' => ['required','integer','min:1'],
        ]);
        
        $task = Task::findOrFail($request->get('id'));
        return view('taskDetails', compact('task'));
    }
}