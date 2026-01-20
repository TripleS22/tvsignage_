<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Roles:
     * - Superadmin: Akses penuh ke semua fitur
     * - JalanRasa: Bisa semua kecuali settings, hanya akses data sendiri
     * - Arnes: Bisa semua kecuali settings, hanya akses data sendiri
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions
        $permissions = [
            // Media permissions
            'media.view',
            'media.create',
            'media.edit',
            'media.delete',
            
            // Gabungan permissions
            'gabungan.view',
            'gabungan.create',
            'gabungan.edit',
            'gabungan.delete',
            
            // Outlet permissions
            'outlet.view',
            'outlet.create',
            'outlet.edit',
            'outlet.delete',
            
            // Settings permissions (hanya untuk Superadmin)
            'settings.view',
            'settings.edit',
            
            // User management (hanya untuk Superadmin)
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            
            // Role management (hanya untuk Superadmin)
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Roles
        // 1. Superadmin - akses penuh
        $superadmin = Role::firstOrCreate(['name' => 'Superadmin']);
        $superadmin->givePermissionTo(Permission::all());

        // 2. JalanRasa - semua kecuali settings & user/role management
        $jalanRasa = Role::firstOrCreate(['name' => 'JalanRasa']);
        $jalanRasa->givePermissionTo([
            'media.view',
            'media.create',
            'media.edit',
            'media.delete',
            'gabungan.view',
            'gabungan.create',
            'gabungan.edit',
            'gabungan.delete',
            'outlet.view',
            'outlet.create',
            'outlet.edit',
            'outlet.delete',
        ]);

        // 3. Arnes - semua kecuali settings & user/role management
        $arnes = Role::firstOrCreate(['name' => 'Arnes']);
        $arnes->givePermissionTo([
            'media.view',
            'media.create',
            'media.edit',
            'media.delete',
            'gabungan.view',
            'gabungan.create',
            'gabungan.edit',
            'gabungan.delete',
            'outlet.view',
            'outlet.create',
            'outlet.edit',
            'outlet.delete',
        ]);

        $this->command->info('Roles dan Permissions berhasil dibuat!');
        $this->command->info('- Superadmin: Akses penuh');
        $this->command->info('- JalanRasa: Akses data sendiri, tanpa settings');
        $this->command->info('- Arnes: Akses data sendiri, tanpa settings');
    }
}
