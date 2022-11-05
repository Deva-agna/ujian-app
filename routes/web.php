<?php

use App\Http\Controllers\CreateEssayController;
use App\Http\Controllers\DetailSoalController;
use App\Http\Controllers\DetailUjianController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalBMController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NaikKelasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileSisawaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SoalEssayController;
use App\Http\Controllers\SoalMultipleChoiceController;
use App\Http\Controllers\SoalPilihanGandaController;
use App\Http\Controllers\SubKelasController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\UjianSelesaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'auth']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:web', 'checkRole:admin,guru']], function () {
    //----------------------
    // Kelola Profile
    //----------------------
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [PageController::class, 'profileEdit'])->name('profile.edit');
    Route::patch('/profile/update', [PageController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/profile/edit/password', [PageController::class, 'profileEditPassword'])->name('profile.edit.password');
    Route::post('/profile/update/password', [PageController::class, 'profileUpdatePassword'])->name('profile.update.password');
});

Route::group(['middleware' => ['auth:web', 'checkRole:admin']], function () {
    Route::get('/dashboard/admin', [PageController::class, 'dashboardAdmin'])->name('dashboard-admin');
    //----------------------
    // Kelola Guru
    //----------------------
    Route::get('/guru', [GuruController::class, 'index'])->name('guru');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    Route::get('/guru/{slug}/edit', [GuruController::class, 'edit'])->name('guru.edit');
    Route::put('/guru/update', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{slug}/destroy', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::get('/reset/{slug}/password/guru', [GuruController::class, 'reset'])->name('reset.password.guru');
    //----------------------
    // Kelola siswa
    //----------------------
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{slug}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/update', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{slug}/destroy', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/reset/{slug}/password/siswa', [SiswaController::class, 'reset'])->name('reset.password.siswa');
    //----------------------
    // Kelola Sub Kelas
    //----------------------
    Route::get('/sub-kelas', [SubKelasController::class, 'index'])->name('sub.kelas');
    Route::get('/sub-kelas/create', [SubKelasController::class, 'create'])->name('sub.kelas.create');
    Route::post('/sub-kelas/store', [SubKelasController::class, 'store'])->name('sub.kelas.store');
    Route::get('/sub-kelas/{slug}/edit', [SubKelasController::class, 'edit'])->name('sub.kelas.edit');
    Route::put('/sub-kelas/update', [SubKelasController::class, 'update'])->name('sub.kelas.update');
    Route::delete('/sub-kelas/{slug}/destroy', [SubKelasController::class, 'destroy'])->name('sub.kelas.destroy');
    //----------------------
    // Kelola Mapel
    //----------------------
    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel');
    Route::get('/mapel/create', [MapelController::class, 'create'])->name('mapel.create');
    Route::post('/mapel/store', [MapelController::class, 'store'])->name('mapel.store');
    Route::get('/mapel/{slug}/edit', [MapelController::class, 'edit'])->name('mapel.edit');
    Route::put('/mapel/update', [MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{slug}/destroy', [MapelController::class, 'destroy'])->name('mapel.destroy');
    //----------------------
    // Kelola tahun ajaran
    //----------------------
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun.ajaran');
    Route::get('/tahun-ajaran/create', [TahunAjaranController::class, 'create'])->name('tahun.ajaran.create');
    Route::post('/tahun-ajaran/store', [TahunAjaranController::class, 'store'])->name('tahun.ajaran.store');
    Route::get('/tahun-ajaran/{tahun_ajaran:slug}/edit', [TahunAjaranController::class, 'edit'])->name('tahun.ajaran.edit');
    Route::put('/tahun-ajaran/update', [TahunAjaranController::class, 'update'])->name('tahun.ajaran.update');
    Route::patch('/tahun-ajaran/{tahun_ajaran:slug}/active', [TahunAjaranController::class, 'active'])->name('tahun.ajaran.active');
    Route::delete('/tahun-ajaran/{tahun_ajaran:slug}/destroy', [TahunAjaranController::class, 'destroy'])->name('tahun.ajaran.destroy');
    //----------------------
    // Kelola jadwal BM
    //----------------------
    Route::get('/jadwalBM', [JadwalBMController::class, 'index'])->name('jadwalBM');
    Route::get('/jadwalBM/create', [JadwalBMController::class, 'create'])->name('jadwalBM.create');
    Route::post('/jadwalBM/store', [JadwalBMController::class, 'store'])->name('jadwalBM.store');
    Route::get('/jadwalBM/{slug}/edit', [JadwalBMController::class, 'edit'])->name('jadwalBM.edit');
    Route::put('/jadwalBM/update', [JadwalBMController::class, 'update'])->name('jadwalBM.update');
    Route::delete('/jadwalBM/{slug}/destroy', [JadwalBMController::class, 'destroy'])->name('jadwalBM.destroy');
    //----------------------
    // Kelola Naik Kelas
    //----------------------
    Route::get('/naik-kelas', [NaikKelasController::class, 'index'])->name('naik.kelas');
    Route::get('/naik-kelas/{slug}/view', [NaikKelasController::class, 'view'])->name('naik.kelas.view');
    Route::post('/naik-kelas/store', [NaikKelasController::class, 'store'])->name('naik.kelas.store');
});

Route::group(['middleware' => ['auth:web', 'checkRole:guru']], function () {
    Route::get('/dashboard/guru', [PageController::class, 'dashboardGuru'])->name('dashboard-guru');
    //----------------------
    // Kelola Ujian
    //----------------------
    Route::get('/ujian', [UjianController::class, 'index'])->name('ujian');
    Route::get('/ujian/create', [UjianController::class, 'create'])->name('ujian.create');
    Route::post('/ujian/store', [UjianController::class, 'store'])->name('ujian.store');
    Route::get('/ujian/{slug}/edit', [UjianController::class, 'edit'])->name('ujian.edit');
    Route::put('/ujian/update', [UjianController::class, 'update'])->name('ujian.update');
    Route::delete('/ujian/{slug}/destroy', [UjianController::class, 'destroy'])->name('ujian.destroy');
    Route::patch('/ujian/update/status', [UjianController::class, 'status'])->name('ujian.update.status');
    //----------------------
    // Kelola Soal Pilihan Ganda
    //----------------------
    Route::get('/soal/pg/{slug}/list', [SoalPilihanGandaController::class, 'index'])->name('soal.pg.list');
    Route::get('/soal/pg/{slug}/create', [SoalPilihanGandaController::class, 'create'])->name('soal.pg.create');
    Route::post('/soal/pg/store', [SoalPilihanGandaController::class, 'store'])->name('soal.pg.store');
    Route::get('/soal/pg/{slug}/edit', [SoalPilihanGandaController::class, 'edit'])->name('soal.pg.edit');
    Route::put('/soal/pg/update', [SoalPilihanGandaController::class, 'update'])->name('soal.pg.update');
    Route::get('/soal/pg/{slug}/pilih', [SoalPilihanGandaController::class, 'pilih'])->name('soal.pg.pilih');
    //----------------------
    // Kelola Soal Multiple Choice
    //----------------------
    Route::get('/soal/mc/{slug}/list', [SoalMultipleChoiceController::class, 'index'])->name('soal.mc.list');
    Route::get('/soal/mc/{slug}/create', [SoalMultipleChoiceController::class, 'create'])->name('soal.mc.create');
    Route::post('/soal/mc/store', [SoalMultipleChoiceController::class, 'store'])->name('soal.mc.store');
    Route::get('/soal/mc/{slug}/edit', [SoalMultipleChoiceController::class, 'edit'])->name('soal.mc.edit');
    Route::put('/soal/mc/update', [SoalMultipleChoiceController::class, 'update'])->name('soal.mc.update');
    Route::get('/soal/mc/{slug}/pilih', [SoalMultipleChoiceController::class, 'pilih'])->name('soal.mc.pilih');
    Route::get('soal/mc/{slug}/create-jawaban', [SoalMultipleChoiceController::class, 'addJawaban'])->name('soal.mc.create.jawaban');
    Route::patch('/soal/mc/store-jawaban', [SoalMultipleChoiceController::class, 'storeJawaban'])->name('soal.mc.store.jawaban');
    //----------------------
    // Kelola Soal Essay
    //----------------------
    Route::get('/soal/essay/{slug}/list', [SoalEssayController::class, 'index'])->name('soal.essay.list');
    Route::get('/soal/essay/{slug}/create', [SoalEssayController::class, 'create'])->name('soal.essay.create');
    Route::post('/soal/essay/store', [SoalEssayController::class, 'store'])->name('soal.essay.store');
    Route::get('/soal/essay/{slug}/edit', [SoalEssayController::class, 'edit'])->name('soal.essay.edit');
    Route::put('/soal/essay/update', [SoalEssayController::class, 'update'])->name('soal.essay.update');
    Route::get('/soal/essay/{slug}/pilih', [SoalEssayController::class, 'pilih'])->name('soal.essay.pilih');
    //----------------------
    // Kelola Detail Ujian
    //----------------------
    Route::post('/soal/pilih/store', [DetailUjianController::class, 'storeSoal'])->name('soal.pilih.store');
    Route::put('/duplikat/soal/store', [DetailUjianController::class, 'duplikatSoal'])->name('duplikat.soal.store');
    Route::delete('/soal/destroy/list', [DetailUjianController::class, 'destroyList'])->name('soal.destroy.list');
    //----------------------
    // Kelola Detail Soal
    //----------------------
    Route::get('/soal/{slug}/list-jawaban', [DetailSoalController::class, 'listJawaban'])->name('soal.list.jawaban');
    Route::put('/soal/destroy/list-jawaban', [DetailSoalController::class, 'destroyListJawaban'])->name('soal.destroy.list.jawaban');
    Route::get('/soal/{image}/destroy/image', [DetailSoalController::class, 'destroyImage'])->name('soal.destroy.image');
    //----------------------
    // Route yang berkatan dengan ujian yang sedang berlangsung
    //----------------------
    Route::get('/lihat/peserta/{slug}', [PageController::class, 'lihatPeserta'])->name('lihat.peserta');
    //----------------------
    // Route ujian selesai
    //----------------------
    Route::get('/log/ujian', [UjianSelesaiController::class, 'index'])->name('log.ujian');
    Route::get('/log/{slug}/hasil-ujian', [UjianSelesaiController::class, 'logHasilUjian'])->name('log.hasil.ujian');
    Route::post('/ujian/selesai', [UjianSelesaiController::class, 'ujianSelesai'])->name('ujian.selesai');

    Route::get('/preview/{slug}/jawaban', [UjianSelesaiController::class, 'previewJawaban'])->name('preview.jawaban');
    Route::get('/print/{nilai:id}/jawaban', [UjianSelesaiController::class, 'printJawaban'])->name('print.jawaban');
    Route::get('/preview/{nilai:id}/essay', [UjianSelesaiController::class, 'previewEssay'])->name('preview.essay');
    Route::get('/preview-jawaban/{nilai:id}/essay', [UjianSelesaiController::class, 'printJawabanEssay'])->name('print.jawaban.essay');
    // Route::get('/download/{nilai:id}/jawaban', [UjianSelesaiController::class, 'downloadPdf'])->name('download.jawaban');
    //----------------------
    // Route menilai jawaban siswa (essay)
    //----------------------
    Route::get('/penilaian/{nilai:id}/essay', [PenilaianController::class, 'penilaianEssay'])->name('penilaian.essay');
    Route::patch('/penilaian/essay/store', [PenilaianController::class, 'penilaianEssayStore'])->name('penilaian.essay.store');
});

Route::group(['middleware' => ['auth:siswa', 'checkRole:siswa']], function () {
    Route::get('/dashboard/siswa', [PageController::class, 'dashboardSiswa'])->name('dashboard.siswa');
    Route::get('/daftar/ujian/siswa', [PageController::class, 'halamanUjianIndex'])->name('daftar.ujian.siswa');
    Route::get('/page/{slug}/konfirmasi-token', [PageController::class, 'pageKonfirmasiToken'])->name('page.konfirmasi.token');
    Route::put('/check/token', [PageController::class, 'checkToken'])->name('check.token');


    Route::post('/penilaian/pg/store', [PenilaianController::class, 'penilaianPg'])->name('penilaian.pg.store');
    Route::put('/penilaian/mc/store', [PenilaianController::class, 'penilaianMc'])->name('penilaian.mc.store');
    Route::patch('/create/essay/store', [CreateEssayController::class, 'store'])->name('create.essay.store');

    // Route profile siswa
    Route::get('/profile/siswa', [ProfileSisawaController::class, 'index'])->name('profile.siswa');
    Route::post('/profile/siswa/store', [ProfileSisawaController::class, 'store'])->name('profile.siswa.store');
});
