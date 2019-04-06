<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@local',
            'password' => bcrypt('admin'),
        ]);
        $user->assignRole('admin');
    }
}
