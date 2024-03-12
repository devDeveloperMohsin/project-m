<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Project;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function store(Request $request)
    {
        $validData = $request->validateWithBag('board', [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'name' => ['required', 'string', 'max:60'],
        ]);

        Board::create($validData);
        return back()->withSuccess('Board has been created');
    }


    public function update(Request $request, $id)
    {
        $validData = $request->validateWithBag('board', [
            'name' => ['required', 'string', 'max:60'],
            'sorting' => ['required', 'integer', 'min:1', 'max:999999'],
            'close' => ['nullable', 'boolean'],
        ]);

        $board = Board::findOrFail($id);
        $board->name = $validData['name'];
        $board->closed = isset($validData['close']) ? 1 : 0;
        $board->sorting = $validData['sorting'];
        $board->save();

        return back()->withSuccess('Board has been updated');
    }

    public function history(Request $request, $id) {
        $project = Project::findOrFail($id);
        $boards = Board::where('project_id', $id)->get();
        return view('boardsHistory', compact('boards', 'project'));
    }

    public function destroy($id)
    {
        $board = Board::findOrFail($id);
        $board->delete();

        return back()->withSuccess('Board has been deleted');
    }
}
