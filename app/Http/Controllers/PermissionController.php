<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::get();
        return view('permissions.index', compact('permissions'));
    }

    public function create(){
        return view('permissions.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3'
        ]);

        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permission.index')->with('success', 'Permission created successfully!');
        } else {
            return redirect()->route('permission.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id){
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);

        if($validator->passes()){
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permission.index')->with('success', 'Permission updated successfully!');
        } else {
            return redirect()->route('permission.edit', $id)->withInput()->withErrors($validator);
        }
    }

    public function destroy($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully!');
    }
}
