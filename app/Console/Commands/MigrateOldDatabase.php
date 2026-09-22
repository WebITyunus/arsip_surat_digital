<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class MigrateOldDatabase extends Command
{
    protected $signature = 'migrate:old-database
                            {--users : Migrasi users}
                            {--surat-masuk : Migrasi surat masuk}
                            {--surat-keluar : Migrasi surat keluar}
                             {--agenda-surat-keputusan : Migrasi agenda surat keputusan}
                             {--surat-edaran : Migrasi surat edaran}
                             {--nota-dinas : Migrasi nota dinas}
                             {--berita-acara : Migrasi berita acara}
                             {--pks : Migrasi PKS}
                             {--sertifikat : Migrasi sertifikat}
                             {--spo : Migrasi SPO}
                             {--files : Migrasi semua file}
                             {--files-surat-masuk : Migrasi file surat masuk}
                             {--file-surat-keluar : Migrasi file surat keluar}
                             {--files-agenda-surat-keputusan : Migrasi file agenda surat keputusan}
                             {--files-surat-edaran : Migrasi file surat edaran}
                             {--files-berita-acara : Migrasi file berita acara}
                             {--files-sertifikat : Migrasi file sertifikat}
                             {--files-nota-dinas : Migrasi file nota dinas}
                             {--files-spo : Migrasi file SPO}
                             {--files-peraturan-direktur : Migrasi file Peraturan Direktur}
                             {--peraturan-direktur : Migrasi peraturan direktur}';


    protected $description = 'Migrasi data dari database e_arsip ke arsip_digital';

public function handle()
{
    if ($this->option('users')) {
        $this->migrateUsers();
    }

    if ($this->option('peraturan-direktur')) {
    $this->migratePeraturanDirektur();
}

    if ($this->option('files-peraturan-direktur')) {
    $this->migrateFilesPeraturanDirektur();
}

    if ($this->option('files-spo')) {
    $this->migrateFilesSpo();
}

    if ($this->option('files-nota-dinas')) {
    $this->migrateFilesNotaDinas();
}

    if ($this->option('surat-masuk')) {
        $this->migrateSuratMasuk();
    }

    if ($this->option('surat-keluar')) {
        $this->migrateSuratKeluar();
    }

    if ($this->option('agenda-surat-keputusan')) {
    $this->migrateAgendaSuratKeputusan();
}

if ($this->option('surat-edaran')) {
    $this->migrateSuratEdaran();
}

if ($this->option('nota-dinas')) {
    $this->migrateNotaDinas();
}

if ($this->option('berita-acara')) {
    $this->migrateBeritaAcara();
}

if ($this->option('pks')) {
    $this->migratePks();
}

if ($this->option('sertifikat')) {
    $this->migrateSertifikat();
}

if ($this->option('spo')) {
    $this->migrateSpo();
}

if ($this->option('files')) {
    $this->migrateFiles();
}

    if ($this->option('files')) {
        $this->migrateFiles();
    }

    if ($this->option('files-surat-masuk')) {
    $this->migrateFilesSuratMasuk();
}

if ($this->option('file-surat-keluar')) {
    $this->migrateFileSuratKeluar();
}

if ($this->option('files-agenda-surat-keputusan')) {
    $this->migrateFilesAgendaSk();
}

if ($this->option('files-surat-edaran')) {
    $this->migrateFilesSuratEdaran();
}

if ($this->option('files-berita-acara')) {
    $this->migrateFilesBeritaAcara();
}

if ($this->option('files-sertifikat')) {
    $this->migrateFilesSertifikat();
}

    if (
        !$this->option('users') &&
        !$this->option('surat-masuk') &&
        !$this->option('surat-keluar') &&
         !$this->option('agenda-surat-keputusan')&&
              !$this->option('surat-edaran') &&
    !$this->option('nota-dinas')&&
    !$this->option('pks')&&
    !$this->option('sertifikat')&&
    !$this->option('spo')&&
    !$this->option('files')
    ) {
        $this->error('Pilih data yang ingin dimigrasikan.');

        $this->line('');
        $this->line('Contoh:');
        $this->line('php artisan migrate:old-database --users');
        $this->line('php artisan migrate:old-database --surat-masuk');
        $this->line('php artisan migrate:old-database --surat-keluar');

        return self::FAILURE;
    }

    $this->newLine();
    $this->info('Proses selesai.');

    return self::SUCCESS;
}

    private function migrateUsers()
    {
        $this->info('Memeriksa user lama...');

        $oldUsers = DB::connection('mysql_lama')
            ->table('user')
            ->get();

        $migrated = 0;
        $skipped = 0;

        foreach ($oldUsers as $oldUser) {

            $username = trim($oldUser->username);

            // Cek apakah user sudah ada
            $exists = DB::table('users')
                ->where('username', $username)
                ->exists();

            if ($exists) {
                $this->line("→ Skip: {$username}");
                $skipped++;

                continue;
            }

            $role = in_array($username, [
                'rasyid_sdm',
                'suci_sdm',
                'adillia_sdm',
                'julia_sdm',
            ]) ? 'sdm' : 'admin';

            DB::table('users')->insert([
                'name' => $username,
                'username' => $username,
                'email' => $username . '@arsip.local',
                'role' => $role,
                'is_active' => true,
                'password' => $oldUser->password,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->line("✓ Insert: {$username}");

            $migrated++;
        }

        $this->newLine();

        $this->info("User baru     : {$migrated}");
        $this->info("User dilewati  : {$skipped}");
        $this->info("Total user lama: {$oldUsers->count()}");
    }

    private function migrateSuratMasuk()
    {
        $this->info('Mulai migrasi surat masuk...');

        $oldSurat = DB::connection('mysql_lama')
            ->table('suratmasuk')
            ->get();

        $migrated = 0;
        $skipped = 0;

        foreach ($oldSurat as $surat) {

            /*
             * Kita gunakan ID lama sebagai acuan pengecekan.
             *
             * Tetapi ID lama dan ID baru berbeda struktur.
             * Untuk sementara kita akan memeriksa nomor surat.
             */

            $nomorSurat = trim($surat->nosurat);

            $exists = DB::table('surat_masuk')
                ->where('nomor_surat', $nomorSurat)
                ->exists();

            if ($exists) {
                $this->line("→ Skip surat: {$nomorSurat}");
                $skipped++;

                continue;
            }

            /*
             * Mapping author lama -> users.id baru
             */

            $authorId = null;

            $author = trim($surat->author);

            if ($author !== '') {

                $user = DB::table('users')
                    ->where('username', $author)
                    ->first();

                if ($user) {
                    $authorId = $user->id;
                } else {
                    $this->warn(
                        "⚠ Author tidak ditemukan: {$author}"
                    );
                }
            }

            DB::table('surat_masuk')->insert([
                'tanggal_diterima' => $this->parseDate(
                    $surat->tanggalditerima
                ),

                'tanggal_surat' => $this->parseDate(
                    $surat->tanggalsurat
                ),

                'nomor_surat' => $nomorSurat,

                'asal_surat' => trim($surat->asalsurat),

                'isi' => $surat->isisurat,

                'nomor_disposisi' => !empty($surat->no_disposisi)
                    ? trim($surat->no_disposisi)
                    : null,

                'diteruskan' => !empty($surat->diteruskan)
                    ? $surat->diteruskan
                    : null,

                'author_id' => $authorId,

                // Semua pengedit lama kosong
                'editor_id' => null,

                'created_at' => now(),

                'updated_at' => now(),
            ]);

            $this->line(
                "✓ Surat: {$nomorSurat}"
            );

            $migrated++;
        }

        $this->newLine();

        $this->info("Surat baru    : {$migrated}");
        $this->info("Surat dilewati: {$skipped}");
        $this->info("Total lama    : {$oldSurat->count()}");
    }

private function migrateSuratKeluar()
{
    $this->info('Mulai migrasi surat keluar...');

    $oldSurat = DB::connection('mysql_lama')
        ->table('suratkeluar')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldSurat as $surat) {

        $nomorSurat = trim($surat->nosurat);

        // Cegah data double
        $exists = DB::table('surat_keluar')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip surat: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */

        $authorId = null;

        $author = trim($surat->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('surat_keluar')->insert([

            'tanggal_surat' => $this->parseDate(
                $surat->tanggalsurat
            ),

            // Belum ada sumber tanggal dikirim
            'tanggal_dikirim' => null,

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($surat->tujuansurat)
                ? trim($surat->tujuansurat)
                : null,

            'asal_surat' => !empty($surat->asalsurat)
                ? trim($surat->asalsurat)
                : null,

            'isi' => $surat->isisurat,

            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ Surat: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Surat baru    : {$migrated}");
    $this->info("Surat dilewati: {$skipped}");
    $this->info("Total lama    : {$oldSurat->count()}");
}

private function migrateAgendaSuratKeputusan()
{
    $this->info('Mulai migrasi agenda surat keputusan...');

    $oldData = DB::connection('mysql_lama')
        ->table('agendasuratkeputusan')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek duplikat berdasarkan nomor surat
        $exists = DB::table('agenda_surat_keputusan')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */

        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('agenda_surat_keputusan')->insert([

            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'arsip' => !empty($data->arsip)
                ? trim($data->arsip)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ Surat: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati : {$skipped}");
    $this->info("Total lama    : {$oldData->count()}");
}

private function migrateSuratEdaran()
{
    $this->info('Mulai migrasi surat edaran...');

    $oldData = DB::connection('mysql_lama')
        ->table('surat_edaran')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek duplikat
        $exists = DB::table('surat_edaran')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */

        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('surat_edaran')->insert([

            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($data->tujuansurat)
                ? trim($data->tujuansurat)
                : null,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,



            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ Surat: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati : {$skipped}");
    $this->info("Total lama    : {$oldData->count()}");
}

private function migrateNotaDinas()
{
    $this->info('Mulai migrasi nota dinas...');

    $oldData = DB::connection('mysql_lama')
        ->table('notadinas')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek duplikat berdasarkan nomor surat
        $exists = DB::table('nota_dinas')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */

        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('nota_dinas')->insert([

            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($data->tujuansurat)
                ? trim($data->tujuansurat)
                : null,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        $this->line(
            "✓ Nota Dinas: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati : {$skipped}");
    $this->info("Total lama    : {$oldData->count()}");
}

private function migrateBeritaAcara()
{
    $this->info('Mulai migrasi berita acara...');

    $oldData = DB::connection('mysql_lama')
        ->table('berita_acara')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek duplikat berdasarkan nomor surat
        $exists = DB::table('berita_acara')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */
        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('berita_acara')->insert([

            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($data->tujuansurat)
                ? trim($data->tujuansurat)
                : null,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        $this->line(
            "✓ Berita Acara: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati : {$skipped}");
    $this->info("Total lama    : {$oldData->count()}");
}

private function migratePks()
{
    $this->info('Mulai migrasi PKS...');

    $oldData = DB::connection('mysql_lama')
        ->table('pks')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek duplikat
        $exists = DB::table('pks')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */
        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        /*
         * Parsing tanggal PKS
         */
        $tanggalMulai = $this->parseTanggalMulaiPks(
            $data->tanggalawal,
            $data->tanggalakhir
        );

        $tanggalBerakhir = $this->parseTanggalAkhirPks(
            $data->tanggalakhir
        );

        DB::table('pks')->insert([

            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($data->tujuansurat)
                ? trim($data->tujuansurat)
                : null,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'tanggal_mulai' => $tanggalMulai,

            'tanggal_berakhir' => $tanggalBerakhir,

            'author_id' => $authorId,

            'created_at' => now(),

            'updated_at' => now(),

        ]);

        $this->line(
            "✓ PKS: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati : {$skipped}");
    $this->info("Total lama    : {$oldData->count()}");
}

private function migrateSertifikat()
{
    $this->info('Mulai migrasi sertifikat...');

    $oldData = DB::connection('mysql_lama')
        ->table('sertifikat')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek apakah sudah ada
        $exists = DB::table('sertifikat')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line("→ Skip sertifikat: {$nomorSurat}");
            $skipped++;

            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */
        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('sertifikat')->insert([
            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'tujuan_surat' => !empty($data->tujuansurat)
                ? trim($data->tujuansurat)
                : null,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ Sertifikat: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati  : {$skipped}");
    $this->info("Total lama     : {$oldData->count()}");
}
private function migratePeraturanDirektur()
{
    $this->info('Mulai migrasi peraturan direktur...');

    $oldData = DB::connection('mysql_lama')
        ->table('peraturan_direktur')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek apakah sudah ada
        $exists = DB::table('peraturan_direktur')
            ->where('nomor_surat', $nomorSurat)
            ->exists();

        if ($exists) {
            $this->line(
                "→ Skip peraturan direktur: {$nomorSurat}"
            );

            $skipped++;
            continue;
        }

        /*
         * Mapping author lama -> users.id baru
         */
        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('peraturan_direktur')->insert([
            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ Peraturan Direktur: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru      : {$migrated}");
    $this->info("Data dilewati   : {$skipped}");
    $this->info("Total lama      : {$oldData->count()}");
}

private function migrateSpo()
{
    $this->info('Mulai migrasi SPO...');

    $oldData = DB::connection('mysql_lama')
        ->table('spo')
        ->get();

    $migrated = 0;
    $skipped = 0;

    foreach ($oldData as $data) {

        $nomorSurat = trim($data->nosurat);

        // Cek apakah data sudah ada
$exists = false;

if (
    $nomorSurat !== '' &&
    $nomorSurat !== '#REF!'
) {
    $exists = DB::table('spo')
        ->where('nomor_surat', $nomorSurat)
        ->exists();
}

if ($exists) {
    $this->line("→ Skip SPO: {$nomorSurat}");
    $skipped++;

    continue;
}

        /*
         * Mapping author lama -> users.id baru
         */
        $authorId = null;

        $author = trim($data->author);

        if ($author !== '') {

            $user = DB::table('users')
                ->where('username', $author)
                ->first();

            if ($user) {
                $authorId = $user->id;
            } else {
                $this->warn(
                    "⚠ Author tidak ditemukan: {$author}"
                );
            }
        }

        DB::table('spo')->insert([
            'tanggal_surat' => $this->parseDate(
                $data->tanggalsurat
            ),

            'nomor_surat' => $nomorSurat,

            'isi' => !empty($data->isisurat)
                ? trim($data->isisurat)
                : null,

            'author_id' => $authorId,

            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->line(
            "✓ SPO: {$nomorSurat}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("Data baru     : {$migrated}");
    $this->info("Data dilewati  : {$skipped}");
    $this->info("Total lama     : {$oldData->count()}");
}

private function migrateFileSuratKeluar()
{
    $this->info('Mulai migrasi file surat keluar...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\berkas';

    $oldSurat = DB::connection('mysql_lama')
        ->table('suratkeluar')
        ->whereNotNull('berkas')
        ->where('berkas', '!=', '')
        ->get();

    $migrated = 0;
    $skipped = 0;
    $notFound = 0;
    $suratNotFound = 0;

    foreach ($oldSurat as $surat) {

        $fileName = trim($surat->berkas);

        $sourceFile = $sourcePath . DIRECTORY_SEPARATOR . $fileName;

        /*
         * Cek file fisik
         */
        if (!file_exists($sourceFile)) {
            $this->warn("⚠ File tidak ditemukan: {$fileName}");
            $notFound++;

            continue;
        }

        /*
         * Cari surat keluar baru
         *
         * Kita cocokkan menggunakan nomor surat.
         */
        $suratBaru = DB::table('surat_keluar')
            ->where('nomor_surat', trim($surat->nosurat))
            ->first();

        if (!$suratBaru) {
            $this->warn(
                "⚠ Surat tidak ditemukan: {$surat->nosurat}"
            );

            $suratNotFound++;

            continue;
        }

        /*
         * Cegah duplikasi
         */
        $exists = DB::table('surat_files')
            ->where('fileable_type', \App\Models\SuratKeluar::class)
            ->where('fileable_id', $suratBaru->id)
            ->where('nama_file', $fileName)
            ->exists();

        if ($exists) {
            $this->line(
                "→ Skip file: {$fileName}"
            );

            $skipped++;

            continue;
        }

        /*
         * Folder tujuan Laravel
         */
        $destinationDirectory =
            storage_path('app/public/surat-keluar');

        if (!is_dir($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }

        /*
         * Copy file
         */
        copy(
            $sourceFile,
            $destinationDirectory . DIRECTORY_SEPARATOR . $fileName
        );

        /*
         * Simpan metadata file
         */
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\SuratKeluar::class,
            'fileable_id'   => $suratBaru->id,

            // ID dari database lama
            'old_id'        => $surat->id_sk,

            'nama_file'     => $fileName,
            'nama_asli'     => $fileName,

            'path'          => 'surat-keluar/' . $fileName,

            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $this->line(
            "✓ File: {$fileName} → Surat #{$suratBaru->id}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$migrated}");
    $this->info("File dilewati        : {$skipped}");
    $this->info("File tidak ada       : {$notFound}");
    $this->info("Surat tidak ketemu   : {$suratNotFound}");
    $this->info("Total referensi      : {$oldSurat->count()}");
}

private function migrateFilesSertifikat(): void
{
    $this->info('Mulai migrasi file Sertifikat...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip8';

    $files = DB::connection('mysql_lama')
        ->table('sertifikat')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('sertifikat')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\Sertifikat::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/sertifikat/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\Sertifikat::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_sertifikat,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function parseDate($date)
{
    if (empty($date)) {
        return null;
    }

    $date = trim($date);

    // Bersihkan karakter aneh dari data lama
    $date = trim($date, "\"' \t\n\r");

    $formats = [
        'Y-m-d',
        'd/m/Y',
        'd-m-Y',
        'd.m.Y',
        'Y/m/d',
        'Y-m-d H:i:s',
        'd/m/Y H:i:s',
        'd-m-Y H:i:s',
    ];

    foreach ($formats as $format) {
        try {
            $parsed = \Carbon\Carbon::createFromFormat($format, $date);

            if ($parsed !== false) {
                return $parsed->format('Y-m-d');
            }
        } catch (\Throwable $e) {
            // Coba format berikutnya
        }
    }

    // Percobaan terakhir menggunakan Carbon
    try {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    } catch (\Throwable $e) {
        return null;
    }
}

private function migrateFilesPeraturanDirektur(): void
{
    $this->info('Mulai migrasi file Peraturan Direktur...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip7';

    $files = DB::connection('mysql_lama')
        ->table('peraturan_direktur')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('peraturan_direktur')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\PeraturanDirektur::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/peraturan-direktur/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\PeraturanDirektur::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_perdir,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'   => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function parseTanggalMulaiPks($tanggalMulai, $tanggalAkhir)
{
    if (empty($tanggalMulai)) {
        return null;
    }

    $tanggalMulai = trim($tanggalMulai, "\"' \t\n\r");

    /*
     * Ambil tahun dari tanggal akhir.
     * Contoh:
     * "31 Desember 2024" -> 2024
     */
    preg_match('/(\d{4})/', $tanggalAkhir ?? '', $tahunMatch);

    if (!isset($tahunMatch[1])) {
        return null;
    }

    $tahun = $tahunMatch[1];

    $bulan = [
        'januari'   => '01',
        'februari'  => '02',
        'maret'     => '03',
        'april'     => '04',
        'mei'       => '05',
        'juni'      => '06',
        'juli'      => '07',
        'agustus'   => '08',
        'september' => '09',
        'oktober'   => '10',
        'november'  => '11',
        'desember'  => '12',
    ];

    /*
     * Contoh:
     * "1 Januari -"
     */
    if (preg_match(
        '/(\d{1,2})\s+([A-Za-z]+)/',
        $tanggalMulai,
        $matches
    )) {

        $hari = $matches[1];
        $namaBulan = strtolower($matches[2]);

        if (isset($bulan[$namaBulan])) {
            return sprintf(
                '%04d-%02d-%02d',
                $tahun,
                $bulan[$namaBulan],
                $hari
            );
        }
    }

    return null;
}

private function migrateFilesSuratMasuk()
{
    $this->info('Mulai migrasi file surat masuk...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\file';

    $oldSurat = DB::connection('mysql_lama')
        ->table('suratmasuk')
        ->whereNotNull('file')
        ->where('file', '!=', '')
        ->get();

    $migrated = 0;
    $skipped = 0;
    $missing = 0;
    $notFound = 0;

    foreach ($oldSurat as $surat) {

        $oldId = $surat->idsurat;
        $fileName = trim($surat->file);
        $nomorSurat = trim($surat->nosurat);

        /*
         * Cari surat lama tersebut di database baru.
         *
         * Karena ID lama dan ID baru berbeda,
         * kita gunakan nomor surat sebagai mapping.
         */
        $newSurat = DB::table('surat_masuk')
            ->where('nomor_surat', $nomorSurat)
            ->first();

        if (!$newSurat) {

            $this->warn(
                "⚠ Surat baru tidak ditemukan: {$nomorSurat} (old_id: {$oldId})"
            );

            $notFound++;

            continue;
        }

        /*
         * Lokasi file lama
         */
        $oldFile = $sourcePath . DIRECTORY_SEPARATOR . $fileName;

        if (!file_exists($oldFile)) {

            $this->warn(
                "⚠ File tidak ditemukan: {$fileName}"
            );

            $missing++;

            continue;
        }

        /*
         * Folder tujuan
         */
        $destinationDirectory =
            storage_path('app/public/files');

        if (!is_dir($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }

        /*
         * Path file baru
         */
        $newFile = $destinationDirectory . DIRECTORY_SEPARATOR . $fileName;

        /*
         * Copy file fisik
         */
        if (!file_exists($newFile)) {
            copy($oldFile, $newFile);
        }

        /*
         * Cek apakah relasi file sudah pernah dibuat
         */
        $exists = DB::table('surat_files')
            ->where('fileable_type', \App\Models\SuratMasuk::class)
            ->where('fileable_id', $newSurat->id)
            ->where('old_id', $oldId)
            ->exists();

        if ($exists) {

            $this->line(
                "→ Skip file: {$fileName}"
            );

            $skipped++;

            continue;
        }

        /*
         * Simpan relasi file
         */
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\SuratMasuk::class,
            'fileable_id'   => $newSurat->id,
            'old_id'        => $oldId,
            'nama_file'     => $fileName,
            'nama_asli'     => $fileName,
            'path'          => 'files/' . $fileName,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $this->line(
            "✓ File: {$fileName} → Surat #{$newSurat->id}"
        );

        $migrated++;
    }

    $this->newLine();

    $this->info("File berhasil   : {$migrated}");
    $this->info("File dilewati    : {$skipped}");
    $this->info("File tidak ada   : {$missing}");
    $this->info("Surat tidak ketemu: {$notFound}");
    $this->info("Total referensi  : {$oldSurat->count()}");
}

private function migrateFilesAgendaSk(): void
{
    $this->info('Mulai migrasi file Agenda Surat Keputusan...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip';

    $files = DB::connection('mysql_lama')
        ->table('agendasuratkeputusan')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('agenda_surat_keputusan')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where('fileable_type', \App\Models\AgendaSuratKeputusan::class)
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/agenda-sk/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\AgendaSuratKeputusan::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_skp,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function migrateFilesSuratEdaran(): void
{
    $this->info('Mulai migrasi file Surat Edaran...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip4';

    $files = DB::connection('mysql_lama')
        ->table('surat_edaran')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('surat_edaran')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\SuratEdaran::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/surat-edaran/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\SuratEdaran::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_edaran,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function migrateFilesBeritaAcara(): void
{
    $this->info('Mulai migrasi file Berita Acara...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip3';

    $files = DB::connection('mysql_lama')
        ->table('berita_acara')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('berita_acara')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\BeritaAcara::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/berita-acara/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\BeritaAcara::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_berita,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function migrateFilesSpo(): void
{
    $this->info('Mulai migrasi file SPO...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip6';

    $files = DB::connection('mysql_lama')
        ->table('spo')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('spo')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\Spo::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/spo/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\Spo::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_spo,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'           => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function migrateFilesNotaDinas(): void
{
    $this->info('Mulai migrasi file Nota Dinas...');

    $sourcePath = 'C:\\laragon\\www\\Arsip_pku\\app\\arsip5';

    $files = DB::connection('mysql_lama')
        ->table('notadinas')
        ->whereNotNull('arsip')
        ->where('arsip', '!=', '')
        ->get();

    $berhasil = 0;
    $dilewati = 0;
    $tidakAda = 0;
    $recordTidakKetemu = 0;

    foreach ($files as $old) {

        $namaFile = trim($old->arsip);

        if (!$namaFile) {
            $dilewati++;
            continue;
        }

        // Cari record baru berdasarkan nomor surat
        $new = DB::table('nota_dinas')
            ->where('nomor_surat', trim($old->nosurat))
            ->first();

        if (!$new) {
            $this->warn(
                "Record tidak ditemukan: {$old->nosurat}"
            );

            $recordTidakKetemu++;
            continue;
        }

        // Cek file fisik
        $fullPath = $sourcePath . DIRECTORY_SEPARATOR . $namaFile;

        if (!file_exists($fullPath)) {
            $this->warn(
                "File tidak ditemukan: {$namaFile}"
            );

            $tidakAda++;
            continue;
        }

        // Cegah duplikasi
        $exists = DB::table('surat_files')
            ->where(
                'fileable_type',
                \App\Models\NotaDinas::class
            )
            ->where('fileable_id', $new->id)
            ->where('nama_file', $namaFile)
            ->exists();

        if ($exists) {
            $dilewati++;
            continue;
        }

        // Copy file ke storage Laravel
        $storagePath = 'surat/nota-dinas/' . $namaFile;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fullPath)
        );

        // Simpan metadata file
        DB::table('surat_files')->insert([
            'fileable_type' => \App\Models\NotaDinas::class,
            'fileable_id'   => $new->id,
            'old_id'        => $old->id_notadinas,
            'nama_file'     => $namaFile,
            'nama_asli'     => $namaFile,
            'path'          => $storagePath,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $berhasil++;
    }

    $this->newLine();

    $this->info("File berhasil       : {$berhasil}");
    $this->info("File dilewati        : {$dilewati}");
    $this->info("File tidak ada       : {$tidakAda}");
    $this->info("Record tidak ketemu  : {$recordTidakKetemu}");
    $this->info("Total referensi      : {$files->count()}");
}

private function parseTanggalAkhirPks($tanggal)
{
    if (empty($tanggal)) {
        return null;
    }

    $tanggal = trim($tanggal, "\"' \t\n\r");

    $bulan = [
        'januari'   => '01',
        'februari'  => '02',
        'maret'     => '03',
        'april'     => '04',
        'mei'       => '05',
        'juni'      => '06',
        'juli'      => '07',
        'agustus'   => '08',
        'september' => '09',
        'oktober'   => '10',
        'november'  => '11',
        'desember'  => '12',
    ];

    if (preg_match(
        '/(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})/',
        $tanggal,
        $matches
    )) {

        $hari = $matches[1];
        $namaBulan = strtolower($matches[2]);
        $tahun = $matches[3];

        if (isset($bulan[$namaBulan])) {
            return sprintf(
                '%04d-%02d-%02d',
                $tahun,
                $bulan[$namaBulan],
                $hari
            );
        }
    }

    return null;
}





}
