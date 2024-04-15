<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ set_active(['home']) }}">
                    <a href="{{ route('home') }}" class="{{ set_active(['home']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                @if (Auth::user()->role_name == 'Kepala Dinas')
                    <li class="{{set_active(['manajemen/pengguna','riwayat/aktivitas','riwayat/aktivitas/otentikasi'])}} submenu">
                        <a href="#" class="{{ set_active(['manajemen/pengguna','riwayat/aktivitas','riwayat/aktivitas/otentikasi']) ? 'noti-dot' : '' }}">
                            <i class="la la-server"></i>
                            <span> Manajemen Sistem</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['manajemen/pengguna','manajemen/pengguna'])}}" href="{{ route('manajemen-pengguna') }}"> <span>Daftar Pengguna</span></a></li>
                        <li><a class="{{set_active(['riwayat/aktivitas','riwayat/aktivitas'])}}" href="{{ route('riwayat-aktivitas') }}"> <span>Riwayat Aktivitas</span></a></li>
                        <li><a class="{{set_active(['riwayat/aktivitas/otentikasi','riwayat/aktivitas/otentikasi'])}}" href="{{ route('riwayat-aktivitas-otentikasi') }}"> <span>Aktivitas Pengguna</span></a></li>
                        </ul>
                    </li>
                    <li class="menu-title"> <span>Data Referensi </span>
                    <li class="{{ request()->routeIs('referensi-agama') ? 'active' : '' }}">
                        <a href="{{ route('referensi-agama') }}"
                            class="{{ request()->routeIs('referensi-agama') ? 'noti-dot' : '' }}">
                            <i class="las la-star-and-crescent"></i>
                            <span>Agama</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('referensi-status') ? 'active' : '' }}">
                        <a href="{{ route('referensi-status') }}" class="{{ request()->routeIs('referensi-status') ? 'noti-dot' : '' }}">
                            <i class="la la-map"></i>
                            <span>Status</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('referensi-kedudukan') ? 'active' : '' }}">
                        <a href="{{ route('referensi-kedudukan') }}" class="{{ request()->routeIs('referensi-kedudukan') ? 'noti-dot' : '' }}">
                            <i class="la la-trello"></i>
                            <span>Kedudukan</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('referensi-pangkat') ? 'active' : '' }}">
                        <a href="{{ route('referensi-pangkat') }}" class="{{ request()->routeIs('referensi-pangkat') ? 'noti-dot' : '' }}">
                            <i class="la la-sort-amount-up"></i>
                            <span>Pangkat</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('referensi-pendidikan') ? 'active' : '' }}">
                        <a href="{{ route('referensi-pendidikan') }}"
                            class="{{ request()->routeIs('referensi-pendidikan') ? 'noti-dot' : '' }}">
                            <i class="la la-mortar-board"></i>
                            <span>Pendidikan</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('referensi-bidang') ? 'active' : '' }}">
                        <a href="{{ route('referensi-bidang') }}" class="{{ request()->routeIs('referensi-bidang') ? 'noti-dot' : '' }}">
                            <i class="las la-warehouse"></i>
                            <span>Bidang</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Manajemen Pegawai</span> </li>
                    <li
                        class="{{ request()->routeIs('daftar/pegawai/list','daftar/pegawai/card') || request()->routeIs('daftar/pegawai/card') ? 'active' : '' }}">
                        <a href="{{ route('daftar/pegawai/list', 'daftar/pegawai/card') }}"
                            class="{{ request()->routeIs('daftar/pegawai/list', 'daftar/pegawai/card') || request()->routeIs('daftar/pegawai/card') ? 'noti-dot' : '' }}">
                            <i class="la la-group"></i>
                            <span>Daftar Pegawai</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Catatan Kepala Dinas </span> </li>
                    <li class="{{ request()->routeIs('catatan-harian-kepala-dinas') ? 'active' : '' }}">
                        <a href="{{ route('catatan-harian-kepala-dinas') }}" class="{{ request()->routeIs('catatan-harian-kepala-dinas') ? 'noti-dot' : '' }}">
                            <i class="las la-newspaper"></i>
                            <span>Catatan Harian</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('catatan-harian-pribadi-kepala-dinas') ? 'active' : '' }}">
                        <a href="{{ route('catatan-harian-pribadi-kepala-dinas') }}" class="{{ request()->routeIs('catatan-harian-pribadi-kepala-dinas') ? 'noti-dot' : '' }}">
                            <i class="las la-newspaper"></i>
                            <span>Catatan Harian Pribadi</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Predikat Kinerja</span></li>
                    <li class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-predikat-kinerja') }}" class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'noti-dot' : '' }}">
                            <i class="la la-sliders"></i>
                            <span>Predikat Kinerja</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Hello World</span></li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-1') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-1') }}" class="{{ request()->routeIs('tampilan-hello-world-1') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 1</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-2') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-2') }}" class="{{ request()->routeIs('tampilan-hello-world-2') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 2</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Pengaturan Profil</span> </li>
                    <li class="{{ set_active(['kepala-dinas/profile']) }}">
                        <a href="{{ route('kepala-dinas-profile') }}"
                            class="{{ set_active(['kepala-dinas/profile']) ? 'noti-dot' : '' }}">
                            <i class="la la-user"></i>
                            <span> Profil</span>
                        </a>
                    </li>
                    <li class="{{ set_active(['kepala-dinas/kata-sandi']) }}">
                        <a href="{{ route('kepala-dinas-kata-sandi') }}"
                            class="{{ set_active(['kepala-dinas/kata-sandi']) ? 'noti-dot' : '' }}">
                            <i class="la la-key"></i>
                            <span> Ubah Kata Sandi</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role_name == 'Kepala Bidang')
                    <li class="menu-title"> <span>Catatan Kepala Bidang</span></li>
                    <li class="{{ request()->routeIs('catatan-harian-kepala-bidang') ? 'active' : '' }}">
                        <a href="{{ route('catatan-harian-kepala-bidang') }}" class="{{ request()->routeIs('catatan-harian-kepala-bidang') ? 'noti-dot' : '' }}">
                            <i class="las la-newspaper"></i>
                            <span>Catatan Harian</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('catatan-harian-verifikasi-kepala-bidang') ? 'active' : '' }}">
                        <a href="{{ route('catatan-harian-verifikasi-kepala-bidang') }}" class="{{ request()->routeIs('catatan-harian-verifikasi-kepala-bidang') ? 'noti-dot' : '' }}">
                            <i class="las la-newspaper"></i>
                            <span>Verifikasi Catatan</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Predikat Kinerja</span></li>
                    <li class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-predikat-kinerja') }}" class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'noti-dot' : '' }}">
                            <i class="la la-sliders"></i>
                            <span>Predikat Kinerja</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Hello World</span></li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-1') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-1') }}" class="{{ request()->routeIs('tampilan-hello-world-1') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 1</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-2') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-2') }}" class="{{ request()->routeIs('tampilan-hello-world-2') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 2</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Pengaturan Profil</span> </li>
                    <li class="{{ set_active(['kepala-bidang/profile']) }}">
                        <a href="{{ route('kepala-bidang-profile') }}"
                            class="{{ set_active(['kepala-bidang/profile']) ? 'noti-dot' : '' }}">
                            <i class="la la-user"></i>
                            <span> Profil</span>
                        </a>
                    </li>
                    <li class="{{ set_active(['kepala-bidang/kata-sandi']) }}">
                        <a href="{{ route('kepala-bidang-kata-sandi') }}"
                            class="{{ set_active(['kepala-bidang/kata-sandi']) ? 'noti-dot' : '' }}">
                            <i class="la la-key"></i>
                            <span> Ubah Kata Sandi</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role_name == 'Staff')
                    <li class="menu-title"> <span>Catatan Staff</span></li>
                    <li class="{{ request()->routeIs('catatan-harian-staff') ? 'active' : '' }}">
                        <a href="{{ route('catatan-harian-staff') }}" class="{{ request()->routeIs('catatan-harian-staff') ? 'noti-dot' : '' }}">
                            <i class="las la-newspaper"></i>
                            <span>Catatan Harian</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Predikat Kinerja</span></li>
                    <li class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-predikat-kinerja') }}" class="{{ request()->routeIs('tampilan-predikat-kinerja') ? 'noti-dot' : '' }}">
                            <i class="la la-sliders"></i>
                            <span>Predikat Kinerja</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Tampilan Hello World</span></li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-1') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-1') }}" class="{{ request()->routeIs('tampilan-hello-world-1') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 1</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('tampilan-hello-world-2') ? 'active' : '' }}">
                        <a href="{{ route('tampilan-hello-world-2') }}" class="{{ request()->routeIs('tampilan-hello-world-2') ? 'noti-dot' : '' }}">
                            <i class="la la-slack"></i>
                            <span>Hello World 2</span>
                        </a>
                    </li>
                    <li class="menu-title"> <span>Pengaturan Profil</span> </li>
                    <li class="{{ set_active(['staff/profile']) }}">
                        <a href="{{ route('staff-profile') }}"
                            class="{{ set_active(['staff/profile']) ? 'noti-dot' : '' }}">
                            <i class="la la-user"></i>
                            <span> Profil</span>
                        </a>
                    </li>
                    <li class="{{ set_active(['staff/kata-sandi']) }}">
                        <a href="{{ route('staff-kata-sandi') }}"
                            class="{{ set_active(['staff/kata-sandi']) ? 'noti-dot' : '' }}">
                            <i class="la la-key"></i>
                            <span> Ubah Kata Sandi</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->