<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\User;
use App\Models\ProfileInformation;
use App\Models\ProfilPegawai;
use App\Models\PosisiJabatan;
use App\Models\PersonalInformation;
use App\Rules\MatchOldPassword;
use App\Models\UserEmergencyContact;
use App\Models\Notification;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\userActivityLog;
use App\Models\activityLog;
use Carbon\Carbon;
use Session;
use Auth;
use Hash;
use DB;

class UserManagementController extends Controller
{
    /** index page */
    public function index()
    {
        if (Session::get('role_name') == 'Kepala Dinas') {
            $result      = DB::table('users')->get();
            $role_name   = DB::table('role_type_users')->get();
            $status_user = DB::table('user_types')->get();

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

            return view('usermanagement.user_control', compact('result', 'role_name', 'status_user',
                'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
        } else {
            return redirect()->route('home');
        }
    }

    /** get list data and search */
    public function getUsersData(Request $request)
    {
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowPerPage      = $request->get("length"); // total number of rows per page
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column']; // Column index
        $columnName      = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue     = $search_arr['value']; // Search value

        $users =  DB::table('users');
        $totalRecords = $users->count();

        $user_name   = $request->user_name;
        $type_role   = $request->type_role;
        $type_status = $request->type_status;

        /** search for name */
        if (!empty($user_name)) {
            $users->when($user_name,function ($query) use ($user_name) {
                $query->where('name','LIKE','%'.$user_name.'%');
            });
        }

        /** search for type_role */
        if (!empty($type_role)) {
            $users->when($type_role, function ($query) use ($type_role) {
                $query->where('role_name',$type_role);
            });
        }

        /** search for status */
        if (!empty($type_status)) {
            $users->when($type_status, function ($query) use ($type_status) {
                $query->where('status',$type_status);
            });
        }

        $totalRecordsWithFilter = $users->where(function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
            $query->orWhere('user_id', 'like', '%' . $searchValue . '%');
            $query->orWhere('email', 'like', '%' . $searchValue . '%');
            $query->orWhere('nip', 'like', '%' . $searchValue . '%');
            $query->orWhere('no_dokumen', 'like', '%' . $searchValue . '%');
            $query->orWhere('join_date', 'like', '%' . $searchValue . '%');
            $query->orWhere('role_name', 'like', '%' . $searchValue . '%');
            $query->orWhere('status', 'like', '%' . $searchValue . '%');
        })->count();

        if ($columnName == 'user_id') {
            $columnName = 'user_id';
        }
        $records = $users->orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
                $query->orWhere('user_id', 'like', '%' . $searchValue . '%');
                $query->orWhere('email', 'like', '%' . $searchValue . '%');
                $query->orWhere('nip', 'like', '%' . $searchValue . '%');
                $query->orWhere('no_dokumen', 'like', '%' . $searchValue . '%');
                $query->orWhere('join_date', 'like', '%' . $searchValue . '%');
                $query->orWhere('role_name', 'like', '%' . $searchValue . '%');
                $query->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowPerPage)
            ->get();
        $data_arr = [];
        foreach ($records as $key => $record) {
            $record->name = '<h2 class="table-avatar"><a href="'.url('staff/profile/' . $record->user_id).'" class="name">'.'<img class="avatar" data-avatar='.$record->avatar.' src="'.url('/assets/images/'.$record->avatar).'">' .$record->name.'</a></h2>';
            if ($record->role_name == 'Kepala Dinas') { /** color role name */
                $role_name = '<span class="badge bg-inverse-danger role_name">'.$record->role_name.'</span>';
            } elseif ($record->role_name == 'Staff') {
                $role_name = '<span class="badge bg-inverse-info role_name">'.$record->role_name.'</span>';
            } elseif ($record->role_name == 'Kepala Bidang') {
                $role_name = '<span class="badge bg-inverse-success role_name">'.$record->role_name.'</span>'; 
            } else {
                $role_name = 'NULL'; /** null role name */
            }
            
            /** status */
            $full_status = '
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-success" style="color: #55ce63 !important;"></i> Active </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-warning" style="color: #ffbc34 !important;"></i> Inactive </a>
                    <a class="dropdown-item"><i class="fa fa-dot-circle-o text-danger" style="color: #f62d51 !important;"></i> Disable </a>
                </div>
            ';

            if ($record->status == 'Active') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-success" style="color: #55ce63 !important;"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } elseif ($record->status == 'Inactive') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-info" style="color: #ffbc34 !important;"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } elseif ($record->status == 'Disable') {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-danger" style="color: #f62d51 !important;"></i>
                        <span class="status_s">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            } else {
                $status = '
                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-dark"></i>
                        <span class="statuss">'.$record->status.'</span>
                    </a>
                    '.$full_status.'
                ';
            }

            $joinDate = Carbon::parse($record->join_date)->translatedFormat('l, j F Y || h:i A');
            $data_arr [] = [
                "no"           => '<span class="id" data-id = '.$record->id.'>'.$start + ($key + 1).'</span>',
                "name"         => $record->name,
                "user_id"      => '<span class="user_id">'.$record->user_id.'</span>',
                "email"        => '<a href="mailto:' . $record->email . '"><span class="email">' . $record->email . '</span></a>',
                "nip"     => '<span class="nip">'.$record->nip.'</span>',
                "no_dokumen" => '<span class="no_dokumen">'.$record->no_dokumen.'</span>',
                "join_date"    => $joinDate,
                "role_name"    => $role_name,
                "status"       => $status,
                "action"       =>
                '
                <td>
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item userUpdate" data-toggle="modal" data-id="'.$record->id.'" data-target="#edit_user">
                                <i class="fa fa-pencil m-r-5"></i> Edit
                            </a>
                        </div>
                    </div>
                </td>
                ',
            ];
        }
        $response = [
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordsWithFilter,
            "aaData"               => $data_arr
        ];
        return response()->json($response);
    }

    // Function untuk hapus data pengguna
    // <a class="dropdown-item userDelete" data-toggle="modal" data-id="' . $record->id . '" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>

    /** use activity log */
    public function activityLog()
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
        
        $activityLog = DB::table('user_activity_logs')->get();
        return view('usermanagement.user_activity_log', compact('activityLog', 'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** activity log */
    public function activityLogInLogOut()
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

        $activityLog = DB::table('activity_logs')->get();
        return view('usermanagement.activity_log', compact('activityLog', 'unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** profile admin */
    public function admin_profile()
    {
        $profile = Session::get('user_id');
        $user = DB::table('users')->get();
        $employees = DB::table('profile_information')->where('user_id', $profile)->first();
        $pendidikanterakhirOptions = DB::table('pendidikan_id')->pluck('pendidikan', 'pendidikan');
        $agamaOptions = DB::table('agama_id')->pluck('agama', 'agama');
        $bidangOptions = DB::table('bidang_id')->pluck('bidang', 'bidang');

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

        if (empty($employees)) {
            $information = DB::table('profile_information')->where('user_id', $profile)->first();
            $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
            $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
            return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
        } else {
            $user_id = $employees->user_id;
            if ($user_id == $profile) {
                $information = DB::table('profile_information')->where('user_id', $profile)->first();
                $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
                $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            } else {
                $information = ProfileInformation::all();
                $propeg = ProfilPegawai::all();
                $posjab = PosisiJabatan::all();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            }
        }
    }

    /** profile super admin */
    public function superadmin_profile()
    {
        $profile = Session::get('user_id');
        $user = DB::table('users')->get();
        $employees = DB::table('profile_information')->where('user_id', $profile)->first();
        $pendidikanterakhirOptions = DB::table('pendidikan_id')->pluck('pendidikan', 'pendidikan');
        $agamaOptions = DB::table('agama_id')->pluck('agama', 'agama');
        $bidangOptions = DB::table('bidang_id')->pluck('bidang', 'bidang');

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
            
        if (empty($employees)) {
            $information = DB::table('profile_information')->where('user_id', $profile)->first();
            $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
            $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
            return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
        } else {
            $user_id = $employees->user_id;
            if ($user_id == $profile) {
                $information = DB::table('profile_information')->where('user_id', $profile)->first();
                $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
                $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            } else {
                $information = ProfileInformation::all();
                $propeg = ProfilPegawai::all();
                $posjab = PosisiJabatan::all();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            }
        }
    }

    public function kepalaruangan_profile()
    {
        $profile = Session::get('user_id');
        $user = DB::table('users')->get();
        $employees = DB::table('profile_information')->where('user_id', $profile)->first();
        $pendidikanterakhirOptions = DB::table('pendidikan_id')->pluck('pendidikan', 'pendidikan');
        $agamaOptions = DB::table('agama_id')->pluck('agama', 'agama');
        $bidangOptions = DB::table('bidang_id')->pluck('bidang', 'bidang');

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

        if (empty($employees)) {
            $information = DB::table('profile_information')->where('user_id', $profile)->first();
            $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
            $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
            return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
        } else {
            $user_id = $employees->user_id;
            if ($user_id == $profile) {
                $information = DB::table('profile_information')->where('user_id', $profile)->first();
                $propeg = DB::table('profil_pegawai')->where('user_id', $profile)->first();
                $posjab = DB::table('posisi_jabatan')->where('user_id', $profile)->first();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            } else {
                $information = ProfileInformation::all();
                $propeg = ProfilPegawai::all();
                $posjab = PosisiJabatan::all();
                return view('usermanagement.profile_user', compact('information', 'user', 'propeg', 'posjab', 'agamaOptions',
                    'pendidikanterakhirOptions', 'unreadNotifications', 'readNotifications', 'bidangOptions', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            }
        }
    }

    /** profile user */
    public function user_profile()
    {
        $provinces = Province::all();
        $profile = Session::get('user_id');
        $user = DB::table('users')->get();
        $employees = DB::table('profile_information')->where('user_id', $profile)->first();
        $result_profilpegawai = ProfilPegawai::where('user_id', $profile)->first();

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

        $result_posisijabatan = PosisiJabatan::where('user_id', Session::get('user_id'))->first();
        $datauser = Session::get('user_id');
        $sqluser = User::where('user_id', $datauser)->get();
        $agamaOptions = DB::table('agama_id')->pluck('agama', 'agama');
        $jenispegawaiOptions = DB::table('jenis_pegawai_id')->pluck('jenis_pegawai', 'jenis_pegawai');
        $kedudukanOptions = DB::table('kedudukan_hukum_id')->pluck('kedudukan', 'kedudukan');
        $tingkatpendidikanOptions = DB::table('tingkat_pendidikan_id')->pluck('tingkat_pendidikan', 'tingkat_pendidikan');
        $bidangOptions = DB::table('bidang_id')->pluck('bidang', 'bidang');
        $jenisjabatanOptions = DB::table('jenis_jabatan_id')->pluck('nama', 'nama');
        $golonganOptions = DB::table('golongan_id')->pluck('nama_golongan', 'nama_golongan');
        $jenisdiklatOptions = DB::table('jenis_diklat_id')->pluck('jenis_diklat', 'jenis_diklat');
        $pendidikanterakhirOptions = DB::table('pendidikan_id')->pluck('pendidikan', 'pendidikan');

        if (empty($employees)) {
            $information = DB::table('profile_information')->where('user_id', $profile)->first();
            return view('usermanagement.profile-user', compact('information', 'user', 'result_profilpegawai', 'result_posisijabatan',
                'sqluser', 'agamaOptions', 'jenispegawaiOptions', 'kedudukanOptions', 'tingkatpendidikanOptions', 'bidangOptions',
                'jenisjabatanOptions', 'golonganOptions', 'jenisdiklatOptions', 'unreadNotifications', 'readNotifications',
                'pendidikanterakhirOptions', 'provinces', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
        } else {
            $user_id = $employees->user_id;
            if ($user_id == $profile) {
                $information = DB::table('profile_information')->where('user_id', $profile)->first();
                return view('usermanagement.profile-user', compact('information', 'user', 'result_profilpegawai', 'result_posisijabatan',
                    'sqluser', 'agamaOptions', 'jenispegawaiOptions', 'kedudukanOptions', 'tingkatpendidikanOptions', 'bidangOptions',
                    'jenisjabatanOptions', 'golonganOptions', 'jenisdiklatOptions', 'unreadNotifications', 'readNotifications',
                    'pendidikanterakhirOptions', 'provinces', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            } else {
                $information = ProfileInformation::all();
                return view('usermanagement.profile-user', compact('information', 'user', 'result_profilpegawai', 'result_posisijabatan',
                    'sqluser', 'agamaOptions', 'jenispegawaiOptions', 'kedudukanOptions', 'tingkatpendidikanOptions', 'bidangOptions',
                    'jenisjabatanOptions', 'golonganOptions', 'jenisdiklatOptions', 'unreadNotifications', 'readNotifications',
                    'pendidikanterakhirOptions', 'provinces', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
            }
        }
    }

    public function getkotakabupaten(Request $request)
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

    public function getkecamatan(Request $request)
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

    public function getdesakelurahan(Request $request)
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

    /** save profile information */
    public function profileInformation(Request $request)
    {
        try {
            $tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->birthDate)->format('Y-m-d');

            $updateProfil = [
                'tanggal_lahir'         => $tanggal_lahir,
                'tempat_lahir'          => $request->tmpt_lahir,
                'pendidikan_terakhir'   => $request->pendidikan_terakhir,
                'agama'                 => $request->agama,
                'jenis_kelamin'         => $request->jk,
                'bidang'               => $request->bidang
            ];
            DB::table('profil_pegawai')->where('user_id', $request->user_id)->update($updateProfil);

            $updatePosisi = [
                'jabatan'               => $request->jabatan,
            ];
            DB::table('posisi_jabatan')->where('user_id', $request->user_id)->update($updatePosisi);

            $updateNIPBidang = [
                'bidang'               => $request->bidang,
                'nip'                   => $request->nip,
            ];
            DB::table('users')->where('user_id', $request->user_id)->update($updateNIPBidang);

            $updateDP = [
                'tanggal_lahir'         => $request->tanggal_lahir,
                'tempat_lahir'          => $request->tempat_lahir,
                'pendidikan_terakhir'   => $request->pendidikan_terakhir,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'bidang'               => $request->bidang
            ];
            DB::table('daftar_pegawai')->where('user_id', $request->user_id)->update($updateDP);

            $information = ProfileInformation::updateOrCreate(['user_id' => $request->user_id]);
            $information->name         = $request->name;
            $information->user_id      = $request->user_id;
            $information->email        = $request->email;
            $information->tgl_lahir    = $request->birthDate;
            $information->jk           = $request->jk;
            $information->alamat       = $request->alamat;
            $information->avatar       = $request->avatar;
            $information->tmpt_lahir   = $request->tmpt_lahir;
            $information->save();

            DB::commit();
            Toastr::success('Data profil informasi berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data profil informasi gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }
    /** save profile information */

    /** save profile information */
    public function profileInformation2(Request $request)
    {
        try {
            $tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->birthDate)->format('Y-m-d');

            $updateProfil = [
                'tanggal_lahir'         => $tanggal_lahir,
                'tempat_lahir'          => $request->tmpt_lahir,
                'jenis_kelamin'         => $request->jk
            ];
            DB::table('profil_pegawai')->where('user_id', $request->user_id)->update($updateProfil);

            $updateNIP = [
                'nip'                   => $request->nip,
            ];
            DB::table('users')->where('user_id', $request->user_id)->update($updateNIP);

            $information = ProfileInformation::updateOrCreate(['user_id' => $request->user_id]);
            $information->name         = $request->name;
            $information->user_id      = $request->user_id;
            $information->email        = $request->email;
            $information->tgl_lahir    = $request->birthDate;
            $information->jk           = $request->jk;
            $information->alamat       = $request->alamat;
            $information->avatar       = $request->avatar;
            $information->tmpt_lahir   = $request->tmpt_lahir;
            $information->save();

            DB::commit();
            Toastr::success('Data profil informasi berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data profil informasi gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }
    /** save profile information */

    public function fotoProfile(Request $request)
    {
        try {
            if (!empty($request->images)) {
                $image_name = $request->hidden_image;
                $image      = $request->file('images');
                if ($image_name == 'photo_defaults.jpg') {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/assets/images/'), $image_name);
                    }
                } else {
                    if ($image != '') {
                        $image_name = rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/assets/images/'), $image_name);
                        unlink('assets/images/' . Auth::user()->avatar);
                    }
                }
                $update = [
                    'user_id'   => $request->user_id,
                    'name'      => $request->name,
                    'avatar'    => $image_name,
                ];
                User::where('user_id', $request->user_id)->update($update);
            }


            $updateDP = [
                'avatar'    => $image_name
            ];
            DB::table('daftar_pegawai')->where('user_id', $request->user_id)->update($updateDP);


            DB::commit();
            Toastr::success('Foto profil berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Foto profil gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** save new user */
    public function addNewUserSave(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'nip'           => 'required|string|max:255',
            'no_dokumen'    => 'required|string|max:255',
            'tema_aplikasi' => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'role_name'     => 'required|string|max:255',
            'status'        => 'required|string|max:255',
            'image'         => 'required|string|max:255',
            'password'      => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $dt       = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $user = new User;
            $user->name             = $request->name;
            $user->nip              = $request->nip;
            $user->no_dokumen       = $request->no_dokumen;
            $user->tema_aplikasi    = $request->tema_aplikasi;
            $user->email            = $request->email;
            $user->join_date        = $todayDate;
            $user->role_name        = $request->role_name;
            $user->status           = $request->status;
            $user->avatar           = $request->image;
            $user->password         = Hash::make($request->password);
            $user->save();
            DB::commit();
            Toastr::success('Data pengguna berhasil ditambah ✔', 'Success');
            return redirect()->route('manajemen-pengguna');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pengguna gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }

    /** update record */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id      = $request->user_id;
            $name         = $request->name;
            $nip          = $request->nip;
            $no_dokumen   = $request->no_dokumen;
            $email        = $request->email;
            $role_name    = $request->role_name;
            $status       = $request->status;
            $avatar       = $request->images;

            $dt       = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $update = [

                'user_id'      => $user_id,
                'name'         => $name,
                'nip'          => $nip,
                'no_dokumen'   => $no_dokumen,
                'role_name'    => $role_name,
                'email'        => $email,
                'status'       => $status,
                'avatar'       => $avatar,
            ];

            $activityLog = [
                'user_name'    => $name,
                'email'        => $email,
                'status'       => $status,
                'role_name'    => $role_name,
                'modify_user'  => 'Perbaharui Data',
                'date_time'    => $todayDate,
            ];

            DB::table('user_activity_logs')->insert($activityLog);
            User::where('user_id', $request->user_id)->update($update);
            DB::commit();
            Toastr::success('Data pengguna berhasil diperbaharui ✔', 'Success');
            return redirect()->route('manajemen-pengguna');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pengguna gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {

            $dt        = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $activityLog = [
                'user_name'    => Session::get('name'),
                'email'        => Session::get('email'),
                'status'       => Session::get('status'),
                'role_name'    => Session::get('role_name'),
                'modify_user'  => 'Hapus Data',
                'date_time'    => $todayDate,
            ];

            DB::table('user_activity_logs')->insert($activityLog);

            if ($request->avatar == 'photo_defaults.jpg') {
                /** remove all information user */
                User::destroy($request->id);
                PersonalInformation::destroy($request->id);
                UserEmergencyContact::destroy($request->id);
            } else {
                User::destroy($request->id);
                unlink('assets/images/' . $request->avatar);
                PersonalInformation::destroy($request->id);
                UserEmergencyContact::destroy($request->id);
            }

            DB::commit();
            Toastr::success('Data pengguna berhasil dihapus ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data pengguna gagal dihapus ✘', 'Error');
            return redirect()->back();
        }
    }

    /** view change password */
    public function changePasswordView()
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

        return view('settings.changepassword', compact('unreadNotifications', 'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    /** change password in db */
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        
        DB::beginTransaction();
        try {

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            DB::commit();
            Toastr::success('Kata sandi berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('Kata sandi gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }

    /** Tambah Data Profil Pegawai */
    public function profilePegawaiAdd(Request $request)
    {
        $request->validate([
            'nip'                   => 'required|string|max:255',
            'gelar_depan'           => 'required|string|max:255',
            'gelar_belakang'        => 'required|string|max:255',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|string|max:255',
            'jenis_kelamin'         => 'required|string|max:255',
            'agama'                 => 'required|string|max:255',
            'jenis_dokumen'         => 'required|string|max:255',
            'no_dokumen'            => 'required|string|max:255',
            'kelurahan'             => 'required|string|max:255',
            'kecamatan'             => 'required|string|max:255',
            'kota'                  => 'required|string|max:255',
            'provinsi'              => 'required|string|max:255',
            'kode_pos'              => 'required|string|max:255',
            'no_hp'                 => 'required|string|max:255',
            'no_telp'               => 'required|string|max:255',
            'jenis_pegawai'         => 'required|string|max:255',
            'kedudukan_pns'         => 'required|string|max:255',
            'status_pegawai'        => 'required|string|max:255',
            'tmt_pns'               => 'required|string|max:255',
            'no_seri_karpeg'        => 'required|string|max:255',
            'tmt_cpns'              => 'required|string|max:255',
            'tingkat_pendidikan'    => 'required|string|max:255',
            'pendidikan_terakhir'   => 'required|string|max:255',
            'bidang'               => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $addProfilPegawai = ProfilPegawai::where('user_id', '=', $request->user_id)->first();
            if ($addProfilPegawai === null) {

                $addProfilPegawai = new ProfilPegawai();
                $addProfilPegawai->user_id                 = $request->user_id;
                $addProfilPegawai->nip                     = $request->nip;
                $addProfilPegawai->gelar_depan             = $request->gelar_depan;
                $addProfilPegawai->gelar_belakang          = $request->gelar_belakang;
                $addProfilPegawai->tempat_lahir            = $request->tempat_lahir;
                $addProfilPegawai->tanggal_lahir           = $request->tanggal_lahir;
                $addProfilPegawai->jenis_kelamin           = $request->jenis_kelamin;
                $addProfilPegawai->agama                   = $request->agama;
                $addProfilPegawai->jenis_dokumen           = $request->jenis_dokumen;
                $addProfilPegawai->no_dokumen              = $request->no_dokumen;
                $addProfilPegawai->kelurahan               = $request->kelurahan;
                $addProfilPegawai->kecamatan               = $request->kecamatan;
                $addProfilPegawai->kota                    = $request->kota;
                $addProfilPegawai->provinsi                = $request->provinsi;
                $addProfilPegawai->kode_pos                = $request->kode_pos;
                $addProfilPegawai->no_hp                   = $request->no_hp;
                $addProfilPegawai->no_telp                 = $request->no_telp;
                $addProfilPegawai->jenis_pegawai           = $request->jenis_pegawai;
                $addProfilPegawai->kedudukan_pns           = $request->kedudukan_pns;
                $addProfilPegawai->status_pegawai          = $request->status_pegawai;
                $addProfilPegawai->tmt_pns                 = $request->tmt_pns;
                $addProfilPegawai->no_seri_karpeg          = $request->no_seri_karpeg;
                $addProfilPegawai->tmt_cpns                = $request->tmt_cpns;
                $addProfilPegawai->tingkat_pendidikan      = $request->tingkat_pendidikan;
                $addProfilPegawai->pendidikan_terakhir     = $request->pendidikan_terakhir;
                $addProfilPegawai->bidang                 = $request->bidang;
                $addProfilPegawai->save();

                DB::commit();
                Toastr::success('Data profil pegawai berhasil ditambah ✔', 'Success');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data profil pegawai sudah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data profil pegawai gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }
    /** End Tambah Data Profil Pegawai */

    /** Upload Dokumen KTP */
    public function uploadDokumenKTP(Request $request)
    {
        
        DB::beginTransaction();
        try {

            if ($request->hasFile('dokumen_ktp')) {
                $existingFile = DB::table('profil_pegawai')->where('user_id', $request->user_id)->value('dokumen_ktp');
                if ($existingFile) {
                    $existingFilePath = public_path('assets/DokumenKTP') . '/' . $existingFile;
                    if (file_exists($existingFilePath)) {
                        unlink($existingFilePath);
                    }
                }
                $dokumen_ktp = time() . '.' . $request->file('dokumen_ktp')->getClientOriginalExtension();
                $request->file('dokumen_ktp')->move(public_path('assets/DokumenKTP'), $dokumen_ktp);
                $update['dokumen_ktp'] = $dokumen_ktp;
            }
            
            DB::table('profil_pegawai')->where('user_id', $request->user_id)->update($update);

            DB::commit();
            Toastr::success('Unggah dokumen KTP berhasil ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Unggah dokumen KTP gagal ✘', 'Error');
            return redirect()->back();
        }
    }
    /** /Upload Dokumen KTP */

    /** Edit Data Posisi & Jabatan */
    public function profilePegawaiEdit(Request $request)
    {
        $request->validate([
            'nip'                   => 'required|string|max:255',
            'gelar_depan'           => 'required|string|max:255',
            'gelar_belakang'        => 'required|string|max:255',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|string|max:255',
            'jenis_kelamin'         => 'required|string|max:255',
            'agama'                 => 'required|string|max:255',
            'jenis_dokumen'         => 'required|string|max:255',
            'no_dokumen'            => 'required|string|max:255',
            'kelurahan'             => 'required|string|max:255',
            'kecamatan'             => 'required|string|max:255',
            'kota'                  => 'required|string|max:255',
            'provinsi'              => 'required|string|max:255',
            'kode_pos'              => 'required|string|max:255',
            'no_hp'                 => 'required|string|max:255',
            'no_telp'               => 'required|string|max:255',
            'jenis_pegawai'         => 'required|string|max:255',
            'kedudukan_pns'         => 'required|string|max:255',
            'status_pegawai'        => 'required|string|max:255',
            'tmt_pns'               => 'required|string|max:255',
            'no_seri_karpeg'        => 'required|string|max:255',
            'tmt_cpns'              => 'required|string|max:255',
            'tingkat_pendidikan'    => 'required|string|max:255',
            'pendidikan_terakhir'   => 'required|string|max:255',
            'bidang'               => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $editProfilPegawai = [
                'nip'                   => $request->nip,
                'gelar_depan'           => $request->gelar_depan,
                'gelar_belakang'        => $request->gelar_belakang,
                'tempat_lahir'          => $request->tempat_lahir,
                'tanggal_lahir'         => $request->tanggal_lahir,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'agama'                 => $request->agama,
                'jenis_dokumen'         => $request->jenis_dokumen,
                'no_dokumen'            => $request->no_dokumen,
                'kelurahan'             => $request->kelurahan,
                'kecamatan'             => $request->kecamatan,
                'kota'                  => $request->kota,
                'provinsi'              => $request->provinsi,
                'kode_pos'              => $request->kode_pos,
                'no_hp'                 => $request->no_hp,
                'no_telp'               => $request->no_telp,
                'jenis_pegawai'         => $request->jenis_pegawai,
                'kedudukan_pns'         => $request->kedudukan_pns,
                'status_pegawai'        => $request->status_pegawai,
                'tmt_pns'               => $request->tmt_pns,
                'no_seri_karpeg'        => $request->no_seri_karpeg,
                'tmt_cpns'              => $request->tmt_cpns,
                'tingkat_pendidikan'    => $request->tingkat_pendidikan,
                'pendidikan_terakhir'   => $request->pendidikan_terakhir,
                'bidang'               => $request->bidang,
            ];

            DB::table('profil_pegawai')->where('user_id', $request->user_id)->update($editProfilPegawai);

            $updateDP = [
                'nip'                   => $request->nip,
                'tempat_lahir'          => $request->tempat_lahir,
                'tanggal_lahir'         => $request->tanggal_lahir,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'no_hp'                 => $request->no_hp,
                'jenis_pegawai'         => $request->jenis_pegawai,
                'kedudukan_pns'         => $request->kedudukan_pns,
                'tingkat_pendidikan'    => $request->tingkat_pendidikan,
                'pendidikan_terakhir'   => $request->pendidikan_terakhir,
                'bidang'               => $request->bidang
            ];
            DB::table('daftar_pegawai')->where('user_id', $request->user_id)->update($updateDP);

            $updateUsers = [
                'bidang'               => $request->bidang
            ];
            DB::table('users')->where('user_id', $request->user_id)->update($updateUsers);

            DB::commit();
            Toastr::success('Data profil pegawai berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data profil pegawai gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }
    /** End Edit Data Posisi & Jabatan */

    /** Tambah Data Posisi & Jabatan */
    public function posisiJabatanAdd(Request $request)
    {
        $request->validate([
            'unit_organisasi'       => 'required|string|max:255',
            'unit_organisasi_induk' => 'required|string|max:255',
            'jenis_jabatan'         => 'required|string|max:255',
            'eselon'                => 'required|string|max:255',
            'jabatan'               => 'required|string|max:255',
            'tmt'                   => 'required|string|max:255',
            'lokasi_kerja'          => 'required|string|max:255',
            'gol_ruang_awal'        => 'required|string|max:255',
            'gol_ruang_akhir'       => 'required|string|max:255',
            'tmt_golongan'          => 'required|string|max:255',
            'gaji_pokok'            => 'required|string|max:255',
            'masa_kerja_tahun'      => 'required|string|max:255',
            'masa_kerja_bulan'      => 'required|string|max:255',
            'no_spmt'               => 'required|string|max:255',
            'tanggal_spmt'          => 'required|string|max:255',
            'kppn'                  => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $addPosisiJabatan = PosisiJabatan::where('user_id', '=', $request->user_id)->first();
            if ($addPosisiJabatan === null) {

                $addPosisiJabatan = new PosisiJabatan();
                $addPosisiJabatan->user_id                = $request->user_id;
                $addPosisiJabatan->unit_organisasi        = $request->unit_organisasi;
                $addPosisiJabatan->unit_organisasi_induk  = $request->unit_organisasi_induk;
                $addPosisiJabatan->jenis_jabatan          = $request->jenis_jabatan;
                $addPosisiJabatan->eselon                 = $request->eselon;
                $addPosisiJabatan->jabatan                = $request->jabatan;
                $addPosisiJabatan->tmt                    = $request->tmt;
                $addPosisiJabatan->lokasi_kerja           = $request->lokasi_kerja;
                $addPosisiJabatan->gol_ruang_awal         = $request->gol_ruang_awal;
                $addPosisiJabatan->gol_ruang_akhir        = $request->gol_ruang_akhir;
                $addPosisiJabatan->tmt_golongan           = $request->tmt_golongan;
                $addPosisiJabatan->gaji_pokok             = $request->gaji_pokok;
                $addPosisiJabatan->masa_kerja_tahun       = $request->masa_kerja_tahun;
                $addPosisiJabatan->masa_kerja_bulan       = $request->masa_kerja_bulan;
                $addPosisiJabatan->no_spmt                = $request->no_spmt;
                $addPosisiJabatan->tanggal_spmt           = $request->tanggal_spmt;
                $addPosisiJabatan->kppn                   = $request->kppn;
                $addPosisiJabatan->save();

                DB::commit();
                Toastr::success('Data posisi & jabatan berhasil ditambah ✔', 'Success');
                return redirect()->back();
            } else {
                DB::rollback();
                Toastr::error('Data posisi & jabatan sudah tersedia ✘', 'Error');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data posisi & jabatan gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }
    /** End Tambah Data Posisi & Jabatan */

    /** Edit Data Posisi & Jabatan */
    public function posisiJabatanEdit(Request $request)
    {
        $request->validate([
            'unit_organisasi'       => 'required|string|max:255',
            'unit_organisasi_induk' => 'required|string|max:255',
            'jenis_jabatan'         => 'required|string|max:255',
            'eselon'                => 'required|string|max:255',
            'jabatan'               => 'required|string|max:255',
            'tmt'                   => 'required|string|max:255',
            'lokasi_kerja'          => 'required|string|max:255',
            'gol_ruang_awal'        => 'required|string|max:255',
            'gol_ruang_akhir'       => 'required|string|max:255',
            'tmt_golongan'          => 'required|string|max:255',
            'gaji_pokok'            => 'required|string|max:255',
            'masa_kerja_tahun'      => 'required|string|max:255',
            'masa_kerja_bulan'      => 'required|string|max:255',
            'no_spmt'               => 'required|string|max:255',
            'tanggal_spmt'          => 'required|string|max:255',
            'kppn'                  => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {

            $editPosisiJabatan = [
                'unit_organisasi'        => $request->unit_organisasi,
                'unit_organisasi_induk'  => $request->unit_organisasi_induk,
                'jenis_jabatan'          => $request->jenis_jabatan,
                'eselon'                 => $request->eselon,
                'jabatan'                => $request->jabatan,
                'tmt'                    => $request->tmt,
                'lokasi_kerja'           => $request->lokasi_kerja,
                'gol_ruang_awal'         => $request->gol_ruang_awal,
                'gol_ruang_akhir'        => $request->gol_ruang_akhir,
                'tmt_golongan'           => $request->tmt_golongan,
                'gaji_pokok'             => $request->gaji_pokok,
                'masa_kerja_tahun'       => $request->masa_kerja_tahun,
                'masa_kerja_bulan'       => $request->masa_kerja_bulan,
                'no_spmt'                => $request->no_spmt,
                'tanggal_spmt'           => $request->tanggal_spmt,
                'kppn'                   => $request->kppn,
            ];

            $editUsers = [
                'jenis_jabatan'          => $request->jenis_jabatan,
                'eselon'                 => $request->eselon
            ];

            $updateDP = [
                'jabatan'           => $request->jabatan,
                'gol_ruang_awal'    => $request->gol_ruang_awal,
                'gol_ruang_akhir'   => $request->gol_ruang_akhir
            ];

            DB::table('daftar_pegawai')->where('user_id', $request->user_id)->update($updateDP);
            DB::table('posisi_jabatan')->where('user_id', $request->user_id)->update($editPosisiJabatan);
            DB::table('users')->where('user_id', $request->user_id)->update($editUsers);

            DB::commit();
            Toastr::success('Data posisi & jabatan berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data posisi & jabatan gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }
    /** End Edit Data Posisi & Jabatan */

    public function getRiwayatAktivitas(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'user_name',
            2 => 'email',
            3 => 'status',
            4 => 'role_name',
            5 => 'modify_user',
            6 => 'date_time',
        );

        $totalData = userActivityLog::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;

        if (empty($search)) {
            $activityLog = userActivityLog::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $activityLog =  userActivityLog::where('user_name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = userActivityLog::where('user_name', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($activityLog)) {
            foreach ($activityLog as $key => $item) {
                $nestedData['id'] = $counter++;
                $nestedData['user_name'] = $item->user_name;
                $nestedData['email'] = $item->email;
                $nestedData['status'] = $item->status;
                $nestedData['role_name'] = $item->role_name;
                $nestedData['modify_user'] = $item->modify_user;
                $nestedData['date_time'] = $item->date_time;
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

    public function getAktivitasPengguna(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'nip',
            3 => 'no_dokumen',
            4 => 'description',
            5 => 'date_time',
        );

        $totalData = activityLog::count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');
        $counter = $start + 1;

        if (empty($search)) {
            $activityLog = activityLog::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $activityLog =  activityLog::where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = activityLog::where('name', 'like', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($activityLog)) {
            foreach ($activityLog as $key => $item) {
                $nestedData['id'] = $counter++;
                $nestedData['name'] = $item->name;
                $nestedData['nip'] = $item->nip;
                $nestedData['no_dokumen'] = $item->no_dokumen;
                $nestedData['description'] = $item->description;
                $nestedData['date_time'] = $item->date_time;
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
    
    public function getPegawaiData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nip',
            2 => 'name',
            3 => 'jabatan',
            4 => 'pendidikan_terakhir',
            5 => 'no_hp',
            6 => 'bidang',
            7 => 'kedudukan_pns',
            8 => 'user_id'
        );

        $result_pegawai = DB::table('daftar_pegawai')
            ->where(function ($query) {
                $query->where('role_name', 'Staff')
                    ->orWhere('role_name', 'Kepala Bidang');
            })
            ->where(function ($query) {
                $query->where('kedudukan_pns', 'Aktif')
                    ->orWhereNull('kedudukan_pns');
            })
            ->get();
        $totalData = $result_pegawai->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        if (empty($search)) {
            $data_pegawai =  DB::table('daftar_pegawai')
                ->where(function ($query) {
                    $query->where('role_name', 'Staff')
                        ->orWhere('role_name', 'Kepala Bidang');
                })
                ->where(function ($query) {
                    $query->where('kedudukan_pns', 'Aktif')
                        ->orWhereNull('kedudukan_pns');
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $data_pegawai =  DB::table('daftar_pegawai')
                ->where(function ($query) {
                    $query->where('role_name', 'Staff')
                        ->orWhere('role_name', 'Kepala Bidang');
                })
                ->where(function ($query) {
                    $query->where('kedudukan_pns', 'Aktif')
                        ->orWhereNull('kedudukan_pns');
                })
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  DB::table('daftar_pegawai')
                ->where(function ($query) {
                    $query->where('role_name', 'Staff')
                        ->orWhere('role_name', 'Kepala Bidang');
                })
                ->where(function ($query) {
                    $query->where('kedudukan_pns', 'Aktif')
                        ->orWhereNull('kedudukan_pns');
                })

                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->count();
        }

        $data_arr = [];
        foreach ($data_pegawai as $key => $result_pegawai) {
            $data_arr [] = [
                "id"                    => '<span class="id" data-id="' . $result_pegawai->id . '">' . ($start + ($key + 1)) . '</span>',
                "nip"                   => '<span class="nip">' . $result_pegawai->nip . '</span>',
                "name"                  => '<a href="' . url('staff/profile/' . $result_pegawai->user_id) . '">' . $result_pegawai->name . '</a>',
                "jabatan"               => '<span class="jabatan">' . $result_pegawai->jabatan . '</span>',
                "pendidikan_terakhir"   => '<span class="pendidikan_terakhir">' . $result_pegawai->pendidikan_terakhir . '</span>',
                "no_hp"                 => '<a href="https://api.whatsapp.com/send?phone=62' . $result_pegawai->no_hp . '" target="_blank"><span class="no_hp">' . $result_pegawai->no_hp . '</span></a>',
                "bidang"               => '<span class="bidang">' . $result_pegawai->bidang . '</span>',
                "kedudukan_pns"         => '<span class="kedudukan_pns">' . $result_pegawai->kedudukan_pns . '</span>',
                "user_id"               => '<a href="' . url('staff/profile/' . $result_pegawai->user_id) . '" class="avatar"><img alt="" src="' . asset('assets/images/' . $result_pegawai->avatar) . '"></a>',
            ];
        }

        $response = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data_arr
        );

        return response()->json($response);
    }

    public function getPegawaiRuanganData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nip',
            2 => 'name',
            3 => 'gol_ruang_awal',
            4 => 'gol_ruang_akhir',
            5 => 'bidang',
            6 => 'jenis_pegawai',
            7 => 'user_id'
        );

        $result_user = auth()->user();
        $result_bidang = $result_user->bidang;

        $result_pegawai =  DB::table('daftar_pegawai')
            ->where('role_name', 'User')
            ->where('bidang', $result_bidang);
        $totalData = $result_pegawai->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        if (empty($search)) {
            $result_bidang =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('bidang', $result_bidang)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $result_bidang =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('bidang', $result_bidang)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('bidang', $result_bidang)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->count();
        }

        $data_arr = [];
        foreach ($result_bidang as $key => $result_ruang) {
            $data_arr [] = [
                "id"                => '<span class="id" data-id="' . $result_ruang->id . '">' . ($start + ($key + 1)) . '</span>',
                "nip"               => '<span class="nip">' . $result_ruang->nip . '</span>',
                "name"              => '<a href="' . url('staff/profile/' . $result_ruang->user_id) . '">' . $result_ruang->name . '</a>',
                "gol_ruang_awal"    => '<span class="gol_ruang_awal">' . $result_ruang->gol_ruang_awal . '</span>',
                "gol_ruang_akhir"   => '<span class="gol_ruang_akhir">' . $result_ruang->gol_ruang_akhir . '</span>',
                "bidang"           => '<span class="bidang">' . $result_ruang->bidang . '</span>',
                "jenis_pegawai"     => '<span class="jenis_pegawai">' . $result_ruang->jenis_pegawai . '</span>',
                "user_id"           => '<a href="' . url('staff/profile/' . $result_ruang->user_id) . '" class="avatar"><img alt="" src="' . asset('assets/images/' . $result_ruang->avatar) . '"></a>',
            ];
        }

        $response = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data_arr
        );

        return response()->json($response);
    }

    public function getPegawaiPensiunData(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'nip',
            2 => 'name',
            3 => 'jabatan',
            4 => 'pendidikan_terakhir',
            5 => 'no_hp',
            6 => 'bidang',
            7 => 'kedudukan_pns',
            8 => 'user_id'
        );

        $result_pegawai = DB::table('daftar_pegawai')
            ->where('role_name', 'User')
            ->where('kedudukan_pns', 'Pensiun');
        $totalData = $result_pegawai->count();

        $totalFiltered = $totalData;

        $limit = $request->length;
        $start = $request->start;
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $search = $request->input('search.value');

        if (empty($search)) {
            $data_pegawai =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('kedudukan_pns', 'Pensiun')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $data_pegawai =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('kedudukan_pns', 'Pensiun')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  DB::table('daftar_pegawai')
                ->where('role_name', 'User')
                ->where('kedudukan_pns', 'Pensiun')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nip', 'like', "%{$search}%");
                })
                ->count();
        }

        $data_arr = [];
        foreach ($data_pegawai as $key => $result_pegawai) {
            $data_arr [] = [
                "id"                    => '<span class="id" data-id="' . $result_pegawai->id . '">' . ($start + ($key + 1)) . '</span>',
                "nip"                   => '<span class="nip">' . $result_pegawai->nip . '</span>',
                "name"                  => '<a href="' . url('staff/profile/' . $result_pegawai->user_id) . '">' . $result_pegawai->name . '</a>',
                "jabatan"               => '<span class="jabatan">' . $result_pegawai->jabatan . '</span>',
                "pendidikan_terakhir"   => '<span class="pendidikan_terakhir">' . $result_pegawai->pendidikan_terakhir . '</span>',
                "no_hp"                 => '<a href="https://api.whatsapp.com/send?phone=62' . $result_pegawai->no_hp . '" target="_blank"><span class="no_hp">' . $result_pegawai->no_hp . '</span></a>',
                "bidang"               => '<span class="bidang">' . $result_pegawai->bidang . '</span>',
                "kedudukan_pns"         => '<span class="kedudukan_pns">' . $result_pegawai->kedudukan_pns . '</span>',
                "user_id"               => '<a href="' . url('staff/profile/' . $result_pegawai->user_id) . '" class="avatar"><img alt="" src="' . asset('assets/images/' . $result_pegawai->avatar) . '"></a>',
            ];
        }

        $response = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data_arr
        );

        return response()->json($response);
    }
}