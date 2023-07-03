<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      app()[PermissionRegistrar::class]->forgetCachedPermissions();

      // Permission modules
        $proyek_modules = [
          'view proyek',
          'create proyek',
          'update proyek',
          'delete proyek',
        ];

        $rab_modules = [
          'view rab',
          'create rab',
          'update rab',
          'delete rab',
        ];

        $rap_modules = [
          'view rap',
          'create rap',
          'update rap',
          'delete rap',
        ];


      // Creating Permissions

        foreach ($proyek_modules as $module) {
          Permission::create(['name' => $module]);
        }

        foreach ($rab_modules as $module) {
          Permission::create(['name' => $module]);
        }

        foreach ($rap_modules as $module) {
          Permission::create(['name' => $module]);
        }


      // Creating roles

        $admin = Role::create(['name' => 'admin']);
        $manajer_proyek = Role::create(['name' => 'manajer proyek']);
        $kepala_divisi = Role::create(['name' => 'kepala divisi']);
        $direktur_utama = Role::create(['name' => 'direktur utama']);
        $keuangan = Role::create(['name' => 'keuangan']);


      // Give permissions to each role

        $admin->givePermissionTo(Permission::all());

        $manajer_proyek->givePermissionTo([
          'view proyek',
          'view rab',
          'view rap', 'create rap', 'update rap', 'delete rap'
        ]);

        $kepala_divisi->givePermissionTo([
          'view proyek', 'create proyek', 'update proyek', 'delete proyek',
          'view rab', 'create rab', 'update rab', 'delete rab',
          'view rap',
        ]);

        $direktur_utama->givePermissionTo([
          'view proyek',
          'view rab',
          'view rap'
        ]);

        $keuangan->givePermissionTo([
          'view proyek',
          'view rab',
          'view rap'
        ]);


      // Assigning roles to users
      
        User::factory()->count(1)->create([
          'email' => 'admin@gmail.com'
        ])->each(function ($user) {
            $user->assignRole('admin');
        });
        
        User::factory()->count(1)->create([
          'email' => 'manajer.proyek@gmail.com'
        ])->each(function ($user) {
            $user->assignRole('manajer proyek');
        });

        User::factory()->count(1)->create([
          'email' => 'kepala.divisi@gmail.com'
        ])->each(function ($user) {
            $user->assignRole('kepala divisi');
        });

        User::factory()->count(1)->create([
          'email' => 'direktur.utama@gmail.com'
        ])->each(function ($user) {
            $user->assignRole('direktur utama');
        });

        User::factory()->count(1)->create([
          'email' => 'keuangan@gmail.com'
        ])->each(function ($user) {
            $user->assignRole('keuangan');
        });
    }
}
