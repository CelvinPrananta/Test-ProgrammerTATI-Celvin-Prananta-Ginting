<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\LogHarian;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use DB;

class CatatanHarian extends Controller
{
    /** Tampilan Catatan Harian Staff */
    public function tampilanCatatanStaff()
    {
        $user_id = auth()->user()->user_id;
        $data_catatan_harian = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', $user_id)
            ->get();

        $data_profilcatatan = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
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

        return view('staff.catatan-harian', compact(
            'data_catatan_harian',
            'data_profilcatatan',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Tampilan Catatan Harian Staff */

    /** Tampilan Catatan Harian Kepala Bidang */
    public function tampilanCatatanKepalaBidang()
    {
        $user_id = auth()->user()->user_id;
        $data_pribadi_kepalabidang = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', $user_id)
            ->get();

        $data_profilkepalabidang_pribadi = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
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

        return view('kepala-bidang.catatan-harian', compact('data_pribadi_kepalabidang', 'data_profilkepalabidang_pribadi', 'unreadNotifications',
            'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** /Tampilan Catatan Harian Kepala Bidang */

    /** Tampilan Catatan Harian Verifikasi Kepala Bidang */
    public function tampilanCatatanVerifikasiKepalaBidang()
    {
        $user = auth()->user();
        $bidang = $user->bidang;
        $data_staff = User::where('role_name', 'Staff')
            ->join('catatan_harian', 'users.user_id', 'catatan_harian.user_id')
            ->where('bidang', $bidang)
            ->get();

        $user_id = auth()->user()->user_id;
        $data_pribadi_kepalabidang = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', $user_id)
            ->get();

        $data_profilkepalabidang_pribadi = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
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

        return view('kepala-bidang.verifikasi-harian', compact('data_staff', 'unreadNotifications', 'readNotifications', 'result_tema',
            'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }
    /** /Tampilan Catatan Harian Verifikasi Kepala Bidang */

    /** Tampilan Catatan Harian Kepala Dinas */
    public function tampilanCatatanKepalaDinas()
    {
        $data_staff = DB::table('catatan_harian')
            ->join('daftar_pegawai', 'catatan_harian.user_id', '=', 'daftar_pegawai.user_id')
            ->select(
                'catatan_harian.id',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan',
                'catatan_harian.persetujuan_kepala_dinas',
                'catatan_harian.persetujuan_kepala_bidang',
            )
            ->where('daftar_pegawai.role_name', 'Staff')
            ->orWhere('role_name', 'Kepala Bidang')
            ->get();


        $userList = DB::table('daftar_pegawai')
            ->select('daftar_pegawai.*')
            ->where('role_name', 'Staff')
            ->orWhere('role_name', 'Kepala Bidang')
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

        return view('kepala-dinas.catatan-harian', compact(
            'data_staff',
            'userList',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Tampilan Catatan Harian Kepala Dinas */

    /** Tampilan Catatan Harian Kepala Dinas Pribadi */
    public function tampilanCatatanPribadiKepalaDinas()
    {
        $user_id = auth()->user()->user_id;
        $data_pribadi_kepala_dinas = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', $user_id)
            ->get();

        $data_profilkepaladinas_pribadi = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
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

        return view('kepala-dinas.catatan-harian-pribadi', compact(
            'data_pribadi_kepala_dinas',
            'data_profilkepaladinas_pribadi',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Tampilan Catatan Harian Kepala Dinas Pribadi */

    /** Tambah Data Catatan Harian */
    public function tambahDataCatatanHarian(Request $request)
    {
        $request->validate([
            'user_id'                               => 'required|string|max:255',
            'name'                                  => 'required|string|max:255',
            'nip'                                   => 'required|string|max:255',
            'catatan_kegiatan'                      => 'required|string|max:255',
            'tanggal_kegiatan'                      => 'required|string|max:255',
            'status_pengajuan'                      => 'required|string|max:255',
            'persetujuan_kepala_dinas'              => 'required|string|max:255',
            'persetujuan_kepala_bidang'          => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $layananCutiPegawai = new LogHarian;
            $layananCutiPegawai->user_id                                = $request->user_id;
            $layananCutiPegawai->name                                   = $request->name;
            $layananCutiPegawai->nip                                    = $request->nip;
            $layananCutiPegawai->catatan_kegiatan                       = $request->catatan_kegiatan;
            $layananCutiPegawai->tanggal_kegiatan                       = $request->tanggal_kegiatan;
            $layananCutiPegawai->status_pengajuan                       = $request->status_pengajuan;
            $layananCutiPegawai->persetujuan_kepala_dinas               = $request->persetujuan_kepala_dinas;
            $layananCutiPegawai->persetujuan_kepala_bidang              = $request->persetujuan_kepala_bidang;
            $layananCutiPegawai->save();

            DB::commit();
            Toastr::success('Data catatan harian berhasil ditambah ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data catatan harian gagal ditambah ✘', 'Error');
            return redirect()->back();
        }
    }
    /** /Tambah Data Catatan Harian */

    /** Edit Data Catatan Harian */
    public function editDataCatatanHarian(Request $request)
    {
        DB::beginTransaction();
        try {

            $update = [
                'id'                    => $request->id,
                'catatan_kegiatan'      => $request->catatan_kegiatan,
                'tanggal_kegiatan'      => $request->tanggal_kegiatan,
            ];

            LogHarian::where('id', $request->id)->update($update);

            DB::commit();
            Toastr::success('Data catatan harian berhasil diperbaharui ✔', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Data catatan harian gagal diperbaharui ✘', 'Error');
            return redirect()->back();
        }
    }
    /** /Edit Data Catatan Harian */

    /** Pencarian Catatan Harian Staff */
    public function pencarianCatatanHarianStaff(Request $request)
    {
        $user_id = auth()->user()->user_id;
        $name = $request->input('name');
        $catatan_kegiatan = $request->input('catatan_kegiatan');
        $tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $status_pengajuan = $request->input('status_pengajuan');

        $data_catatan_harian = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', '=', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
            ->get();


        $data_profilcatatan = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
            ->get();

        $pencarianDataCatatan = DB::table('catatan_harian')
            ->join('users', 'users.user_id', '=', 'catatan_harian.user_id')
            ->where('users.user_id', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
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

        return view('staff.catatan-harian', compact(
            'pencarianDataCatatan',
            'data_catatan_harian',
            'data_profilcatatan',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Pencarian Catatan Harian Staff */

    /** Pencarian Catatan Harian Kepala Bidang */
    public function pencarianCatatanHarianKepalaBidang(Request $request)
    {
        $user_id = auth()->user()->user_id;
        $name = $request->input('name');
        $catatan_kegiatan = $request->input('catatan_kegiatan');
        $tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $status_pengajuan = $request->input('status_pengajuan');

        $data_pribadi_kepalabidang = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', '=', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
            ->get();


        $data_profilkepalabidang_pribadi = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
            ->get();

        $pencarianDataCatatan = DB::table('catatan_harian')
            ->join('users', 'users.user_id', '=', 'catatan_harian.user_id')
            ->where('users.user_id', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
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

        return view('kepala-bidang.catatan-harian', compact(
            'pencarianDataCatatan',
            'data_pribadi_kepalabidang',
            'data_profilkepalabidang_pribadi',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Pencarian Catatan Harian Kepala Bidang */

    /** Pencarian Verifikasi Catatan Harian Kepala Bidang */
    public function pencarianVerifikasiCatatanHarianKepalaBidang(Request $request)
    {
        $name = $request->input('name');
        $tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $persetujuan_kepala_bidang = $request->input('persetujuan_kepala_bidang');

        $user = auth()->user();
        $bidang = $user->bidang;
        $data_staff = User::where('role_name', 'Staff')
            ->join('catatan_harian', 'users.user_id', 'catatan_harian.user_id')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.persetujuan_kepala_bidang'
            )
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.persetujuan_kepala_bidang', 'like', '%' . $persetujuan_kepala_bidang . '%')
            ->where('bidang', $bidang)
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

        return view('kepala-bidang.verifikasi-harian', compact(
            'data_staff',
            'unreadNotifications',
            'readNotifications',
            'result_tema',
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Pencarian Verifikasi Catatan Harian Kepala Bidang */


    /** Pencarian Catatan Harian Kepala Dinas */
    public function pencarianCatatanHarianKepalaDinas(Request $request)
    {
        $name = $request->input('name');
        $tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $status_pengajuan = $request->input('status_pengajuan');
        $data_staff = DB::table('catatan_harian')
            ->join('daftar_pegawai', 'catatan_harian.user_id', '=', 'daftar_pegawai.user_id')
            ->select(
                'catatan_harian.id',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan',
                'catatan_harian.persetujuan_kepala_dinas',
                'catatan_harian.persetujuan_kepala_bidang',
            )
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
            ->where(function($query) {
                $query->where('daftar_pegawai.role_name', 'Staff')
                    ->orWhere('daftar_pegawai.role_name', 'Kepala Bidang');
            })
            ->get();

        $userList = DB::table('daftar_pegawai')->get();

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

        return view('kepala-dinas.catatan-harian', compact(
            'data_staff',
            'userList',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Pencarian Catatan Harian Kepala Dinas */

    /** Pencarian Catatan Harian Kepala Dinas Pribadi */
    public function pencarianCatatanHarianPribadiKepalaDinas(Request $request)
    {
        $user_id = auth()->user()->user_id;
        $name = $request->input('name');
        $catatan_kegiatan = $request->input('catatan_kegiatan');
        $tanggal_kegiatan = $request->input('tanggal_kegiatan');
        $status_pengajuan = $request->input('status_pengajuan');

        $data_pribadi_kepala_dinas = DB::table('catatan_harian')
            ->select(
                'catatan_harian.*',
                'catatan_harian.user_id',
                'catatan_harian.name',
                'catatan_harian.nip',
                'catatan_harian.catatan_kegiatan',
                'catatan_harian.tanggal_kegiatan',
                'catatan_harian.status_pengajuan'
            )
            ->where('catatan_harian.user_id', '=', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
            ->get();

        $data_profilkepaladinas_pribadi = DB::table('profil_pegawai')
            ->select('profil_pegawai.*', 'profil_pegawai.name', 'profil_pegawai.nip')
            ->where('profil_pegawai.user_id', $user_id)
            ->get();

        $pencarianDataCatatan = DB::table('catatan_harian')
            ->join('users', 'users.user_id', '=', 'catatan_harian.user_id')
            ->where('users.user_id', $user_id)
            ->where('catatan_harian.name', 'like', '%' . $name . '%')
            ->where('catatan_harian.catatan_kegiatan', 'like', '%' . $catatan_kegiatan . '%')
            ->where('catatan_harian.tanggal_kegiatan', 'like', '%' . $tanggal_kegiatan . '%')
            ->where('catatan_harian.status_pengajuan', 'like', '%' . $status_pengajuan . '%')
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

        return view('kepala-dinas.catatan-harian-pribadi', compact(
            'pencarianDataCatatan',
            'data_pribadi_kepala_dinas',
            'data_profilkepaladinas_pribadi',
            'unreadNotifications',
            'readNotifications',
            'result_tema', 
            'semua_notifikasi', 
            'belum_dibaca', 
            'dibaca'
        ));
    }
    /** /Pencarian Catatan Harian Kepala Dinas Pribadi */

    /** Tampilan Update Status Perhomonan */
    public function updateStatusCatatanHarian(Request $request, $id)
    {
        DB::beginTransaction();
        try {
        $resource = LogHarian::find($id);

        if ($request->has('status_pengajuan')) {
            $resource->status_pengajuan = $request->input('status_pengajuan');
        }

        if ($request->has('persetujuan_kepala_dinas')) {
            $resource->persetujuan_kepala_dinas = $request->input('persetujuan_kepala_dinas');
        }

        if ($request->has('persetujuan_kepala_bidang')) {
            $resource->persetujuan_kepala_bidang = $request->input('persetujuan_kepala_bidang');
        }
        $resource->save();

        DB::commit();
        Toastr::success('Data status persetujuan berhasil diperbaharui ✔', 'Success');
        return redirect()->back();
        } catch (\Exception $e) {
        DB::rollback();
        Toastr::success('Data status persetujuan gagal diperbaharui ✘', 'Error');
        return redirect()->back();
        }
    }
    /** /Tampilan Update Status Perhomonan */
}