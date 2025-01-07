<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users=User::get();
        return view('workspaceDetails',compact('users'));
    }

    public function edit(string $id)
    {
        $user=User::findorFail($id);
        $roles=Role::get();
        $hasRoles=$user->roles->pluck('id');
        return view('users.edit',compact('user','roles','hasRoles'));
    }

    public function update(Request $request, string $id)
    {
        $user=User::findorFail($id);
        

        $validator=Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);
        if($validator->fails()){
            return redirect()->route('workspaces')->withInput()->withErrors($validator);
        }

        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        $user->syncRoles($request->role);
        return redirect()->route('workspaces');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::findorFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}