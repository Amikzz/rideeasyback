<?php
//
//namespace Database\Seeders;
//
//use Illuminate\Database\Seeder;
//use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\PermissionRegistrar;
//
//class RolesAndPermissionsSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     */
//    public function run(): void
//    {
//        // Reset cached roles and permissions
//        app()[PermissionRegistrar::class]->forgetCachedPermissions();
//
//        // Create permissions
//        Permission::create(['name' => 'view dashboard']);
//        Permission::create(['name' => 'manage users']);
//        Permission::create(['name' => 'manage buses']);
//        Permission::create(['name' => 'view schedules']);
//        Permission::create(['name'=> 'tickets']);
//        Permission::create(['name'=> 'view routes']);
//        Permission::create(['name'=> 'view busdriverconductor']);
//        Permission::create(['name'=> 'cancel trip']);
//
//        // Create roles and assign existing permissions
//        $role = Role::create(['name' => 'admin']);
//        $role->givePermissionTo(['view dashboard', 'manage users', 'manage buses', 'view schedules', 'view routes', 'view busdriverconductor']);
//
//        $role = Role::create(['name' => 'conductor']);
//        $role->givePermissionTo(['view dashboard', 'view schedules', 'tickets', 'cancel trip']);
//    }
//}
