<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class WorkspaceController extends Controller
{
    /**
     * The index function retrieves all workspaces and passes them to the workspaces view.
     *
     * @return a view called 'workspaces' and passing the variable  to the view.
     */
    public function index()
    {
        $workspaces = Auth::user()->workspaces;
        return view('workspaces', compact('workspaces'));
    }

    /**
     * The store function in PHP validates and stores workspace data, then returns to the previous page
     * with a success message.
     *
     * @param Request request The  parameter is an instance of the Request class, which
     * represents an HTTP request made to the server. It contains all the data and information sent by
     * the client in the request.
     *
     * @return The code is returning a redirect back to the previous page with a success message.
     */
    public function store(Request $request)
        {
            $validData = $request->validateWithBag('workspace', [
                'name' => ['required', 'string', 'max:60'],
                'cover' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('5mb')
                        ->dimensions(Rule::dimensions()->maxWidth(4250)->maxHeight(886))
                ],
                'icon' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('5mb')
                        ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))
                ],
            ]);

            $workspace = Workspace::create($validData);

            // Add Media
            if ($request->hasFile('cover')) {
                $workspace->addMediaFromRequest("cover")
                    ->toMediaCollection('cover');
            }

            if ($request->hasFile('icon')) {
                $workspace->addMediaFromRequest("icon")
                    ->toMediaCollection('icon');
            }

            // Attach the user who created the workspace
            $workspace->users()->attach(Auth::id(), ['role' => Workspace::ROLE_ADMIN]);

            return back()->withSuccess('Workspace has been created');
        }


    /**
     * The function updates the cover image of a workspace in a PHP application, validating the file
     * size, dimensions, and format before saving it.
     *
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the current HTTP request made to the server and contains all the data and
     * information related to the request.
     * @param id The "id" parameter is the identifier of the workspace that needs to be updated. It is
     * used to find the specific workspace record in the database using the "findOrFail" method.
     *
     * @return a redirect back to the previous page with a success message.
     */
    public function updateCover(Request $request, $id)
    {
        $request->validateWithBag('workspace', [
            'cover' => [
                'required',
                File::image()
                    ->min('1kb')
                    ->max('5mb')
                    ->dimensions(Rule::dimensions()->maxWidth(4250)->maxHeight(886))
            ],
        ]);

        $workspace = Workspace::findOrFail($id);

        if ($request->hasFile('cover')) {
            $workspace->clearMediaCollection('cover');
            $workspace->addMediaFromRequest('cover')
                ->toMediaCollection('cover');
        }

        return back()->withSuccess('Workspace Cover has been updated');
    }

    /**
     * The function updates a workspace's name and icon based on the request data and returns a success
     * message.
     *
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains all the data sent with the
     * request, such as form inputs, query parameters, and uploaded files.
     * @param id The "id" parameter is the identifier of the workspace that needs to be updated. It is
     * used to find the specific workspace record in the database.
     *
     * @return a redirect back to the previous page with a success message.
     */
    public function update(Request $request, $id)
    {
        $request->validateWithBag('workspace', [
            'name' => ['required', 'string', 'max:60'],
            'icon' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('5mb')
                    ->dimensions(Rule::dimensions()->maxWidth(500)->maxHeight(500))
            ],
        ]);

        $workspace = Workspace::findOrFail($id);
        $workspace->name = $request->name;
        $workspace->save();

        if ($request->hasFile('icon')) {
            $workspace->clearMediaCollection('icon');
            $workspace->addMediaFromRequest('icon')
                ->toMediaCollection('icon');
        }

        return back()->withSuccess('Workspace has been updated');
    }

    /**
     * The show function retrieves a workspace by its ID and returns a view with the workspace details.
     *
     * @param id The "id" parameter is used to identify the specific workspace that needs to be shown.
     * It is typically an integer value that corresponds to the unique identifier of the workspace in
     * the database.
     *
     * @return a view called 'workspaceDetails' and passing the 'workspace' variable to the view.
     */
    public function show($id)
        {
            $workspace = Auth::user()->workspaces()->with('users', 'invites', 'projects')->findOrFail($id);

            $users = User::all();
            $roles = Role::all();
            $hasRoles = $workspace->users->pluck('id');

            return view('workspaceDetails', compact('workspace', 'users', 'roles', 'hasRoles'));
        }


    public function destroy($id)
    {
        $workspace = Workspace::findOrFail($id);
        $workspace->delete();

        return redirect()->route('workspaces')->withSuccess('Workspace has been deleted');
    }

    /**
     * The starToggle function toggles the star status of a workspace and returns a success message
     * indicating whether the workspace has been marked or unmarked.
     *
     * @param id The "id" parameter is the identifier of the workspace that needs to be toggled.
     *
     * @return a redirect back to the previous page with a success message. The success message
     * indicates whether the workspace has been marked or unmarked as a star.
     */
    public function starToggle(int $id)
    {
        $workspace = Auth::user()->workspaces()->findOrFail($id);
        $workspace->pivot->star = !$workspace->pivot->star;
        $workspace->pivot->save();

        return back()->withSuccess('Workspace has been ' . ($workspace->pivot->star ? 'marked' : 'unmarked'));
    }

    public function markedWorkspaces(int $userId = null)
    {
        $query = DB::table('workspace_users')->select('workspaces.id AS id', 'workspaces.name AS name')->join('workspaces', 'workspace_users.workspace_id', '=', 'workspaces.id')->where('star', true);
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        $workspaces = $query->get();
        return $workspaces;
    }

    public function revokeAccess($id, $userId) {
        $workspace = Workspace::findOrFail($id);
        $workspace->users()->detach($userId);
        return back()->withSuccess('Workspace access has been revoked');
    }
}
