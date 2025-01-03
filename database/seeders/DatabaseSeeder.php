<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Enum\RolesEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $commenterRole = Role::create(['name' => RolesEnum::Commenter->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

        $manageFeaturesPermission = Permission::create(['name' => PermissionEnum::ManageFeatures->value]);
        $manageUsersPermission = Permission::create(['name' => PermissionEnum::ManageUsers->value]);
        $manageCommentsPermission = Permission::create(['name' => PermissionEnum::ManageComments->value]);
        $upvoteDownvotePermission = Permission::create(['name' => PermissionEnum::UpvoteDownvote->value]);

        $userRole->syncPermissions([$upvoteDownvotePermission]);
        $commenterRole->syncPermissions([$upvoteDownvotePermission, $manageCommentsPermission]);
        $adminRole->syncPermissions([
            $manageFeaturesPermission,
            $manageUsersPermission,
            $manageCommentsPermission,
            $upvoteDownvotePermission,
        ]);

        User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ])->assignRole(RolesEnum::Commenter);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);
    }
}
