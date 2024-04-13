<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\User;
use App\Models\CompanySettings;
use App\Models\Notification;
use App\Charts\GrafikChart;
use App\Models\bidang;
use App\Models\ModeAplikasi;
use App\Notifications\UlangTahunNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // main dashboard
    public function index(GrafikChart $chart)
    {
        // Mendapatkan peran pengguna saat ini
        $user = auth()->user();

        // Memeriksa peran pengguna dan mengarahkannya ke halaman yang sesuai
        if ($user->role_name === 'Kepala Dinas')
        {
            $dataPegawai = User::where('role_name', 'Staff')->count();

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
            
            return view('dashboard.Halaman-kepala-dinas', [
                'chart' => $chart->build(),
                'grafikAgama' => $chart->grafikAgama(),
                'grafikJenisKelamin' => $chart->grafikJenisKelamin(),
                'grafikPangkat' => $chart->grafikPangkat(),
                'dataPegawai' => $dataPegawai,
                'unreadNotifications' => $unreadNotifications,
                'readNotifications' => $readNotifications,
                'semua_notifikasi' => $semua_notifikasi,
                'belum_dibaca' => $belum_dibaca,
                'dibaca' => $dibaca,
                'result_tema' => $result_tema
            ]);
            
        }

        elseif ($user->role_name === 'Kepala Bidang')
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
            
            return view('dashboard.Halaman-kepala-bidang', [
                'chart' => $chart->build(),
                'grafikAgama' => $chart->grafikAgama(),
                'grafikJenisKelamin' => $chart->grafikJenisKelamin(),
                'grafikPangkat' => $chart->grafikPangkat(),
                'unreadNotifications' => $unreadNotifications,
                'readNotifications' => $readNotifications,
                'semua_notifikasi' => $semua_notifikasi,
                'belum_dibaca' => $belum_dibaca,
                'dibaca' => $dibaca,
                'result_tema' => $result_tema
            ]);
        }

        elseif ($user->role_name === 'Staff')
        {
            $tampilanPerusahaan = CompanySettings::where('id',1)->first();

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
            
            return view('dashboard.Halaman-staff',compact('tampilanPerusahaan', 'unreadNotifications',
                'readNotifications', 'result_tema', 'semua_notifikasi', 'belum_dibaca', 'dibaca' ));
        }
    }

    public function bacaNotifikasi($id){
        if($id)
        {
            auth()->user()->notifications->where('id',$id)->markAsRead();
            Toastr::success('Notifikasi Telah Dibaca ✔','Success');
        }
        return back();
    }

    public function bacasemuaNotifikasi()
    {
        $user = auth()->user();
        $user->notifications->markAsRead();
        Toastr::success('Semua Notifikasi Telah Dibaca ✔','Success');
        return redirect()->back();
    }

    public function ulangtahun()
    {
        if (auth()->user())
        {
            $user = User::first();
            $notification = auth()->user()->notifications->where('data.user_id', $user->id)->first();
        
                if (!$notification) {
                    $notification = new UlangTahunNotification($user);
                    $notification->data['user_id'] = $user->id;
                    auth()->user()->notify($notification);
                }
        }
        return back();
    }

    public function masaberlakuSIP()
    {
        if (auth()->user())
        {
            $user = User::first();
            $notification = auth()->user()->notifications->where('data.user_id', $user->id)->first();
        
                if (!$notification) {
                    $notification = new MasaBerlakuSIPNotification($user);
                    $notification->data['user_id'] = $user->id;
                    auth()->user()->notify($notification);
                }
        }
        return back();
    }

    public function masaberlakuSPKDokter()
    {
        if (auth()->user())
        {
            $user = User::first();
            $notification = auth()->user()->notifications->where('data.user_id', $user->id)->first();
        
                if (!$notification) {
                    $notification = new MasaBerlakuSPKDokterNotification($user);
                    $notification->data['user_id'] = $user->id;
                    auth()->user()->notify($notification);
                }
        }
        return back();
    }

    public function masaberlakuSPKPerawat()
    {
        if (auth()->user())
        {
            $user = User::first();
            $notification = auth()->user()->notifications->where('data.user_id', $user->id)->first();
        
                if (!$notification) {
                    $notification = new MasaBerlakuSPKPerawatNotification($user);
                    $notification->data['user_id'] = $user->id;
                    auth()->user()->notify($notification);
                }
        }
        return back();
    }

    public function masaberlakuSPKNakesLain()
    {
        if (auth()->user())
        {
            $user = User::first();
            $notification = auth()->user()->notifications->where('data.user_id', $user->id)->first();
        
                if (!$notification) {
                    $notification = new MasaBerlakuSPKNakesLainNotification($user);
                    $notification->data['user_id'] = $user->id;
                    auth()->user()->notify($notification);
                }
        }
        return back();
    }

    public function updateTemaAplikasi(Request $request, $id)
    {
        DB::beginTransaction();
        try {
        $user = ModeAplikasi::findOrFail($id);

        $tema_aplikasi = $request->input('tema_aplikasi');
        if ($tema_aplikasi == 'Terang') {
            $user->tema_aplikasi = 'Terang';
            $user->warna_sistem = null;
            $user->warna_sistem_tulisan = null;
            $user->warna_mode = null;
            $user->tabel_warna = null;
            $user->tabel_tulisan_tersembunyi = null;
            $user->warna_dropdown_menu = null;
            $user->ikon_plugin = null;
            $user->bayangan_kotak_header = null;
            $user->warna_mode_2 = null;

        } elseif ($tema_aplikasi == 'Gelap') {
            $user->tema_aplikasi = 'Gelap';
            $user->warna_sistem = '#171527';
            $user->warna_sistem_tulisan = 'white';
            $user->warna_mode = '#292D3E';
            $user->tabel_warna = 'rgba(0,0,0,.05)';
            $user->tabel_tulisan_tersembunyi = '#a3a3a3';
            $user->warna_dropdown_menu = 'rgb(31 28 54 / 1)';
            $user->ikon_plugin = 'rgba(244, 59, 72, 0.6)';
            $user->bayangan_kotak_header = '0 0.4px 5px rgb(255 255 255)';
            $user->warna_mode_2 = '#2b2e3c';
        }
        $user->save();

        $user2 = User::findOrFail($id);

        $tema_aplikasi = $request->input('tema_aplikasi');
        if ($tema_aplikasi == 'Terang') {
            $user2->tema_aplikasi = 'Terang';

        } elseif ($tema_aplikasi == 'Gelap') {
            $user2->tema_aplikasi = 'Gelap';
        }
        $user2->save();

        DB::commit();
        Toastr::success('Tema aplikasi berhasil diperbarui ✔', 'Success');
        return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Tema aplikasi gagal diperbarui ✘', 'Error');
            return redirect()->back();
        }
    }
}