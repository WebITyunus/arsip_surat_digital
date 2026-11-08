<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\BeritaAcara\Create as BeritaAcaraCreate;
use App\Livewire\BeritaAcara\Detail;
use App\Livewire\BeritaAcara\Index as BeritaAcaraIndex;
use App\Livewire\BeritaAcara\Update;
use App\Livewire\Dashboard\Index;
use App\Livewire\NotaDinas\Create as NotaDinasCreate;
use App\Livewire\NotaDinas\Detail as NotaDinasDetail;
use App\Livewire\NotaDinas\Index as NotaDinasIndex;
use App\Livewire\NotaDinas\Update as NotaDinasUpdate;
use App\Livewire\Perdir\Create as PerdirCreate;
use App\Livewire\Perdir\Detail as PerdirDetail;
use App\Livewire\Perdir\Index as PerdirIndex;
use App\Livewire\Perdir\Update as PerdirUpdate;
use App\Livewire\Petugas\Create as PetugasCreate;
use App\Livewire\Petugas\Index as PetugasIndex;
use App\Livewire\Petugas\Update as PetugasUpdate;
use App\Livewire\Pks\CreatePks;
use App\Livewire\Pks\DetailPks;
use App\Livewire\Pks\Index as PksIndex;
use App\Livewire\Pks\UpdatePks;
use App\Livewire\Pokja\Create as PokjaCreate;
use App\Livewire\Pokja\Detail as PokjaDetail;
use App\Livewire\Pokja\Index as PokjaIndex;
use App\Livewire\Pokja\Update as PokjaUpdate;
use App\Livewire\Pokjar\Index as PokjarIndex;
use App\Livewire\Pokjar\Update as PokjarUpdate;
use App\Livewire\Pokjars\Create as PokjarsCreate;
use App\Livewire\Pokjars\Detail as PokjarsDetail;
use App\Livewire\Pokjars\Index as PokjarsIndex;
use App\Livewire\Pokjars\Update as PokjarsUpdate;
use App\Livewire\Sertifikat\Create as SertifikatCreate;
use App\Livewire\Sertifikat\Detail as SertifikatDetail;
use App\Livewire\Sertifikat\Index as SertifikatIndex;
use App\Livewire\Sertifikat\Update as SertifikatUpdate;
use App\Livewire\Spo\CreateSpo;
use App\Livewire\Spo\DetailSpo;
use App\Livewire\Spo\Index as SpoIndex;
use App\Livewire\Spo\UpdateSpo;
use App\Livewire\SuratEdaran\Create as SuratEdaranCreate;
use App\Livewire\SuratEdaran\DetailEdaran;
use App\Livewire\SuratEdaran\Index as SuratEdaranIndex;
use App\Livewire\SuratEdaran\UpdateEdaran;
use App\Livewire\SuratKeluar\Create as SuratKeluarCreate;
use App\Livewire\SuratKeluar\DetailSurat as SuratKeluarDetailSurat;
use App\Livewire\SuratKeluar\Index as SuratKeluarIndex;
use App\Livewire\SuratKeluar\UpdateSurat;
use App\Livewire\SuratKeputusan\Create as SuratKeputusanCreate;
use App\Livewire\SuratKeputusan\Detail as SuratKeputusanDetail;
use App\Livewire\SuratKeputusan\Index as SuratKeputusanIndex;
use App\Livewire\SuratKeputusan\Update as SuratKeputusanUpdate;
use App\Livewire\SuratMasuk\Create;
use App\Livewire\SuratMasuk\DetailSurat;
use App\Livewire\Suratmasuk\Editsurat;
use App\Livewire\SuratMasuk\Index as SuratMasukIndex;
use App\Livewire\Unit\Index as UnitIndex;
use App\Livewire\Unit\Update as UnitUpdate;
use Illuminate\Support\Facades\Route;
use App\Livewire\Ai\SuratGenerator;
use App\Livewire\Ai\SuratRevisi;
use App\Livewire\Ai\TanyaAi;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

// Surat Masuk
Route::get('/dashboard',Index::class)->name('dashboard');
Route::get('/surat-masuk',SuratMasukIndex::class)->middleware('permission:surat-masuk.view')->name('surat-masuk');
Route::get('/tambah-surat-masuk',Create::class)->middleware('permission:surat-masuk.create')->name('tambah-surat-masuk');
Route::get('/detail-surat-masuk/{surat}',DetailSurat::class)->name('detail-surat-masuk');
Route::get('/edit-surat-masuk/edit/{surat}',Editsurat::class)->middleware('permission:surat-masuk.edit')->name('edit-surat-masuk');
// Akhir Surat Masuk

// Awal surat Keluar
Route::get('/surat-keluar',SuratKeluarIndex::class)->middleware('permission:surat-keluar.view')->name('surat-keluar');
Route::get('/tambah-surat-keluar',SuratKeluarCreate::class)->name('tambah-surat-keluar');
Route::get('/edit-surat-keluar/edit/{surat}',UpdateSurat::class)->name('edit-surat-keluar');
Route::get('/detail-surat-keluar/{surat}',SuratKeluarDetailSurat::class)->name('detail-surat-keluar');
// akhir surat keluar

// Awal Surat Edaran
Route::get('/surat-edaran',SuratEdaranIndex::class)->middleware('permission:surat-edaran.view')->name('surat-edaran');
Route::get('/tambah-surat-edaran',SuratEdaranCreate::class)->name('tambah-surat-edaran');
Route::get('/detail-surat-edaran/{surat}',DetailEdaran::class)->name('detail-surat-edaran');
Route::get('/edit-surat-edaran/edit/{surat}',UpdateEdaran::class)->name('edit-surat-edaran');
// Akhir Surat Edaran

// Awal Berita Acara
Route::get('/berita-acara',BeritaAcaraIndex::class)->middleware('permission:berita-acara.view')->name('berita-acara');
Route::get('/tambah-berita-acara',BeritaAcaraCreate::class)->name('tambah-berita-acara');
Route::get('/edit-berita-acara/edit/{surat}',Update::class)->name('edit-berita-acara');
Route::get('/detail-berita-acara/{surat}',Detail::class)->name('detail-berita-acara');
// Akhir Berita Acara

// Awal PKS
Route::get('/surat-pks',PksIndex::class)->middleware('permission:pks.view')->name('surat-pks');
Route::get('/tambah-pks',CreatePks::class)->name('tambah-pks');
Route::get('/edit-pks/edit/{surat}',UpdatePks::class)->name('edit-pks');
Route::get('/detail-pks/{surat}',DetailPks::class)->name('detail-pks');
// Akhir Pks

// Awal SPO
Route::get('/surat-spo',SpoIndex::class)->middleware('permission:spo.view')->name('surat-spo');
Route::get('/tambah-spo',CreateSpo::class)->name('tambah-spo');
Route::get('/detail-spo/{surat}',DetailSpo::class)->name('detail-spo');
Route::get('/edit-spo/edit/{surat}',UpdateSpo::class)->name('edit-spo');
// akhir spo

// Awal Sertifikat
Route::get('/surat-sertifikat',SertifikatIndex::class)->middleware('permission:sertifikat.view')->name('surat-sertifikat');
Route::get('/tambah-sertifikat',SertifikatCreate::class)->name('tambah-sertifikat');
Route::get('/detail-sertifikat/{surat}',SertifikatDetail::class)->name('detail-sertifikat');
Route::get('/edit-sertifikat/edit/{surat}',SertifikatUpdate::class)->name('edit-sertifikat');
// Akhir

// Awal Nota Dinas
Route::get('/surat-dinas',NotaDinasIndex::class)->middleware('permission:nota-dinas.view')->name('surat-dinas');
Route::get('/tambah-surat-dinas',NotaDinasCreate::class)->name('tambah-surat-dinas');
Route::get('/detail-dinas/{surat}',NotaDinasDetail::class)->name('detail-dinas');
Route::get('/edit-dinas/edit/{surat}',NotaDinasUpdate::class)->name('edit-dinas');

// awal SK
Route::get('/surat-keputusan',SuratKeputusanIndex::class)->middleware('permission:agenda-sk.view')->name('surat-keputusan');
Route::get('/tambah-keputusan',SuratKeputusanCreate::class)->name('tambah-keputusan');
Route::get('/detail-keputusan/{surat}',SuratKeputusanDetail::class)->name('detail-keputusan');
Route::get('/edit-keputusan/edit/{surat}',SuratKeputusanUpdate::class)->name('edit-keputusan');
// awal SK

// awal Perdir
Route::get('/surat-perdir',PerdirIndex::class)->middleware('permission:perdir.view')->name('surat-perdir');
Route::get('/tambah-perdir',PerdirCreate::class)->name('tambah-perdir');
Route::get('/detail-perdir/{surat}',PerdirDetail::class)->name('detail-perdir');
Route::get('/edit-perdir/edit/{surat}',PerdirUpdate::class)->name('edit-perdir');
// awal perdir

// Awal tambah petugas
Route::get('/petugas-ardi',PetugasIndex::class)->middleware('permission:users.view')->name('petugas-ardi');
Route::get('/tambah-petugas',PetugasCreate::class)->name('tambah-petugas');
Route::get('/edit-petugas/edit/{user}',PetugasUpdate::class)->name('edit-petugas');
// Akhir Petugas

// Awal Unit
Route::get('/unit',UnitIndex::class)->middleware('permission:unit.view')->name('unit');
Route::get('/edit-unit/{unit}',UnitUpdate::class)->middleware('permission:unit.view')->name('edit-unit');
// Akhir Unit

// Awal Pokja
Route::get('/pokja',PokjarIndex::class)->middleware('permission:unit.view')->name('pokja');
Route::get('/pokja/{pokja}',PokjarUpdate::class)->middleware('permission:unit.view')->name('edit-pokja');
// akhir pokja

// awal simpan file pokja admin
Route::get('/index-pokja',PokjarsIndex::class)->middleware('permission:halaman.pokja-admin')->name('index-pokja');
Route::get('/tambah-pokja',PokjarsCreate::class)->name('tambah-pokja');
Route::get('/edit-pokjars/{pokja}',PokjarsUpdate::class)->name('edit-pokjars');
Route::get('/detail-pokjars/detail/{pokja}',PokjarsDetail::class)->name('detail-pokjars');
// akhir simpan file pokja admin

// awal simpan file poka per pokja
Route::get('index-halaman-pokja',PokjaIndex::class)->middleware('permission:halaman.poka-user')->name('halaman-pokja-user');
Route::get('create-halaman-pokja',PokjaCreate::class)->name('create-pokja-user');
Route::get('edit-halaman-pokja/{pokja}',PokjaUpdate::class)->name('edit-pokja-user');
Route::get('detail-halaman-pokja/{pokja}',PokjaDetail::class)->name('detail-pokja-user');


    Route::get('/ai/surat-generator', SuratGenerator::class)
        ->name('ai.surat-generator');
        Route::get('/ai/revisi-surat', SuratRevisi::class)
    ->name('ai.revisi-surat');
    Route::get('/tanya-ai', TanyaAi::class)
    ->name('tanya-ai');


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
