<?php

namespace App\Http\Controllers;

use App\Models\PagePermission;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index()
    {
        $permissions = PagePermission::orderBy('id')->get();
        return view('authorization.index', compact('permissions'));
    }

    public function update(Request $request)
    {
        $permissions = PagePermission::orderBy('id')->get();

        $oldValues = [];
        $newValues = [];

        foreach ($permissions as $perm) {
            $requestKey    = str_replace('.', '_', $perm->key);
            $newSupervisor = $request->boolean("supervisor.{$requestKey}");
            $newOperator   = $request->boolean("operator.{$requestKey}");

            $label = $perm->label;

            // Record only rows that actually changed
            if ((bool)$perm->supervisor !== $newSupervisor || (bool)$perm->operator !== $newOperator) {
                $oldValues[$label] = 'Supervisor: ' . ($perm->supervisor ? 'Yes' : 'No') . ', Operator: ' . ($perm->operator ? 'Yes' : 'No');
                $newValues[$label] = 'Supervisor: ' . ($newSupervisor ? 'Yes' : 'No') . ', Operator: ' . ($newOperator ? 'Yes' : 'No');
            }

            $perm->update([
                // Admin is always true — never touch it
                'supervisor' => $newSupervisor,
                'operator'   => $newOperator,
            ]);
        }

        PagePermission::clearCache();

        AuditLogger::log(
            'permissions_updated',
            'Authorization',
            null,
            empty($oldValues) ? 'Saved page permissions (no changes)' : 'Updated page permissions for ' . count($oldValues) . ' screen(s)',
            $oldValues ?: null,
            $newValues ?: null
        );

        return redirect()->route('authorization.index')
            ->with('success', 'Permissions saved successfully.');
    }
}
