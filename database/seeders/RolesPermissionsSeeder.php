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
          'create & modify proyek'
        ];

        $rab_modules = [
          'view rab',
          'create & modify rab',
          'approve rab'
        ];

        $rap_modules = [
          'view rap',
          'create & modify rap',
          'approve rap'
        ];

        $pengajuan_dana_modules = [
          'view pengajuan dana',
          'create & modify pengajuan dana',
          'approve pengajuan dana'
        ];

        $pencairan_dana_modules = [
          'view pencairan dana',
          'create & modify pencairan dana',
          'confirm pencairan dana'
        ];

        $penagihan_modules = [
          'view penagihan',
          'create & modify penagihan',
          'confirm penagihan'
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

        foreach ($pengajuan_dana_modules as $module) {
          Permission::create(['name' => $module]);
        }

        foreach ($pencairan_dana_modules as $module) {
          Permission::create(['name' => $module]);
        }

        foreach ($penagihan_modules as $module) {
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
          'view rap', 'create & modify rap',
          'view pengajuan dana', 'create & modify pengajuan dana',
          'view pencairan dana', 'confirm pencairan dana',
          'view penagihan'
        ]);

        $kepala_divisi->givePermissionTo([
          'view proyek', 'create & modify proyek',
          'view rab', 'create & modify rab', 'approve rab',
          'view rap', 'approve rap',
          'view pengajuan dana', 'create & modify pengajuan dana', 'approve pengajuan dana',
          'view pencairan dana',
          'view penagihan'
        ]);

        $direktur_utama->givePermissionTo([
          'view proyek',
          'view rab',
          'view rap',
          'view pengajuan dana', 'create & modify pengajuan dana',
          'view pencairan dana',
          'view penagihan', 'confirm penagihan'
        ]);

        $keuangan->givePermissionTo([
          'view proyek',
          'view rab',
          'view rap',
          'view pengajuan dana', 'create & modify pengajuan dana',
          'view pencairan dana', 'create & modify pencairan dana',
          'view penagihan', 'create & modify penagihan'
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
