<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::withCount('bookings')->latest()->paginate(20);
        $roles = \Spatie\Permission\Models\Role::where('guard_name', 'employee')->get();

        return view('crm.employees.index', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
        ]);

        $employee = Employee::create($data);

        $employee->assignRole($request->role);

        return back()->with('success', 'تم إضافة الموظف');
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:6',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $employee->update($data);

        $employee->syncRoles([$request->role]);

        return back()->with('success', 'تم تحديث بيانات الموظف');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return back()->with('success', 'تم حذف الموظف');
    }
}
