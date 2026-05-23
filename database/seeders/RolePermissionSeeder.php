<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

        $permissions = [

            // User Management
            'manage-users',
            'manage-permissions',

            // Team Management
            'manage-teams',
            'manage-agents',

            // Ticket Management
            'view-all-tickets',
            'assign-tickets',
            'reassign-team-tickets',
            'view-assigned-tickets',
            'update-ticket-status',
            'resolve-tickets',

            // Reports
            'view-reports',

            // Monitoring
            'monitor-team-performance',

            // Customer Actions
            'create-tickets',
            'view-own-tickets',
            'reply-to-tickets',
            'upload-attachments',

            // Comments
            'add-comments',
        ];

        foreach ($permissions as $perm) {

            Permission::firstOrCreate([
                'name' => $perm
            ]);
        }

        // Roles

        $superadmin = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        $teamLeader = Role::firstOrCreate([
            'name' => 'Team Leader'
        ]);

        $supportAgent = Role::firstOrCreate([
            'name' => 'Support Agent'
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'Customer'
        ]);

        // Super Admin
        $superadmin->syncPermissions(Permission::all());

        // Admin
        $admin->syncPermissions([
            'manage-teams',
            'manage-agents',
            'assign-tickets',
            'view-reports',
        ]);

        // Team Leader
        $teamLeader->syncPermissions([
            'manage-teams',
            'monitor-team-performance',
            'reassign-team-tickets',
        ]);

        // Support Agent
        $supportAgent->syncPermissions([
            'view-assigned-tickets',
            'update-ticket-status',
            'add-comments',
            'resolve-tickets',
        ]);

        // Customer
        $customer->syncPermissions([
            'create-tickets',
            'view-own-tickets',
            'reply-to-tickets',
            'upload-attachments',
        ]);
    }
}