<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class userManagementController extends Controller
{
    //=============== USER MANAGEMENT ============
    public function index(){
        $users = User::all();
        return view('user_management.index', compact('users'));
    }

    public function create(){
        $roles = Role::all();
        return view('user_management.create', compact('roles'));
    }

    public function store(Request $request){

          if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('user_photos', 'public');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image_path,
            'role' => $request->role,
        ]);
        $user->syncRoles($request->role);
        return redirect()->route('management.user.index')->with('success', 'successfully added new user');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $user_role = $user->roles[0];
        $roles = Role::all();
        // return $role->name;
        // return $user;
        return view('user_management.edit', compact(['user', 'user_role', 'roles']));
    }

    public function update(Request $request){
        $user = User::findOrFail($request->id);
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
            ];

        // update password hanya jika diisi
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }
        // $user->assignRole($request->role);
        $user->syncRoles($request->role);
        $user->update($data);
        return redirect()->route('management.user.index')->with('success', 'User successfully updated');
    }

    public function delete($id){
        User::destroy($id);
        return redirect()->route('management.user.index')->with('success', 'User successfully deleted');
    }

    //========== PERMISSION MANAGEMENT ==========

    //==========ROLE==========

    public function role_index(){
        $roles = Role::all();
        return view('user_management.permission.index_role', compact('roles'));
    }

    public function role_create(){
        $permissions = Permission::all();
        return view('user_management.permission.create_role', compact('permissions'));
    }

    public function role_store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permission);
        return redirect()->route('management.role.index')->with('success', 'Role successfully created');
    }

    public function role_edit($id){
        $role = Role::findOrFail($id);
        $role_has_permissions = $role->permissions;
        // return $role_has_permissions;
        $permissions = Permission::all();
        return view('user_management.permission.edit_role', compact(['role', 'permissions']));
    }

    public function role_update(Request $request){
        
        $role = Role::findOrFail($request->id);
        $role->update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->permission);
        return redirect()->route('management.role.index')->with('success', 'Role successfully updated');
    }
    
    public function role_delete($id){
        Role::destroy($id);
        return redirect()->route('management.role.index')->with('success', 'Role successfully deleted');
    }


//==PERMISSION== 

    // public function permission_index(){
    //     $permissions = permission::all();
    //     return view('user_management.permission.index_permission', compact('permissions'));
    // }

    // public function permission_create(){
    //     return view('user_management.permission.create_permission');
    // }

    // public function permission_store(Request $request){
    //      $request->validate([
    //             'name' => 'required|string|unique:permissions,name',
    //         ]);

    //         permission::create(['name' => $request->name]);

    //         return redirect()->route('management.permission.index')->with('success', 'permission successfully created');
    // }
    
    // public function permission_delete($id){
    //     permission::destroy($id);
    //     return redirect()->route('management.permission.index')->with('success', 'permission successfully deleted');
    // }
}
