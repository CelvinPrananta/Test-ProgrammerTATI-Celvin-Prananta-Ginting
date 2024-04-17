<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use DB;

class HelloWorldController extends Controller
{
    public function indexHelloWord1(Request $request)
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
        return view('tampilan-helloworld.helloworld-1', compact('result_tema', 'unreadNotifications', 'readNotifications', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function hasil_helloworld(Request $request)
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
            
        $kelipatan_hello_world1 = $request->input('kelipatan_hello_world');

        $matriks = [
            'kelipatan 1' => '1',
            'kelipatan 2' => '1 2',
            'kelipatan 3' => '1 2 3',
            'kelipatan 4' => '1 2 3 hello',
            'kelipatan 5' => '1 2 3 hello world',
            'kelipatan 6' => '1 2 3 hello world 6',
        ];

        if ($hasil_kelipatan = isset($matriks[$kelipatan_hello_world1]) ? $matriks[$kelipatan_hello_world1] : 'Pilihan tidak sah, lakukan pilihan kembali.') {
            return view('tampilan-helloworld.helloworld-1', compact('result_tema', 'unreadNotifications', 'readNotifications', 'semua_notifikasi', 'belum_dibaca', 'dibaca', 'hasil_kelipatan'));
        }
    }

    public function indexHelloWord2(Request $request)
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
        return view('tampilan-helloworld.helloworld-2', compact('result_tema', 'unreadNotifications', 'readNotifications', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function indexHelloWord3 ()
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
        return view('tampilan-helloworld.helloworld-3', compact('result_tema', 'unreadNotifications', 'readNotifications', 'semua_notifikasi', 'belum_dibaca', 'dibaca'));
    }

    public function hasil_helloworld3(Request $request)
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

        $kelipatan_bilangan = $request->input('kelipatan_bilangan');

        $result_bilangan = $this->helloworld($kelipatan_bilangan);

        return view('tampilan-helloworld.helloworld-3', [
            'result_bilangan' => $result_bilangan,
            'result_tema' => $result_tema,
            'unreadNotifications' => $unreadNotifications,
            'readNotifications' => $readNotifications,
            'semua_notifikasi' => $semua_notifikasi,
            'belum_dibaca' => $belum_dibaca,
            'dibaca' => $dibaca,
        ]);
    }

    private function helloworld($kelipatan_bilangan)
    {
        $hasil_bilangan = '';

        for ($i = 1; $i <= $kelipatan_bilangan; $i++) {
            if ($i % 4 == 0 && $i % 5 == 0) {
                $hasil_bilangan .= 'helloworld ';
            } elseif ($i % 4 == 0) {
                $hasil_bilangan .= 'hello ';
            } elseif ($i % 5 == 0) {
                $hasil_bilangan .= 'world ';
            } else {
                $hasil_bilangan .= $i . ' ';
            }
        }

        return $hasil_bilangan;
    }
}