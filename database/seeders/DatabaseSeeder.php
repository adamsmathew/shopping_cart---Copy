<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Define roles
        $roles = ['admin', 'staff'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Define permissions
        $permissions = [
            'add product',
            'edit product',
            'delete product',
            'view product',
            'list products'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions($permissions); // Admin gets all permissions

        $staffRole = Role::where('name', 'staff')->first();
        $staffRole->syncPermissions(['view product', 'list products']); // Staff only views products

        // Create Users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Staff User',
                'email' => 'staff@example.com',
                'password' => bcrypt('password'),
                'role' => 'staff'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => $userData['password']]
            );
            $user->assignRole($userData['role']);
        }

        $this->command->info('Admin and Staff Users Created Successfully!');
    }
}
