<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workspace;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $roles=Role::get();
        $permissions=Permission::get();

        // $workspace = Workspace::with('users','invites', 'projects')->findOrFail($id);

        return view('roles.index',compact('roles','permissions'));

    }
    public function create(){
        $permissions=Permission::get();
        return view('roles.create',compact('permissions'));

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if($validator->passes()){
            $role=Role::create(['name' => $request->name]);

            if(!empty($request->permission)){
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('role.index')->with('success', 'role created successfully!');
        } else {
            return redirect()->route('role.create')->withInput()->withErrors($validator);
        }
    }
    public function edit($id){
        $role=Role::findorFail($id);
        $hasPermissions=$role->permissions->pluck('name');
        $permissions=Permission::get();
        return view('roles.edit',compact('role','hasPermissions','permissions'));
    }
    public function update($id, Request $request){
        $role=Role::findorFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.',id'
        ]);

        if($validator->passes()){
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')->with('success', 'role created successfully!');
        } else {
            return redirect()->route('role.edit')->withInput()->withErrors($validator);
        }

    }
    public function destroy($id){
        $role=Role::findorFail($id);
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role deleted successfully!');
    }
}
