<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Get the authenticated User with relations needed for ERP SPA
     */
    public function me(Request $request)
    {
        $user = $request->user()->load(['activeCompany', 'roles', 'permissions']);
        
        $companies = $user->companies;

        if ($user->is_super_admin && $companies->isEmpty()) {
            // Super admin has access to all companies if needed
            $companies = \App\Models\Company::all();
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'locale' => $user->preferred_locale,
                'is_super_admin' => $user->is_super_admin,
            ],
            'active_company' => $user->activeCompany,
            'companies' => $companies,
            'roles' => $user->roles->pluck('name'),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * Switch Active Company
     */
    public function switchCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $user = $request->user();

        if ($user->switchCompany($request->company_id)) {
            return response()->json(['message' => 'Company switched successfully.']);
        }

        return response()->json(['message' => 'Unauthorized to access this company.'], 403);
    }
}
