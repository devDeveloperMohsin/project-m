<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Workspace;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InvitationNotification;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $validData = $request->validateWithBag('invitation', [
            'id' => ['required', 'integer'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'type' => ['required', 'string', 'in:' . implode(',', Invitation::MODELS)],
        ]);

        DB::transaction(function () use ($validData) {
            $invitationFor = "";
            if ($validData['type'] == 'workspace') {
                $model = Workspace::findOrFail($validData['id']);
                $invitationFor = $model->name . ' workspace';
            }

            if ($validData['type'] == 'project') {
                $model = Project::findOrFail($validData['id']);
                $invitationFor = $model->name . ' project';
            }

            $token = bcrypt(Str::random(50));
            // Create Invitaion
            $invitation = new Invitation();
            $invitation->email = $validData['email'];
            $invitation->model = $validData['type'];
            $invitation->model_id = $validData['id'];
            $invitation->token = $token;
            $invitation->expires = now()->addDays(3);
            $invitation->save();

            $invitation->for = $invitationFor;
            $invitation->by = Auth::user()->name;
            $invitation->link = $this->getInviteUrl($token);

            // Send email to user
            Mail::to($validData['email'])->send(new InvitationMail($invitation));
        });

        return back()->withSuccess('Invitation email has been sent');
    }

    public function resend($id)
    {
        $invite = Invitation::findOrFail($id);
        $invitationFor = "";
        if ($invite->model == 'workspaces') {
            $model = Workspace::findOrFail($invite->model_id);
            $invitationFor = $model->name;
            $admins = $model->admins;
        }

        if ($invite->model == 'project') {
            $model = Project::findOrFail($invite->model_id);
            $invitationFor = $model->name;
            $admins = $model->admins;
        }

        $invite->expires = now()->addDays(3);
        $invite->save();

        $invite->for = $invitationFor;
        $invite->by = Auth::user()->name;
        $invite->link = $this->getInviteUrl($invite->token);
        Mail::to($admins)->send(new InvitationMail($invite));

        return back()->withSuccess('Invitation has been re-sent');
    }

    public function destroy($id)
    {
        Invitation::destroy($id);
        return back()->withSuccess('Invitation has been deleted');
    }

    public function joinTeam(Request $request)
    {
        // If token is not present then redirect to homepage
        if (empty($request->get('token'))) {
            return to_route('homepage');
        }

        // Find the invitation
        $invitation = Invitation::where('token', $request->token)->first();
        if (!$invitation) {
            abort(403);
        }

        // Check if Invitation has been expired
        if ($invitation->expires < now()) {
            abort(403);
        }

        // Check if user is Registered
        $user = User::where('email', $invitation->email)->first();
        if (!$user) {
            return to_route('login');
        }

        if ($invitation->model == 'workspace') {
            $model = Workspace::findOrFail($invitation->model_id);
            $model->users()->attach($user->id, ['role' => Workspace::ROLE_MEMBER]);

            // Delete the invite
            $invitation->delete();

            // Notify the workspace admin
            $name = $user->name;
            $m = 'workspace ' . Str::title($model->name);
            Notification::send(User::findOrFail(1), new InvitationNotification($name, $m));
            return to_route('workspaces.show', ['id' => $model->id]);
        }

        if ($invitation->model == 'project') {
            $model = Project::findOrFail($invitation->model_id);
            $model->users()->attach($user->id, ['role' => Project::ROLE_MEMBER]);

            // In case of project we will add the user to that workspace as well as member
            $model->workspace->users()->attach($user->id, ['role' => Workspace::ROLE_MEMBER]);

            // Delete the invite
            $invitation->delete();

            // Notify the workspace admin
            $name = $user->name;
            $m = 'project ' . Str::title($model->name);
            Notification::send(User::findOrFail(1), new InvitationNotification($name, $m));
            return to_route('project.show', ['id' => $model->id]);
        }

        return to_route('homepage');
    }

    public function getInviteUrl($token)
    {
        return config('app.url') . '/collaborate?token=' . $token;
    }
}
