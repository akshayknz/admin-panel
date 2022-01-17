<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::findOrCreate('view bookings');
        Permission::findOrCreate('view top treks');
        Permission::findOrCreate('view clients');
        Permission::findOrCreate('view cities');
        Permission::findOrCreate('view states');
        Permission::findOrCreate('view age');
        Permission::findOrCreate('view revenue');
        Permission::findOrCreate('view tth data');
        Permission::findOrCreate('user management');
        Permission::findOrCreate('role management');

        // create roles and assign created permissions
        
        // or may be done by chaining
        $role = Role::firstOrCreate(['name' => 'staff'])
            ->givePermissionTo([
                'view bookings', 'view top treks',
                'view clients','view states',
                'view age','view revenue','view tth data'
            ]);

        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        $user = User::where(['email' => 'admin@tth.com'])->first();
        $user->assignRole($role);
    }
}
