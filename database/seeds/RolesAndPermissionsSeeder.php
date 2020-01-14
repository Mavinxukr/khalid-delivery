<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'invoices',
            'clients',
            'contacts',
            'payments',
            'teams',
            'users',
            'roles',
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['group' => $item, 'name' => 'view ' . $item]);
            Permission::create(['group' => $item, 'name' => 'view own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage ' . $item]);
            Permission::create(['group' => $item, 'name' => 'manage own ' . $item]);
            Permission::create(['group' => $item, 'name' => 'restore ' . $item]);
            Permission::create(['group' => $item, 'name' => 'forceDelete ' . $item]);
        });

        // Create a Super-Admin Role and assign all permissions to it
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        $role =  Role::create(['name' => 'user']);
        $role->givePermissionTo(Permission::all());
        $role =  Role::create(['name' => 'company']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        $user = App\User::whereEmail('admin@gmail.com')->first(); // enter your email here
        $user->assignRole('super-admin');
        $user = App\User::whereEmail('ediksadon@gmail.com')->first(); // enter your email here
        $user->assignRole('user');
        $user = App\User::whereEmail('pashaios@gmail.com')->first(); // enter your email here
        $user->assignRole('user');
    }
}
