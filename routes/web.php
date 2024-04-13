<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LockScreen;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CatatanHarian;
use AzisHapidin\IndoRegion\IndoRegion;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

/** Auth MultiLevel */
Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('home');
    });
    Route::get('home',function() {
        return view('home');
    });
});

Auth::routes();

// ----------------------------- main dashboard ------------------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::patch('/update-tema/{id}', 'updateTemaAplikasi')->name('updateTemaAplikasi');
    Route::get('/notifikasi/dibaca/{id}', 'bacaNotifikasi')->name('notifikasi.dibaca');
    Route::post('/notifikasi/dibaca/semua', 'bacasemuaNotifikasi')->name('notifikasi.dibaca-semua');
    Route::get('/ulangtahun', 'ulangtahun')->name('ulangtahun');
    Route::get('/masaberlakusip', 'masaberlakuSIP')->name('masaberlakusip');
    Route::get('/masaberlakuspkdokter', 'masaberlakuSPKDokter')->name('masaberlakuspkdokter');
    Route::get('/masaberlakuspkperawat', 'masaberlakuSPKPerawat')->name('masaberlakuspkperawat');
    Route::get('/masaberlakuspknakeslain', 'masaberlakuSPKNakesLain')->name('masaberlakuspknakeslain');
});

// -----------------------------settings-------------------------------------//
Route::controller(SettingController::class)->group(function () {
    /** index page */
    Route::get('pengaturan/perusahaan', 'companySettings')->middleware('auth')->name('pengaturan-perusahaan');
    Route::post('pengaturan/perusahaan/save', 'saveRecord')->middleware('auth')->name('pengaturan-perusahaan-save');
    /** save record or update */
    Route::get('roles/permissions/page', 'rolesPermissions')->middleware('auth')->name('roles/permissions/page');
    Route::post('roles/permissions/save', 'addRecord')->middleware('auth')->name('roles/permissions/save');
    Route::post('roles/permissions/update', 'editRolesPermissions')->middleware('auth')->name('roles/permissions/update');
    Route::post('roles/permissions/delete', 'deleteRolesPermissions')->middleware('auth')->name('roles/permissions/delete');
    Route::get('localization/page', 'localizationIndex')->middleware('auth')->name('localization/page');
    /** index page localization */
    Route::get('salary/settings/page', 'salarySettingsIndex')->middleware('auth')->name('salary/settings/page');
    /** index page salary settings */
    Route::get('email/settings/page', 'emailSettingsIndex')->middleware('auth')->name('email/settings/page');
    /** index page email settings */
});

// -----------------------------login----------------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// ----------------------------- lock screen --------------------------------//
Route::controller(LockScreen::class)->group(function () {
    Route::get('lock_screen', 'lockScreen')->middleware('auth')->name('lock_screen');
    Route::post('unlock', 'unlock')->name('unlock');
});

// ------------------------------ register ----------------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'storeUser')->name('register');
});

// ----------------------------- forget password ----------------------------//
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('lupa-kata-sandi', 'getEmail')->name('lupa-kata-sandi');
    Route::post('lupa-kata-sandi', 'postEmail')->name('lupa-kata-sandi');    
});

// ----------------------------- reset password -----------------------------//
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('ubah-kata-sandi/{token}', 'getPassword')->name('ubah-kata-sandi');
    Route::post('ubah-kata-sandi', 'updatePassword')->name('ubah-kata-sandi');
});

// ----------------------------- manage users ------------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('staff/profile', 'user_profile')->middleware('auth')->name('staff-profile');
    Route::post('/getkotakabupaten', 'getkotakabupaten')->name('getkotakabupaten');
    Route::post('/getkecamatan', 'getkecamatan')->name('getkecamatan');
    Route::post('/getdesakelurahan', 'getdesakelurahan')->name('getdesakelurahan');
    Route::get('kepala-dinas/profile', 'admin_profile')->middleware('auth')->name('kepala-dinas-profile');
    Route::get('super-admin/profile', 'superadmin_profile')->middleware('auth')->name('super-admin-profile');
    Route::get('kepala-bidang/profile', 'kepalaruangan_profile')->middleware('auth')->name('kepala-bidang-profile');
    Route::post('profile/information/save', 'profileInformation')->name('profile/information/save');
    Route::post('profile/information/save2', 'profileInformation2')->name('profile/information/save2');
    Route::post('profile/information/foto/save', 'fotoProfile')->name('profile/information/foto/save');
    Route::get('manajemen/pengguna', 'index')->middleware('auth')->name('manajemen-pengguna');
    Route::post('user/add/save', 'addNewUserSave')->name('user/add/save');
    Route::post('update', 'update')->name('update');
    Route::post('user/delete', 'delete')->middleware('auth')->name('user/delete');
    Route::get('riwayat/aktivitas', 'activityLog')->middleware('auth')->name('riwayat-aktivitas');
    Route::get('riwayat/aktivitas/otentikasi', 'activityLogInLogOut')->middleware('auth')->name('riwayat-aktivitas-otentikasi');
    Route::get('kepala-dinas/kata-sandi', 'changePasswordView')->middleware('auth')->name('kepala-dinas-kata-sandi');
    Route::get('super-admin/kata-sandi', 'changePasswordView')->middleware('auth')->name('super-admin-kata-sandi');
    Route::get('kepala-bidang/kata-sandi', 'changePasswordView')->middleware('auth')->name('kepala-bidang-kata-sandi');
    Route::get('staff/kata-sandi', 'changePasswordView')->middleware('auth')->name('staff-kata-sandi');
    Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');
    Route::post('user/profile/pegawai/add', 'profilePegawaiAdd')->name('user/profile/pegawai/add');
    Route::post('user/profile/pegawai/edit', 'profilePegawaiEdit')->name('user/profile/pegawai/edit');
    Route::post('user/profile/posisi/jabatan/add', 'posisiJabatanAdd')->name('user/profile/posisi/jabatan/add');
    Route::post('user/profile/posisi/jabatan/edit', 'posisiJabatanEdit')->name('user/profile/posisi/jabatan/edit');
    Route::get('get-users-data', 'getUsersData')->name('get-users-data');
    Route::post('user/profile/upload-ktp', 'uploadDokumenKTP')->name('user/profile/upload-ktp');
    Route::get('get-riwayat-aktivitas', 'getRiwayatAktivitas')->name('get-riwayat-aktivitas');
    Route::get('get-aktivitas-pengguna', 'getAktivitasPengguna')->name('get-aktivitas-pengguna');
    Route::get('get-pegawai-data', 'getPegawaiData')->name('get-pegawai-data');
    Route::get('get-pegawai-pensiun-data', 'getPegawaiPensiunData')->name('get-pegawai-pensiun-data');
    Route::get('get-pegawai-ruangan-data', 'getPegawaiRuanganData')->name('get-pegawai-ruangan-data');
});

// ---------------------------- form employee ---------------------------//
Route::controller(EmployeeController::class)->group(function () {
    Route::get('daftar/pegawai/card', 'cardAllEmployee')->middleware('auth')->name('daftar/pegawai/card');
    Route::get('daftar/pegawai/list', 'listAllEmployee')->middleware('auth')->name('daftar/pegawai/list');
    Route::get('daftar/pegawai/pensiun/card', 'cardPensiun')->middleware('auth')->name('daftar/pegawai/pensiun/card');
    Route::post('daftar/pegawai/pensiun/card/search', 'searchpegawaipensiunCard')->middleware('auth')->name('daftar/pegawai/pensiun/card/search');
    Route::post('daftar/pegawai/save', 'saveRecord')->middleware('auth')->name('daftar/pegawai/save');
    Route::get('daftar/pegawai/view/edit/{employee_id}', 'viewRecord');
    Route::post('daftar/pegawai/update', 'updateRecord')->middleware('auth')->name('daftar/pegawai/update');
    Route::get('daftar/pegawai/delete/{employee_id}', 'deleteRecord')->middleware('auth');
    Route::post('daftar/pegawai/search', 'employeeSearch')->name('daftar/pegawai/search');
    Route::post('daftar/pegawai/list/search', 'employeeListSearch')->name('daftar/pegawai/list/search');
    Route::post('daftar/pegawai/card/search', 'employeeCardSearch')->name('daftar/pegawai/card/search');

    Route::get('referensi/agama', 'indexAgama')->middleware('auth')->name('referensi-agama');
    Route::get('get-agama-data', 'getAgamaData')->name('get-agama-data');
    Route::post('form/agama/save', 'saveRecordAgama')->middleware('auth')->name('form/agama/save');
    Route::post('form/agama/update', 'updateRecordAgama')->middleware('auth')->name('form/agama/update');
    Route::post('form/agama/delete', 'deleteRecordAgama')->middleware('auth')->name('form/agama/delete');
    Route::get('form/agama/search', 'searchAgama')->middleware('auth')->name('form/agama/search');

    Route::get('referensi/kedudukan', 'indexKedudukan')->middleware('auth')->name('referensi-kedudukan');
    Route::get('get-kedudukan-data', 'getKedudukanData')->name('get-kedudukan-data');
    Route::post('form/kedudukan/save', 'saveRecordKedudukan')->middleware('auth')->name('form/kedudukan/save');
    Route::post('form/kedudukan/update', 'updateRecordKedudukan')->middleware('auth')->name('form/kedudukan/update');
    Route::post('form/kedudukan/delete', 'deleteRecordKedudukan')->middleware('auth')->name('form/kedudukan/delete');
    Route::get('form/kedudukan/search', 'searchKedudukan')->middleware('auth')->name('form/kedudukan/search');

    Route::get('referensi/pendidikan', 'indexPendidikan')->middleware('auth')->name('referensi-pendidikan');
    Route::get('get-pendidikan-data', 'getPendidikanData')->name('get-pendidikan-data');
    Route::post('form/pendidikan/save', 'saveRecordPendidikan')->middleware('auth')->name('form/pendidikan/save');
    Route::post('form/pendidikan/update', 'updateRecordPendidikan')->middleware('auth')->name('form/pendidikan/update');
    Route::post('form/pendidikan/delete', 'deleteRecordPendidikan')->middleware('auth')->name('form/pendidikan/delete');
    Route::get('form/pendidikan/search', 'searchPendidikan')->middleware('auth')->name('form/pendidikan/search');

    Route::get('referensi/bidang', 'indexRuangan')->middleware('auth')->name('referensi-bidang');
    Route::get('get-bidang-data', 'getBidangData')->name('get-bidang-data');
    Route::post('form/ruangan/save', 'saveRecordRuangan')->middleware('auth')->name('form/ruangan/save');
    Route::post('form/ruangan/update', 'updateRecordRuangan')->middleware('auth')->name('form/ruangan/update');
    Route::post('form/ruangan/delete', 'deleteRecordRuangan')->middleware('auth')->name('form/ruangan/delete');
    Route::get('form/ruangan/search', 'searchRuangan')->middleware('auth')->name('form/ruangan/search');

    Route::get('referensi/status', 'indexStatus')->middleware('auth')->name('referensi-status');
    Route::get('get-status-data', 'getStatusData')->name('get-status-data');
    Route::post('form/status/save', 'saveRecordStatus')->middleware('auth')->name('form/status/save');
    Route::post('form/status/update', 'updateRecordStatus')->middleware('auth')->name('form/status/update');
    Route::post('form/status/delete', 'deleteRecordStatus')->middleware('auth')->name('form/status/delete');
    Route::get('form/status/search', 'searchStatus')->middleware('auth')->name('form/status/search');

    Route::get('referensi/pangkat', 'indexGolongan')->middleware('auth')->name('referensi-pangkat');
    Route::get('get-golongan-data', 'getGolonganData')->name('get-golongan-data');
    Route::post('form/golongan/save', 'saveRecordGolongan')->middleware('auth')->name('form/golongan/save');
    Route::post('form/golongan/update', 'updateRecordGolongan')->middleware('auth')->name('form/golongan/update');
    Route::post('form/golongan/delete', 'deleteRecordGolongan')->middleware('auth')->name('form/golongan/delete');
    Route::get('form/golongan/search', 'searchGolongan')->middleware('auth')->name('form/golongan/search');
});

// ------------------------- profile employee --------------------------//
Route::controller(EmployeeController::class)->group(function () {
    Route::get('staff/profile/{user_id}', 'profileEmployee')->middleware('auth');
    Route::post('/getkota', 'getkota')->name('getkota');
    Route::post('/getkecamatan_employee', 'getkecamatan_employee')->name('getkecamatan_employee');
    Route::post('/getkelurahan', 'getkelurahan')->name('getkelurahan');
});

// ----------------------- rekapitulasi  --------------------------//
Route::controller(RekapitulasiController::class)->group(function () {
    Route::get('rekapitulasi', 'index')->middleware('auth')->name('rekapitulasi');
});

// ----------------------- Informasi Catatan Harian --------------------------//
Route::controller(CatatanHarian::class)->group(function () {
    Route::get('catatan/harian/staff', 'tampilanCatatanStaff')->name('catatan-harian-staff');
    Route::get('catatan/harian/kepala-bidang', 'tampilanCatatanKepalaBidang')->name('catatan-harian-kepala-bidang');
    Route::get('catatan/harian/verifikasi/kepala-bidang', 'tampilanCatatanVerifikasiKepalaBidang')->name('catatan-harian-verifikasi-kepala-bidang');
    Route::get('catatan/harian/kepala-dinas', 'tampilanCatatanKepalaDinas')->name('catatan-harian-kepala-dinas');
    
    Route::post('catatan/harian/tambah-data', 'tambahDataCatatanHarian')->name('catatan/harian/tambah-data');
    Route::post('catatan/harian/edit-data', 'editDataCatatanHarian')->name('catatan/harian/edit-data');

    Route::get('catatan/harian/staff/cari', 'pencarianCatatanHarianStaff')->name('catatan/harian/staff/cari');
    Route::get('catatan/harian/kepala-bidang/cari', 'pencarianCatatanHarianKepalaBidang')->name('catatan/harian/kepala-bidang/cari');
    Route::get('catatan/harian/verifikasi/kepala-bidang/cari', 'pencarianVerifikasiCatatanHarianKepalaBidang')->name('catatan/harian/verifikasi/kepala-bidang/cari');
    Route::get('catatan/harian/kepala-dinas/cari', 'pencarianCatatanHarianKepalaDinas')->name('catatan/harian/kepala-dinas/cari');

    Route::patch('/update-status/catatan/{id}', 'updateStatusCatatanHarian')->name('updateStatusCatatan');

});

// ----------------------- Tampilan Notifikasi --------------------------//
Route::controller(NotificationController::class)->group(function () {
    Route::get('tampilan/semua/notifikasi', 'tampilanNotifikasi')->name('tampilan-semua-notifikasi');
    Route::get('/tampilan/semua/notifikasi/hapus/data/{id}', 'hapusNotifikasi')->name('tampilan-semua-notifikasi-hapus-data');
});