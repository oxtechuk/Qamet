<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'employee')->withCount('users')->latest()->paginate(20);

        return view('crm.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'employee')->get();

        return view('crm.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->where('guard_name', 'employee'),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'employee',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('crm.roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::where('guard_name', 'employee')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('crm.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id)->where('guard_name', 'employee'),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('crm.roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return back()->withErrors(['error' => 'لا يمكن حذف دور مدير النظام الأساسي']);
        }

        $role->delete();

        return redirect()->route('crm.roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
