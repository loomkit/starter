<?php

namespace Database\Seeders;

use App\Enums\AdminRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', env('ADMIN_USER_ROLE', AdminRole::SuperAdmin))->firstOrFail();
        $adminProvider = env('ADMIN_AUTH_PROVIDER', 'admins');
        $adminModel = config("auth.providers.{$adminProvider}.model");
        $adminModel::create([
            'name' => env('ADMIN_USER_NAME', config('app.name')),
            'email' => env('ADMIN_USER_EMAIL', 'admin@example.com'),
            'password' => bcrypt(env('ADMIN_USER_PASSWORD', 'password')),
        ])->assignRole($adminRole);
    }
}
