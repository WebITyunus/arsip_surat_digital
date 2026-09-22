<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Surat Masuk
            'surat-masuk.view',
            'surat-masuk.create',
            'surat-masuk.edit',
            'surat-masuk.delete',

            // Surat Keluar
            'surat-keluar.view',
            'surat-keluar.create',
            'surat-keluar.edit',
            'surat-keluar.delete',

            // Agenda Surat Keputusan
            'agenda-sk.view',
            'agenda-sk.create',
            'agenda-sk.edit',
            'agenda-sk.delete',

            // Surat Edaran
            'surat-edaran.view',
            'surat-edaran.create',
            'surat-edaran.edit',
            'surat-edaran.delete',

            // Nota Dinas
            'nota-dinas.view',
            'nota-dinas.create',
            'nota-dinas.edit',
            'nota-dinas.delete',

            // Berita Acara
            'berita-acara.view',
            'berita-acara.create',
            'berita-acara.edit',
            'berita-acara.delete',

            // PKS
            'pks.view',
            'pks.create',
            'pks.edit',
            'pks.delete',

            // Sertifikat
            'sertifikat.view',
            'sertifikat.create',
            'sertifikat.edit',
            'sertifikat.delete',

            // SPO
            'spo.view',
            'spo.create',
            'spo.edit',
            'spo.delete',

            // Peraturan Direktur
            'peraturan-direktur.view',
            'peraturan-direktur.create',
            'peraturan-direktur.edit',
            'peraturan-direktur.delete',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Role
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $petugas = Role::firstOrCreate([
            'name' => 'petugas',
            'guard_name' => 'web',
        ]);

        // Super Admin mendapatkan semua permission
        $superAdmin->givePermissionTo(
            Permission::all()
        );

        // Admin
        $admin->givePermissionTo([
            'surat-masuk.view',
            'surat-masuk.create',
            'surat-masuk.edit',
            'surat-masuk.delete',

            'surat-keluar.view',
            'surat-keluar.create',
            'surat-keluar.edit',
            'surat-keluar.delete',

            'agenda-sk.view',
            'agenda-sk.create',
            'agenda-sk.edit',
            'agenda-sk.delete',

            'surat-edaran.view',
            'surat-edaran.create',
            'surat-edaran.edit',
            'surat-edaran.delete',

            'nota-dinas.view',
            'nota-dinas.create',
            'nota-dinas.edit',
            'nota-dinas.delete',

            'berita-acara.view',
            'berita-acara.create',
            'berita-acara.edit',
            'berita-acara.delete',

            'pks.view',
            'pks.create',
            'pks.edit',
            'pks.delete',

            'sertifikat.view',
            'sertifikat.create',
            'sertifikat.edit',
            'sertifikat.delete',

            'spo.view',
            'spo.create',
            'spo.edit',
            'spo.delete',

            'peraturan-direktur.view',
            'peraturan-direktur.create',
            'peraturan-direktur.edit',
            'peraturan-direktur.delete',

            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
        ]);

        // Petugas
        $petugas->givePermissionTo([
            'surat-masuk.view',
            'surat-masuk.create',
            'surat-masuk.edit',

            'surat-keluar.view',
            'surat-keluar.create',
            'surat-keluar.edit',

            'agenda-sk.view',
            'agenda-sk.create',
            'agenda-sk.edit',

            'surat-edaran.view',
            'surat-edaran.create',
            'surat-edaran.edit',

            'nota-dinas.view',
            'nota-dinas.create',
            'nota-dinas.edit',

            'berita-acara.view',
            'berita-acara.create',
            'berita-acara.edit',

            'pks.view',
            'pks.create',
            'pks.edit',

            'sertifikat.view',
            'sertifikat.create',
            'sertifikat.edit',

            'spo.view',
            'spo.create',
            'spo.edit',

            'peraturan-direktur.view',
            'peraturan-direktur.create',
            'peraturan-direktur.edit',
        ]);
    }
}
