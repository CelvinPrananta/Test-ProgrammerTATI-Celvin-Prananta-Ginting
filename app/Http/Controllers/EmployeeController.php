<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Employee;
use App\Models\User;
use App\Models\pendidikan;
use App\Models\agama;
use App\Models\jenis_pegawai;
use App\Models\kedudukan;
use App\Models\bidang;
use App\Models\Notification;
use App\Models\sipDokter;
use App\Models\sumpah;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\golongan_id;
use App\Models\UnitOrganisasi;
use App\Models\Village;
use Carbon\Carbon;
use Session;

class EmployeeController extends Controller
{
    /** Daftar Pegawai Card */
    public function cardAllEmployee(Request $request)
    {
        $users = DB::table('daftar_pegawai')
            ->join('users', 'daftar_pegawai.user_id', 'users.user_id')
            ->select(
                'daftar_pegawai.kedudukan_pns',
                'daftar_pegawai.user_id',
                'daftar_pegawai.name',
                'daftar_pegawai.nip',
                'users.email',
                'users.avatar')
            ->where('daftar_pegawai.role_name', 'Staff')
            ->orWhere('daftar_pegawai.role_name', 'Kepala Bidang')
            ->where(function ($query) {
                $query->where('kedudukan_pns', 'Aktif');
                $query->orWhereNull('kedudukan_pns');
            })
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();
        return view('employees.allemployeecard', compact('users', 'unreadNotifications', 'readNotifications',
            'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** Daftar Pegawai List */
    public function listAllEmployee()
    {
        $users = DB::table('users')
            ->join('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', 'posisi_jabatan.user_id')
            ->select(
                'profil_pegawai.nip',
                'profil_pegawai.name',
                'posisi_jabatan.jabatan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.no_hp',
                'profil_pegawai.bidang',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.user_id',
                'users.avatar'
            )
            ->where(function($query) {
                $query->where('role_name', 'Staff')
                    ->where(function($query) {
                        $query->whereNull('profil_pegawai.kedudukan_pns')
                            ->orWhere('profil_pegawai.kedudukan_pns', 'Aktif');
                    });
            })
            ->get();

            
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();
        return view('employees.employeelist', compact('users', 'unreadNotifications', 'readNotifications',
            'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** Daftar Pegawai Pensiun Card */
    public function cardPensiun(Request $request)
    {
        $users = DB::table('daftar_pegawai')
            ->join('users', 'daftar_pegawai.user_id', 'users.user_id')
            ->select(
                'daftar_pegawai.kedudukan_pns',
                'daftar_pegawai.user_id',
                'daftar_pegawai.name',
                'daftar_pegawai.nip',
                'users.email',
                'users.avatar'
            )
            ->where('daftar_pegawai.role_name', 'User')
            ->where('daftar_pegawai.kedudukan_pns', 'Pensiun')
            ->get();
        
        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.datapensiuncard', compact('users', 'unreadNotifications', 'readNotifications',
            'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** Daftar Pegawai Pensiun List */
    public function listPensiun()
    {
        $users = DB::table('users')
            ->join('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', 'posisi_jabatan.user_id')
            ->select(
                'profil_pegawai.nip',
                'profil_pegawai.name',
                'posisi_jabatan.jabatan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.no_hp',
                'profil_pegawai.bidang',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.user_id',
                'users.avatar')
            ->where('role_name', 'User')
            ->where('profil_pegawai.kedudukan_pns', 'Pensiun')
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.datapensiunlist', compact('users', 'unreadNotifications', 'readNotifications',
            'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function cardRuangan(Request $request)
    {
        $user = auth()->user();
        $bidang = $user->bidang;
        $data_ruangan = DB::table('daftar_pegawai')
            ->join('users', 'daftar_pegawai.user_id', 'users.user_id')
            ->select(
                'daftar_pegawai.user_id',
                'daftar_pegawai.name',
                'daftar_pegawai.nip',
                'users.email',
                'daftar_pegawai.bidang',
                'users.avatar'
            )
            ->where('daftar_pegawai.role_name', 'User')
            ->where('daftar_pegawai.bidang', $bidang)
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.dataruangancard', compact('data_ruangan', 'result_tema', 'unreadNotifications', 'readNotifications',
            'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** Daftar Ruangan List */
    public function listRuangan()
    {
        $user = auth()->user();
        $ruangan = $user->ruangan;
        $data_ruangan = DB::table('profil_pegawai')
            ->join('users', 'profil_pegawai.user_id', '=', 'users.user_id')
            ->join('posisi_jabatan', 'profil_pegawai.user_id', '=', 'posisi_jabatan.user_id')
            ->select(
                'profil_pegawai.nip',
                'profil_pegawai.name',
                'posisi_jabatan.gol_ruang_awal',
                'posisi_jabatan.gol_ruang_akhir',
                'profil_pegawai.ruangan',
                'profil_pegawai.jenis_pegawai',
                'profil_pegawai.user_id',
                'users.avatar'
            )
            ->where('users.role_name', 'User')
            ->where('users.ruangan', $ruangan)
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.dataruanganlist', compact('data_ruangan', 'result_tema', 'unreadNotifications', 'readNotifications',
            'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save data employee */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email',
            'employee_id' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $employees = Employee::where('email', '=', $request->email)->first();
            if ($employees === null) {
                $employee               = new Employee;
                $employee->name         = $request->name;
                $employee->email        = $request->email;
                $employee->employee_id  = $request->employee_id;
                $employee->save();

                DB::commit();
                Toastr::success('Berhasil menambahkan pegawai baru ✔', 'Success');
                return redirect()->route('daftar/pegawai/card');
            } else {
                DB::rollback();
                Toastr::error('Data tersebuut sudah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Gagal menambahkan pegawai baru ✘', 'Error');
            return redirect()->back();
        }
    }

    /** view edit record */
    public function viewRecord($employee_id)
    {
        $employees = DB::table('employees')->where('employee_id', $employee_id)->get();
        return view('employees.edit.editemployee', compact('employees'));
    }

    /** update record employee */
    public function updateRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            // update table Employee
            $updateEmployee = [
                'id'            => $request->id,
                'name'          => $request->name,
                'email'         => $request->email,
                'employee_id'   => $request->employee_id,
            ];

            // update table user
            $updateUser = [
                'id'            => $request->id,
                'name'          => $request->name,
                'email'         => $request->email,
            ];

            User::where('id', $request->id)->update($updateUser);
            Employee::where('id', $request->id)->update($updateEmployee);

            DB::commit();
            Toastr::success('Data daftar pegawai berhasil diperbaharui ✔', 'Success');
            return redirect()->route('daftar/pegawai/card');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data daftar pegawai gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function deleteRecord($employee_id)
    {
        DB::beginTransaction();
        try {
            Employee::where('employee_id', $employee_id)->delete();

            DB::commit();
            Toastr::success('Data daftar pegawai berhasil dihapus ✔', 'Success');
            return redirect()->route('daftar/pegawai/card');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data daftar pegawai gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** employee search */
    public function employeeSearch(Request $request)
    {
        $users = DB::table('users')
            ->join('employees', 'users.user_id', 'employees.employee_id')
            ->select('users.*', 'employees.name', 'employees.email')->get();
        $userList = DB::table('daftar_pegawai')->get();

        // search by id
        if ($request->employee_id) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')->get();
        }
        // search by name
        if ($request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')->get();
        }
        // search by email
        if ($request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }

        // search by name and id
        if ($request->employee_id && $request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->get();
        }
        // search by email and id
        if ($request->employee_id && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }
        // search by name and email
        if ($request->name && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }
        // search by name and email and id
        if ($request->employee_id && $request->name && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.allemployeecard', compact('users', 'userList', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function employeeSearchRuangan(Request $request)
    {
        $users = DB::table('users')
            ->join('employees', 'users.user_id', 'employees.employee_id')
            ->select('users.*', 'employees.name', 'employees.email')->get();
        $userList = DB::table('daftar_pegawai')->get();

        // search by id
        if ($request->employee_id) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')->get();
        }
        // search by name
        if ($request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')->get();
        }
        // search by email
        if ($request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }

        // search by name and id
        if ($request->employee_id && $request->name) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->get();
        }
        // search by email and id
        if ($request->employee_id && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }
        // search by name and email
        if ($request->name && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }
        // search by name and email and id
        if ($request->employee_id && $request->name && $request->email) {
            $users = DB::table('users')
                ->join('employees', 'users.user_id', 'employees.employee_id')
                ->select('users.*', 'employees.name', 'employees.email')
                ->where('employee_id', 'LIKE', '%' . $request->employee_id . '%')
                ->where('users.name', 'LIKE', '%' . $request->name . '%')
                ->where('users.email', 'LIKE', '%' . $request->email . '%')->get();
        }

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.dataruangancard', compact('users', 'userList', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** list search employee */
    public function employeeListSearch(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->leftJoin('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->select(
                'users.*',
                'profil_pegawai.name as employee_name',
                'profil_pegawai.email as employee_email',
                'profil_pegawai.nip',
                'profil_pegawai.gelar_depan',
                'profil_pegawai.gelar_belakang',
                'profil_pegawai.tempat_lahir',
                'profil_pegawai.tanggal_lahir',
                'profil_pegawai.jenis_kelamin',
                'profil_pegawai.agama',
                'profil_pegawai.jenis_dokumen',
                'profil_pegawai.no_dokumen',
                'profil_pegawai.kelurahan',
                'profil_pegawai.kecamatan',
                'profil_pegawai.kota',
                'profil_pegawai.provinsi',
                'profil_pegawai.kode_pos',
                'profil_pegawai.no_hp',
                'profil_pegawai.no_telp',
                'profil_pegawai.jenis_pegawai',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.status_pegawai',
                'profil_pegawai.tmt_pns',
                'profil_pegawai.no_seri_karpeg',
                'profil_pegawai.tmt_cpns',
                'profil_pegawai.tingkat_pendidikan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.ruangan',
                'users.name as user_name',
                'posisi_jabatan.jabatan'
            );

        // Lakukan pencarian berdasarkan input form
        if ($request->input('nip')) {
            $query->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }

        if ($request->input('name')) {
            $query->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('email')) {
            $query->where('profil_pegawai.email', 'LIKE', '%' . $request->input('email') . '%');
        }

        $users = $query->get();

        // Lanjutkan dengan bagian notifikasi jika diperlukan
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.employeelist', compact('users', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** End Search */

    /** list search employee */
    public function employeeCardSearch(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->leftJoin('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->select(
                'users.*',
                'profil_pegawai.name as employee_name',
                'profil_pegawai.email as employee_email',
                'profil_pegawai.nip',
                'profil_pegawai.gelar_depan',
                'profil_pegawai.gelar_belakang',
                'profil_pegawai.tempat_lahir',
                'profil_pegawai.tanggal_lahir',
                'profil_pegawai.jenis_kelamin',
                'profil_pegawai.agama',
                'profil_pegawai.jenis_dokumen',
                'profil_pegawai.no_dokumen',
                'profil_pegawai.kelurahan',
                'profil_pegawai.kecamatan',
                'profil_pegawai.kota',
                'profil_pegawai.provinsi',
                'profil_pegawai.kode_pos',
                'profil_pegawai.no_hp',
                'profil_pegawai.no_telp',
                'profil_pegawai.jenis_pegawai',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.status_pegawai',
                'profil_pegawai.tmt_pns',
                'profil_pegawai.no_seri_karpeg',
                'profil_pegawai.tmt_cpns',
                'profil_pegawai.tingkat_pendidikan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.bidang',
                'users.name as user_name',
                'posisi_jabatan.jabatan'
            )
            ->where(function($query) {
                $query->where('users.role_name', 'Staff')
                      ->orWhere('users.role_name', 'Kepala Bidang');
            });

        // Lakukan pencarian berdasarkan input form
        if ($request->input('nip')) {
            $query->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }

        if ($request->input('name')) {
            $query->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->input('email')) {
            $query->where('profil_pegawai.email', 'LIKE', '%' . $request->input('email') . '%');
        }

        $users = $query->get();

        // Lanjutkan dengan bagian notifikasi jika diperlukan
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.allemployeecard', compact('users', 'result_tema', 'unreadNotifications', 'readNotifications',
            'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** End Search */

    /** list search employee */
    public function employeeListSearchRuangan(Request $request)
    {
        $user2 = auth()->user();
        $ruangan2 = $user2->ruangan;
        $ruangan_result = User::where('role_name', 'User')
            ->join('cuti', 'users.user_id', '=', 'cuti.user_id')
            ->join('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->where('users.ruangan', $ruangan2);
        if ($request->input('nip')) {
            $ruangan_result->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }
        if ($request->input('name')) {
            $ruangan_result->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }
        $search_pegawairuangan = $ruangan_result->get();

        $user3 = auth()->user();
        $ruangan3 = $user3->ruangan;
        $data_ruangan = User::where('role_name', 'User')
            ->join('cuti', 'users.user_id', '=', 'cuti.user_id')
            ->join('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->where('users.ruangan', $ruangan3)
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.dataruanganlist', compact('search_pegawairuangan', 'data_ruangan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** End Search */

    /** list search employee */
    public function employeeCardSearchRuangan(Request $request)
    {
        $user2 = auth()->user();
        $ruangan2 = $user2->ruangan;
        $ruangan_result = User::where('role_name', 'User')
            ->join('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->where('users.ruangan', $ruangan2);
        if ($request->input('nip')) {
            $ruangan_result->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }
        if ($request->input('name')) {
            $ruangan_result->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }
        $search_pegawairuangan = $ruangan_result->get();

        $user3 = auth()->user();
        $ruangan3 = $user3->ruangan;
        $data_ruangan = User::where('role_name', 'User')
            ->join('profil_pegawai', 'users.user_id', '=', 'profil_pegawai.user_id')
            ->join('posisi_jabatan', 'users.user_id', '=', 'posisi_jabatan.user_id')
            ->where('users.ruangan', $ruangan3)
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.dataruangancard', compact('search_pegawairuangan', 'data_ruangan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** End Search */

    /** employee profile with all controller user */
    public function profileEmployee($user_id)
    {
        $user = DB::table('users')
            ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
            // ->leftJoin('riwayat_pendidikan as rp','rp.user_id','users.user_id')
            // ->leftJoin('riwayat_golongan as rg','rg.user_id','users.user_id')
            // ->leftJoin('riwayat_jabatan as rj','rj.user_id','users.user_id')
            // ->leftJoin('riwayat_diklat as rd','rd.user_id','users.user_id')
            ->leftJoin('profil_pegawai as pg', 'pg.user_id', 'users.user_id')
            ->leftJoin('posisi_jabatan as pj', 'pj.user_id', 'users.user_id')
            ->select(
                'users.*',
                'pr.tgl_lahir',
                'pr.jk',
                'pr.alamat',
                'pr.tmpt_lahir',
                'pg.name',
                'pg.email',
                'pg.nip',
                'pg.gelar_depan',
                'pg.gelar_belakang',
                'pg.tempat_lahir',
                'pg.tanggal_lahir',
                'pg.jenis_kelamin',
                'pg.agama',
                'pg.jenis_dokumen',
                'pg.no_dokumen',
                'pg.kelurahan',
                'pg.kecamatan',
                'pg.kota',
                'pg.provinsi',
                'pg.kode_pos',
                'pg.no_hp',
                'pg.no_telp',
                'pg.jenis_pegawai',
                'pg.kedudukan_pns',
                'pg.status_pegawai',
                'pg.tmt_pns',
                'pg.no_seri_karpeg',
                'pg.tmt_cpns',
                'pg.tingkat_pendidikan',
                'pg.pendidikan_terakhir',
                'pg.bidang',
                'pg.dokumen_ktp',
                'pj.unit_organisasi',
                'pj.unit_organisasi_induk',
                'pj.jenis_jabatan',
                'pj.eselon',
                'pj.jabatan',
                'pj.tmt',
                'pj.lokasi_kerja',
                'pj.gol_ruang_awal',
                'pj.gol_ruang_akhir',
                'pj.tmt_golongan',
                'pj.gaji_pokok',
                'pj.masa_kerja_tahun',
                'pj.masa_kerja_bulan',
                'pj.no_spmt',
                'pj.tanggal_spmt',
                'pj.kppn'
            )
            ->where('users.user_id', $user_id)->get();

        $users = DB::table('users')
            ->leftJoin('profile_information as pr', 'pr.user_id', 'users.user_id')
            // ->leftJoin('riwayat_pendidikan as rp','rp.user_id','users.user_id')
            // ->leftJoin('riwayat_golongan as rg','rg.user_id','users.user_id')
            // ->leftJoin('riwayat_jabatan as rj','rj.user_id','users.user_id')
            // ->leftJoin('riwayat_diklat as rd','rd.user_id','users.user_id')
            ->leftJoin('profil_pegawai as pg', 'pg.user_id', 'users.user_id')
            ->leftJoin('posisi_jabatan as pj', 'pj.user_id', 'users.user_id')
            ->select(
                'users.*',
                'pr.tgl_lahir',
                'pr.jk',
                'pr.alamat',
                'pr.tmpt_lahir',
                'pg.name',
                'pg.email',
                'pg.nip',
                'pg.gelar_depan',
                'pg.gelar_belakang',
                'pg.tempat_lahir',
                'pg.tanggal_lahir',
                'pg.jenis_kelamin',
                'pg.agama',
                'pg.jenis_dokumen',
                'pg.no_dokumen',
                'pg.kelurahan',
                'pg.kecamatan',
                'pg.kota',
                'pg.provinsi',
                'pg.kode_pos',
                'pg.no_hp',
                'pg.no_telp',
                'pg.jenis_pegawai',
                'pg.kedudukan_pns',
                'pg.status_pegawai',
                'pg.tmt_pns',
                'pg.no_seri_karpeg',
                'pg.tmt_cpns',
                'pg.tingkat_pendidikan',
                'pg.pendidikan_terakhir',
                'pg.bidang',
                'pg.dokumen_ktp',
                'pj.unit_organisasi',
                'pj.unit_organisasi_induk',
                'pj.jenis_jabatan',
                'pj.eselon',
                'pj.jabatan',
                'pj.tmt',
                'pj.lokasi_kerja',
                'pj.gol_ruang_awal',
                'pj.gol_ruang_akhir',
                'pj.tmt_golongan',
                'pj.gaji_pokok',
                'pj.masa_kerja_tahun',
                'pj.masa_kerja_bulan',
                'pj.no_spmt',
                'pj.tanggal_spmt',
                'pj.kppn'
            )
            ->where('users.user_id', $user_id)->first();

        $agamaOptions = DB::table('agama_id')->pluck('agama', 'agama');

        $kedudukanOptions = DB::table('kedudukan_hukum_id')->pluck('kedudukan', 'kedudukan');

        $jenispegawaiOptions = DB::table('jenis_pegawai_id')->pluck('jenis_pegawai', 'jenis_pegawai');

        $tingkatpendidikanOptions = DB::table('tingkat_pendidikan_id')->pluck('tingkat_pendidikan', 'tingkat_pendidikan');

        $bidangOptions = DB::table('bidang_id')->pluck('bidang', 'bidang');

        $jenisjabatanOptions = DB::table('jenis_jabatan_id')->pluck('nama', 'nama');

        $golonganOptions = DB::table('golongan_id')->pluck('nama_golongan', 'nama_golongan');

        $jenisdiklatOptions = DB::table('jenis_diklat_id')->pluck('jenis_diklat', 'jenis_diklat');

        $pendidikanterakhirOptions = DB::table('pendidikan_id')->pluck('pendidikan', 'pendidikan');

        $provinces = Province::all();


        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.employeeprofile', compact(
            'user',
            'users',
            'agamaOptions',
            'kedudukanOptions',
            'jenispegawaiOptions',
            'tingkatpendidikanOptions',
            'bidangOptions',
            'jenisjabatanOptions',
            'golonganOptions',
            'jenisdiklatOptions',
            'pendidikanterakhirOptions',
            'unreadNotifications',
            'readNotifications',
            'provinces',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }

    public function getkota(Request $request)
    {
        $nama_provinsi = $request->nama_provinsi;
        $provinsi = Province::where('name', $nama_provinsi)->first();

        if ($provinsi) {
            $id_provinsi = $provinsi->id;
            $kotakabupatens = Regency::where('province_id', $id_provinsi)->get();

            $option = "<option value='' disabled selected>-- Pilih Kota/Kabupaten --</option>";
            foreach ($kotakabupatens as $kotakabupaten) {
                $option .= "<option value='$kotakabupaten->name'>$kotakabupaten->name</option>";
            }

            echo $option;
        } else {
            echo "<option value='' disabled selected>-- Tidak ada data --</option>";
        }
    }

    public function getkecamatan_employee(Request $request)
    {
        $nama_kotakabupaten = $request->nama_kotakabupaten;
        $kotakabupaten = Regency::where('name', $nama_kotakabupaten)->first();

        if ($kotakabupaten) {
            $id_kotakabupaten = $kotakabupaten->id;
            $kecamatans = District::where('regency_id', $id_kotakabupaten)->get();

            $option = "<option value='' disabled selected>-- Pilih Kecamatan --</option>";
            foreach ($kecamatans as $kecamatan) {
                $option .= "<option value='$kecamatan->name'>$kecamatan->name</option>";
            }

            echo $option;
        } else {
            echo "<option value='' disabled selected>-- Tidak ada data --</option>";
        }
    }

    public function getkelurahan(Request $request)
    {
        $nama_kecamatan = $request->nama_kecamatan;
        $kecamatan = District::where('name', $nama_kecamatan)->first();

        if ($kecamatan) {
            $id_kecamatan = $kecamatan->id;
            $desakelurahans = Village::where('district_id', $id_kecamatan)->get();

            $option = "<option value='' disabled selected>-- Pilih Desa/Kelurahan --</option>";
            foreach ($desakelurahans as $desakelurahan) {
                $option .= "<option value='$desakelurahan->name'>$desakelurahan->name</option>";
            }

            echo $option;
        } else {
            echo "<option value='' disabled selected>-- Tidak ada data --</option>";
        }
    }

    /** page agama */
    public function indexAgama()
    {
        $agama = DB::table('agama_id')->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.agama', compact('agama', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getAgamaData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'agama',
        );

        $totalData = agama::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;

        if (empty($search)) {
            $agama = agama::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $agama =  agama::where('agama', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = agama::where('agama', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($agama)) {
            foreach ($agama as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['agama'] = $value->agama;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_agama' data-toggle='modal' data-target='#edit_agama' data-id='" . $value->id . "' data-agama='" . $value->agama . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_agama' data-toggle='modal' data-target='#delete_agama' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for agama */
    public function searchAgama(Request $request)
    {
        $keyword = $request->input('keyword');

        $agama = DB::table('agama_id')
            ->where('agama', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.agama', compact('agama', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record agama */
    public function saveRecordAgama(Request $request)
    {
        $request->validate([
            'agama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $agama = agama::where('agama', $request->agama)->first();
            if ($agama === null) {
                $agama = new agama;
                $agama->agama = $request->agama;
                $agama->save();

                DB::commit();
                Toastr::success('Data agama telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data agama telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data agama gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record agama */
    public function updateRecordAgama(Request $request)
    {
        DB::beginTransaction();
        try {

            $agama = [
                'id'    => $request->id,
                'agama' => $request->agama,
            ];
            agama::where('id', $request->id)->update($agama);

            DB::commit();
            Toastr::success('Data agama berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data agama gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record agama */
    public function deleteRecordAgama(Request $request)
    {
        try {

            agama::destroy($request->id);
            Toastr::success('Data agama berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data agama gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page kedudukan */
    public function indexKedudukan()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $kedudukan = DB::table('kedudukan_hukum_id')->get();
        return view('employees.kedudukan', compact('kedudukan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getKedudukanData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'kedudukan'
        );

        $totalData = kedudukan::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;

        if (empty($search)) {
            $kedudukan = kedudukan::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $kedudukan =  kedudukan::where('kedudukan', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = kedudukan::where('kedudukan', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($kedudukan)) {
            foreach ($kedudukan as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['kedudukan'] = $value->kedudukan;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_kedudukan' data-toggle='modal' data-target='#edit_kedudukan' data-id='" . $value->id . "' data-kedudukan='" . $value->kedudukan . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_kedudukan' data-toggle='modal' data-target='#delete_kedudukan' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for kedudukan */
    public function searchKedudukan(Request $request)
    {
        $keyword = $request->input('keyword');

        $kedudukan = DB::table('kedudukan_hukum_id')
            ->where('kedudukan', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.kedudukan', compact('kedudukan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record kedudukan */
    public function saveRecordKedudukan(Request $request)
    {
        $request->validate([
            'kedudukan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $kedudukan = kedudukan::where('kedudukan', $request->kedudukan)->first();
            if ($kedudukan === null) {
                $kedudukan = new kedudukan;
                $kedudukan->kedudukan = $request->kedudukan;
                $kedudukan->save();

                DB::commit();
                Toastr::success('Data kedudukan telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data kedudukan telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data kedudukan gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record kedudukan */
    public function updateRecordKedudukan(Request $request)
    {
        DB::beginTransaction();
        try {

            $kedudukan = [
                'id'    => $request->id,
                'kedudukan' => $request->kedudukan,
            ];
            kedudukan::where('id', $request->id)->update($kedudukan);

            DB::commit();
            Toastr::success('Data kedudukan berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data kedudukan gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record kedudukan */
    public function deleteRecordKedudukan(Request $request)
    {
        try {

            kedudukan::destroy($request->id);
            Toastr::success('Data kedudukan berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data kedudukan gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page pendidikan */
    public function indexPendidikan()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $pendidikan = DB::table('pendidikan_id')->get();
        return view('employees.pendidikan', compact('pendidikan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getPendidikanData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'pendidikan',
            2 => 'tk_pendidikan_id',
            3 => 'status_pendidikan'
        );

        $totalData = pendidikan::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;
        

        if (empty($search)) {
            $pendidikan = pendidikan::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $pendidikan =  pendidikan::where('pendidikan', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = pendidikan::where('pendidikan', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($pendidikan)) {
            foreach ($pendidikan as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['pendidikan'] = $value->pendidikan;
                $nestedData['tk_pendidikan_id'] = $value->tk_pendidikan_id;
                $nestedData['status_pendidikan'] = $value->status_pendidikan;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_pendidikan' data-toggle='modal' data-target='#edit_pendidikan' data-id='" . $value->id . "' data-pendidikan='" . $value->pendidikan . "' data-tk_pendidikan_id='" . $value->tk_pendidikan_id . "' data-status_pendidikan='" . $value->status_pendidikan . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_pendidikan' data-toggle='modal' data-target='#delete_pendidikan' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for pendidikan */
    public function searchPendidikan(Request $request)
    {
        $keyword = $request->input('keyword');

        $pendidikan = DB::table('pendidikan_id')
            ->where('pendidikan', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.pendidikan', compact('pendidikan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }


    /** save record pendidikan */
    public function saveRecordPendidikan(Request $request)
    {
        $request->validate([
            'pendidikan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $pendidikan = pendidikan::where('pendidikan', $request->pendidikan)->first();
            if ($pendidikan === null) {
                $pendidikan = new pendidikan;
                $pendidikan->pendidikan         = $request->pendidikan;
                $pendidikan->tk_pendidikan_id   = $request->tk_pendidikan_id;
                $pendidikan->status_pendidikan  = $request->status_pendidikan;
                $pendidikan->save();

                DB::commit();
                Toastr::success('Data pendidikan telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data pendidikan telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pendidikan gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record pendidikan */
    public function updateRecordPendidikan(Request $request)
    {
        $request->validate([
            'pendidikan'        => 'required|string|max:255',
            'tk_pendidikan_id'  => 'required|string|max:255',
            'status_pendidikan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $pendidikan = [
                'pendidikan'        => $request->pendidikan,
                'tk_pendidikan_id'  => $request->tk_pendidikan_id,
                'status_pendidikan' => $request->status_pendidikan,
            ];

            DB::table('pendidikan_id')->where('id', $request->id)->update($pendidikan);

            DB::commit();
            Toastr::success('Data pendidikan berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pendidikan gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record pendidikan */
    public function deleteRecordPendidikan(Request $request)
    {
        try {

            pendidikan::destroy($request->id);
            Toastr::success('Data pendidikan berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pendidikan gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page ruangan */
    public function indexRuangan()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $bidang = DB::table('bidang_id')->get();
        return view('employees.bidang', compact('bidang', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getRuanganData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'ruangan',
            2 => 'jumlah_tempat_tidur'
        );

        $totalData = ruangan::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;
        

        if (empty($search)) {
            $ruanganRSUD = ruangan::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $ruanganRSUD =  ruangan::where('ruangan', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = ruangan::where('ruangan', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($ruanganRSUD)) {
            foreach ($ruanganRSUD as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['ruangan'] = $value->ruangan;
                $nestedData['jumlah_tempat_tidur'] = $value->jumlah_tempat_tidur;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_ruangan' data-toggle='modal' data-target='#edit_ruangan' data-id='" . $value->id . "' data-ruangan='" . $value->ruangan . "' data-jumlah_tempat_tidur='" . $value->jumlah_tempat_tidur . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_ruangan' data-toggle='modal' data-target='#delete_ruangan' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for ruangan */
    public function searchRuangan(Request $request)
    {
        $keyword = $request->input('keyword');

        $ruangan = DB::table('ruangan_id')
            ->where('ruangan', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.ruangan', compact('ruangan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record ruangan */
    public function saveRecordRuangan(Request $request)
    {
        $request->validate([
            'ruangan' => 'required|string|max:255',
            'jumlah_tempat_tidur' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $ruangan = ruangan::where('ruangan', $request->ruangan)->first();
            if ($ruangan === null) {
                $ruangan = new ruangan;
                $ruangan->ruangan = $request->ruangan;
                $ruangan->jumlah_tempat_tidur = $request->jumlah_tempat_tidur;
                $ruangan->save();

                DB::commit();
                Toastr::success('Data ruangan telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data ruangan telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data ruangan gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record ruangan */
    public function updateRecordRuangan(Request $request)
    {
        DB::beginTransaction();
        try {

            $ruangan = [
                'id'    => $request->id,
                'ruangan' => $request->ruangan,
                'jumlah_tempat_tidur' => $request->jumlah_tempat_tidur,
            ];
            ruangan::where('id', $request->id)->update($ruangan);

            DB::commit();
            Toastr::success('Data ruangan berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data ruangan gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record ruangan */
    public function deleteRecordRuangan(Request $request)
    {
        try {

            ruangan::destroy($request->id);
            Toastr::success('Data ruangan berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data ruangan gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page sumpah */
    public function indexSumpah()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $sumpah = DB::table('sumpah_id')->get();
        return view('employees.sumpah', compact('sumpah', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getSumpahData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'sumpah'
        );

        $totalData = sumpah::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        // $counter = $start + 1;
        

        if (empty($search)) {
            $sumpah = sumpah::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $sumpah =  sumpah::where('sumpah', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = sumpah::where('sumpah', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($sumpah)) {
            foreach ($sumpah as $key => $value) {
                // $nestedData['id'] = $counter++;
                $nestedData['id'] = $value->id;
                $nestedData['sumpah'] = $value->sumpah;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_sumpah' data-toggle='modal' data-target='#edit_sumpah' data-id='" . $value->id . "' data-sumpah='" . $value->sumpah . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_sumpah' data-toggle='modal' data-target='#delete_sumpah' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for sumpah */
    public function searchSumpah(Request $request)
    {
        $keyword = $request->input('keyword');

        $sumpah = DB::table('sumpah_id')
            ->where('sumpah', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.sumpah', compact('sumpah', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record sumpah */
    public function saveRecordSumpah(Request $request)
    {
        $request->validate([
            'sumpah' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $sumpah = sumpah::where('sumpah', $request->sumpah)->first();
            if ($sumpah === null) {
                $sumpah = new sumpah();
                $sumpah->sumpah = $request->sumpah;
                $sumpah->save();

                DB::commit();
                Toastr::success('Data sumpah telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data sumpah telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data sumpah gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record sumpah */
    public function updateRecordSumpah(Request $request)
    {
        DB::beginTransaction();
        try {

            $sumpah = [
                'id'    => $request->id,
                'sumpah' => $request->sumpah,
            ];
            sumpah::where('id', $request->id)->update($sumpah);

            DB::commit();
            Toastr::success('Data sumpah berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data sumpah gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record sumpah */
    public function deleteRecordSumpah(Request $request)
    {
        try {

            sumpah::destroy($request->id);
            Toastr::success('Data sumpah berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data sumpah gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page status */
    public function indexStatus()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $jenis_pegawai = DB::table('jenis_pegawai_id')->get();
        return view('employees.status', compact('jenis_pegawai', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getStatusData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'id_jenis_pegawai',
            2 => 'jenis_pegawai'
        );

        $totalData = jenis_pegawai::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;

        if (empty($search)) {
            $jenis_pegawai = jenis_pegawai::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $jenis_pegawai =  jenis_pegawai::where('jenis_pegawai', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = jenis_pegawai::where('jenis_pegawai', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($jenis_pegawai)) {
            foreach ($jenis_pegawai as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['id_jenis_pegawai'] = $value->id_jenis_pegawai;
                $nestedData['jenis_pegawai'] = $value->jenis_pegawai;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_status' data-toggle='modal' data-target='#edit_status' data-id='" . $value->id . "' data-jenis_pegawai='" . $value->jenis_pegawai . "' data-id_jenis_pegawai='" . $value->id_jenis_pegawai . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_status' data-toggle='modal' data-target='#delete_status' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for status */
    public function searchStatus(Request $request)
    {
        $keyword = $request->input('keyword');

        $jenis_pegawai = DB::table('jenis_pegawai_id')
            ->where('jenis_pegawai', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.status', compact('jenis_pegawai', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record status */
    public function saveRecordStatus(Request $request)
    {
        $request->validate([
            'id_jenis_pegawai'  => 'required|string|max:255',
            'jenis_pegawai'     => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $jenis_pegawai = jenis_pegawai::where('jenis_pegawai', $request->jenis_pegawai)->first();
            if ($jenis_pegawai === null) {
                $jenis_pegawai = new jenis_pegawai;
                $jenis_pegawai->id_jenis_pegawai    = $request->id_jenis_pegawai;
                $jenis_pegawai->jenis_pegawai       = $request->jenis_pegawai;
                $jenis_pegawai->save();

                DB::commit();
                Toastr::success('Data status telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data status telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data status gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record status */
    public function updateRecordStatus(Request $request)
    {
        DB::beginTransaction();
        try {

            $jenis_pegawai = [
                'id'    => $request->id,
                'jenis_pegawai' => $request->jenis_pegawai,
            ];
            jenis_pegawai::where('id', $request->id)->update($jenis_pegawai);

            DB::commit();
            Toastr::success('Data status berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data status gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record status */
    public function deleteRecordStatus(Request $request)
    {
        try {

            jenis_pegawai::destroy($request->id);
            Toastr::success('Data status berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data status gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page golongan */
    public function indexGolongan()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $golongan = DB::table('golongan_id')->get();
        return view('employees.golongan', compact('golongan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function getGolonganData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nama',
            2 => 'nama_golongan',
        );

        $totalData = golongan_id::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;
        

        if (empty($search)) {
            $golongan = golongan_id::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $golongan =  golongan_id::where('nama_golongan', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = golongan_id::where('nama_golongan', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($golongan)) {
            foreach ($golongan as $key => $value) {
                $nestedData['id'] = $counter++;
                // $nestedData['id'] = $value->id;
                $nestedData['nama'] = $value->nama;
                $nestedData['nama_golongan'] = $value->nama_golongan;
                $nestedData['action'] = "<div class='dropdown dropdown-action'>
                                            <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                        <div class='dropdown-menu dropdown-menu-right'>
                                            <a href='#' class='dropdown-item edit_ref_golongan' data-toggle='modal' data-target='#edit_ref_golongan' data-id='" . $value->id . "' data-nama='" . $value->nama . "' data-nama_golongan='" . $value->nama_golongan . "'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                            <a href='#' class='dropdown-item delete_ref_golongan' data-toggle='modal' data-target='#delete_ref_golongan' data-id='" . $value->id . "'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                        </div>
                                     </div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return response()->json($json_data);
    }

    /** search for golongan */
    public function searchGolongan(Request $request)
    {
        $keyword = $request->input('keyword');

        $golongan = DB::table('golongan_id')
            ->where('nama_golongan', 'like', '%' . $keyword . '%')
            ->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.golongan', compact('golongan', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }


    /** save record goloongan */
    public function saveRecordGolongan(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nama_golongan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $golongan = golongan_id::where('nama_golongan', $request->nama_golongan)->first();
            if ($golongan === null) {
                $golongan = new golongan_id();
                $golongan->nama             = $request->nama;
                $golongan->nama_golongan    = $request->nama_golongan;
                $golongan->save();

                DB::commit();
                Toastr::success('Data golongan telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data golongan telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data golongan gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record golongan */
    public function updateRecordGolongan(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nama_golongan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $golongan = [
                'nama'        => $request->nama,
                'nama_golongan'  => $request->nama_golongan,
            ];

            DB::table('golongan_id')->where('id', $request->id)->update($golongan);

            DB::commit();
            Toastr::success('Data golongan berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data golongan gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record golongan */
    public function deleteRecordGolongan(Request $request)
    {
        try {

            golongan_id::destroy($request->id);
            Toastr::success('Data golongan berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data golongan gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** page SIP */
    public function indexSIP()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $datasip = Session::get('user_id');
        $sip = sipDokter::where('user_id', $datasip)->get();

        return view('employees.sip_dokter', compact('datasip', 'sip', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record SIP dokter */
    public function saveRecordSIPDokter(Request $request)
    {
        $request->validate([
            'user_id'           => 'required|string|max:255',
            'nip'               => 'required|string|max:255',
            'name'              => 'required|string|max:255',
            'unit_kerja'        => 'required|string|max:255',
            'nomor_sip'         => 'required|string|max:255',
            'tanggal_terbit'    => 'required|string|max:255',
            'tanggal_berlaku'   => 'required|string|max:255',
            'dokumen_sip'       => 'required|mimes:pdf|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $dokumen_sip = time() . '.' . $request->dokumen_sip->extension();
            $request->dokumen_sip->move(public_path('assets/DokumenSIP'), $dokumen_sip);

            $sip = new sipDokter;
            $sip->user_id               = $request->user_id;
            $sip->nip                   = $request->nip;
            $sip->name                  = $request->name;
            $sip->unit_kerja            = $request->unit_kerja;
            $sip->nomor_sip             = $request->nomor_sip;
            $sip->tanggal_terbit        = $request->tanggal_terbit;
            $sip->tanggal_berlaku       = $request->tanggal_berlaku;
            $sip->dokumen_sip           = $dokumen_sip;
            $sip->save();

            DB::commit();
            Toastr::success('Data SIP dokter telah ditambah ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data SIP dokter gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }
    /** end Add record SIP dokter */

    public function searchpegawaipensiunList(Request $request)
    {
        $query = DB::table('users')
            ->leftjoin('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->leftjoin('posisi_jabatan', 'users.user_id', 'posisi_jabatan.user_id')
            ->select(
                'users.*',
                'profil_pegawai.name',
                'profil_pegawai.email',
                'profil_pegawai.nip',
                'profil_pegawai.gelar_depan',
                'profil_pegawai.gelar_belakang',
                'profil_pegawai.tempat_lahir',
                'profil_pegawai.tanggal_lahir',
                'profil_pegawai.jenis_kelamin',
                'profil_pegawai.agama',
                'profil_pegawai.jenis_dokumen',
                'profil_pegawai.no_dokumen',
                'profil_pegawai.kelurahan',
                'profil_pegawai.kecamatan',
                'profil_pegawai.kota',
                'profil_pegawai.provinsi',
                'profil_pegawai.kode_pos',
                'profil_pegawai.no_hp',
                'profil_pegawai.no_telp',
                'profil_pegawai.jenis_pegawai',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.status_pegawai',
                'profil_pegawai.tmt_pns',
                'profil_pegawai.no_seri_karpeg',
                'profil_pegawai.tmt_cpns',
                'profil_pegawai.tingkat_pendidikan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.ruangan',
                'users.name',
                'posisi_jabatan.jabatan'
            )
            ->where('users.role_name', 'User');

        if ($request->has('nip')) {
            $query->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }

        if ($request->has('name')) {
            $query->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('email')) {
            $query->where('profil_pegawai.email', 'LIKE', '%' . $request->input('email') . '%');
        }

        // Tambahkan kondisi untuk kedudukan_pns
        $query->where('profil_pegawai.kedudukan_pns', 'Pensiun');

        $users = $query->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.datapensiunlist', compact('users', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function searchpegawaipensiunCard(Request $request)
    {
        $query = DB::table('users')
            ->leftjoin('profil_pegawai', 'users.user_id', 'profil_pegawai.user_id')
            ->leftjoin('posisi_jabatan', 'users.user_id', 'posisi_jabatan.user_id')
            ->select(
                'users.*',
                'profil_pegawai.name',
                'profil_pegawai.email',
                'profil_pegawai.nip',
                'profil_pegawai.gelar_depan',
                'profil_pegawai.gelar_belakang',
                'profil_pegawai.tempat_lahir',
                'profil_pegawai.tanggal_lahir',
                'profil_pegawai.jenis_kelamin',
                'profil_pegawai.agama',
                'profil_pegawai.jenis_dokumen',
                'profil_pegawai.no_dokumen',
                'profil_pegawai.kelurahan',
                'profil_pegawai.kecamatan',
                'profil_pegawai.kota',
                'profil_pegawai.provinsi',
                'profil_pegawai.kode_pos',
                'profil_pegawai.no_hp',
                'profil_pegawai.no_telp',
                'profil_pegawai.jenis_pegawai',
                'profil_pegawai.kedudukan_pns',
                'profil_pegawai.status_pegawai',
                'profil_pegawai.tmt_pns',
                'profil_pegawai.no_seri_karpeg',
                'profil_pegawai.tmt_cpns',
                'profil_pegawai.tingkat_pendidikan',
                'profil_pegawai.pendidikan_terakhir',
                'profil_pegawai.ruangan',
                'users.name',
                'posisi_jabatan.jabatan'
            )
            ->where('users.role_name', 'User');

        if ($request->has('nip')) {
            $query->where('profil_pegawai.nip', 'LIKE', '%' . $request->input('nip') . '%');
        }

        if ($request->has('name')) {
            $query->where('profil_pegawai.name', 'LIKE', '%' . $request->input('name') . '%');
        }

        if ($request->has('email')) {
            $query->where('profil_pegawai.email', 'LIKE', '%' . $request->input('email') . '%');
        }

        // Tambahkan kondisi untuk kedudukan_pns
        $query->where('profil_pegawai.kedudukan_pns', 'Pensiun');

        $users = $query->get();

        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        return view('employees.datapensiuncard', compact('users', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** page unit organisasi */
    public function indexUnitOrganisasi()
    {
        $result_tema = DB::table('mode_aplikasi')
            ->select(
                'mode_aplikasi.id',
                'mode_aplikasi.tema_aplikasi',
                'mode_aplikasi.warna_sistem',
                'mode_aplikasi.warna_sistem_tulisan',
                'mode_aplikasi.warna_mode',
                'mode_aplikasi.tabel_warna',
                'mode_aplikasi.tabel_tulisan_tersembunyi',
                'mode_aplikasi.warna_dropdown_menu',
                'mode_aplikasi.ikon_plugin',
                'mode_aplikasi.bayangan_kotak_header',
                'mode_aplikasi.warna_mode_2',
                )
            ->where('user_id', auth()->user()->user_id)
            ->get();

        $user = auth()->user();
        $role = $user->role_name;
        $unreadNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNull('read_at')
            ->get();

        $readNotifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->whereNotNull('read_at')
            ->get();

        $semua_notifikasi = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->get();

        $belum_dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNull('read_at')
            ->get();

        $dibaca = DB::table('notifications')
            ->leftjoin('users', 'notifications.notifiable_id', 'users.id')
            ->select(
                'notifications.*',
                'notifications.id',
                'users.name',
                'users.avatar'
            )
            ->whereNotNull('read_at')
            ->get();

        $unit_organisasi = DB::table('unit_organisasi')->get();
        return view('employees.unit-organisasi', compact('unit_organisasi', 
            'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** save record organisasi */
    public function saveRecordUnitOrganisasi(Request $request)
    {
        $request->validate([
            'unor_nama' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $unor_nama = UnitOrganisasi::where('unor_nama', $request->unor_nama)->first();
            if ($unor_nama === null) {
                $unor_nama = new UnitOrganisasi();
                $unor_nama->unor_nama         = $request->unor_nama;
                $unor_nama->unor_id           = $request->unor_id;
                $unor_nama->save();

                DB::commit();
                Toastr::success('Data unit organisasi telah ditambah ✔', 'Sukses');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data unit organisasi telah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data unit organisasi gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record organisasi */
    public function updateRecordUnitOrganisasi(Request $request)
    {
        $request->validate([
            'unor_id'        => 'required|string|max:255',
            'unor_nama'      => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $unor = [
                'unor_id'        => $request->unor_id,
                'unor_nama'  => $request->unor_nama,
            ];

            DB::table('unit_organisasi')->where('id', $request->id)->update($unor);

            DB::commit();
            Toastr::success('Data organisasi berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data organisasi gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record organisasi */
    public function deleteRecordUnitOrganisasi(Request $request)
    {
        try {

            UnitOrganisasi::destroy($request->id);
            Toastr::success('Data unit organisasi berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data unit organisasi gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }
}