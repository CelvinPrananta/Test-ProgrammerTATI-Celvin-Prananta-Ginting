@extends('layouts.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profil</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- message --}}
            {!! Toastr::message() !!}

            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="{{ URL::to('/assets/images/' . $users->avatar) }}" data-fancybox="foto-profil">
                                            <img alt="{{ $users->name }}" src="{{ URL::to('/assets/images/' . $users->avatar) }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="profile-basic pro-overview tab-pane fade show active">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="pro-edit">
                                                <a data-target="#profile_info_avatar" data-toggle="modal" class="edit-icon-avatar" href="#">
                                                    <i class="fa-solid fa-camera-retro fa-lg"></i>
                                                </a>
                                            </div>
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $users->name }}</h3>
                                                <div class="staff-id">ID Pegawai : {{ $users->user_id }}</div>
                                                <div class="small doj text-muted">Tanggal Bergabung : {{ \Carbon\Carbon::parse(Session::get('join_date'))->translatedFormat('l, j F Y || h:i A') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">E-mail</div>
                                                    <div class="text">
                                                        @if (!empty($users->email))
                                                            <a href="mailto:{{ $users->email }}">{{ $users->email }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Tanggal Lahir</div>
                                                    <div class="text">
                                                        @if (!empty($users->tgl_lahir))<a>{{ date('d F Y', strtotime($users->tgl_lahir)) }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Tempat Lahir</div>
                                                    <div class="text">
                                                        @if (!empty($users->tmpt_lahir))
                                                            <a>{{ $users->tmpt_lahir }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Alamat</div>
                                                    <div class="text">
                                                        @if (!empty($users->alamat))
                                                            <a>{{ $users->alamat }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">Jenis Kelamin</div>
                                                    <div class="text">
                                                        @if (!empty($users->jk))
                                                            <a>{{ $users->jk }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit">
                                    <a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item"><a href="#profil_pegawai" data-toggle="tab" class="nav-link active">Profil</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Profile Pegawai Tab -->
                <div id="profil_pegawai" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Profil Pegawai
                                        <a href="#" class="edit-icon" data-toggle="modal" data-target="#unggah_dokumen_ktp"><i class="fa fa-upload"></i></a></h3>
                                        <a href="#" class="edit-icon" data-toggle="modal" data-target="#profil_pegawai_modal_edit"><i class="fa fa-pencil"></i></a></h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Nama</div>
                                            @if (!empty($users->name))
                                                <div class="text">{{ $users->name }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">NIP</div>
                                            @if (!empty($users->nip))
                                                <div class="text">{{ $users->nip }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Gelar Depan</div>
                                            @if (!empty($users->gelar_depan))
                                                <div class="text">{{ $users->gelar_depan }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Gelar Belakang</div>
                                            @if (!empty($users->gelar_belakang))
                                                <div class="text">{{ $users->gelar_belakang }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Tempat Lahir</div>
                                            @if (!empty($users->tempat_lahir))
                                                <div class="text">{{ $users->tempat_lahir }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Tanggal Lahir</div>
                                            @if (!empty($users->tanggal_lahir))
                                                <div class="text">{{ date('d F Y', strtotime($users->tanggal_lahir)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tanggal_lahir }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Jenis Kelamin</div>
                                            @if (!empty($users->jenis_kelamin))
                                                <div class="text">{{ $users->jenis_kelamin }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Agama</div>
                                            @if (!empty($users->agama))
                                                <div class="text">{{ $users->agama }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">E-mail</div>
                                            @if (!empty($users->email))
                                                <a href="mailto:{{ $users->email }}" style="color:black"><div class="text">{{ $users->email }}</div></a>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Jenis Dokumen</div>
                                            @if (!empty($users->jenis_dokumen))
                                                <div class="text">{{ $users->jenis_dokumen }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Nomor Induk Kependudukan</div>
                                            @if (!empty($users->no_dokumen))
                                                <div class="text">{{ $users->no_dokumen }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Provinsi</div>
                                            @if (!empty($users->provinsi))
                                                <div class="text">{{ ucwords(strtolower($users->provinsi)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Kota/Kabupaten</div>
                                            @if (!empty($users->kota))
                                                <div class="text">{{ ucwords(strtolower($users->kota)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Kecamatan</div>
                                            @if (!empty($users->kecamatan))
                                                <div class="text">{{ ucwords(strtolower($users->kecamatan)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Desa/Kelurahan</div>
                                            @if (!empty($users->kelurahan))
                                                <div class="text">{{ ucwords(strtolower($users->kelurahan)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Kode Pos</div>
                                            @if (!empty($users->kode_pos))
                                                <div class="text">{{ $users->kode_pos }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Nomor HP</div>
                                            @if (!empty($users->no_hp))
                                                <div class="text">{{ $users->no_hp }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Nomor Telepon</div>
                                            @if (!empty($users->no_telp))
                                                <div class="text">{{ $users->no_telp }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Jenis Pegawai</div>
                                            @if (!empty($users->jenis_pegawai))
                                                <div class="text">{{ $users->jenis_pegawai }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Kedudukan PNS</div>
                                            @if (!empty($users->kedudukan_pns))
                                                <div class="text">{{ $users->kedudukan_pns }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Status Pegawai</div>
                                            @if (!empty($users->status_pegawai))
                                                <div class="text">{{ $users->status_pegawai }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">TMT PNS</div>
                                            @if (!empty($users->tmt_pns))
                                                <div class="text">{{ date('d F Y', strtotime($users->tmt_pns)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tmt_pns }}</div>
                                        </li>
                                        <li>
                                            <div class="title">No. Seri Kartu Pegawai</div>
                                            @if (!empty($users->no_seri_karpeg))
                                                <div class="text">{{ $users->no_seri_karpeg }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">TMT CPNS</div>
                                            @if (!empty($users->tmt_cpns))
                                                <div class="text">{{ date('d F Y', strtotime($users->tmt_cpns)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tmt_cpns }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Tingkat Pendidikan</div>
                                            @if (!empty($users->tingkat_pendidikan))
                                                <div class="text">{{ $users->tingkat_pendidikan }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Pendidikan Terakhir</div>
                                            @if (!empty($users->pendidikan_terakhir))
                                                <div class="text">{{ ucwords(strtolower($users->pendidikan_terakhir)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Bidang</div>
                                            @if (!empty($users->bidang))
                                                <div class="text">{{ $users->bidang }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Dokumen KTP</div>
                                            <a href="{{ asset('assets/DokumenKTP/' . $users->dokumen_ktp) }}" target="_blank">
                                                @if (pathinfo($users->dokumen_ktp, PATHINFO_EXTENSION) == 'pdf')
                                                    <i class="fa fa-file-pdf-o fa-2x" style="color: #1db9aa;" aria-hidden="true"></i>
                                                @else
                                                    <div class="text">N/A</div>
                                                @endif
                                                    <div hidden class="text">{{ $users->dokumen_ktp }}</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">Posisi & Jabatan Pegawai<a href="#" class="edit-icon" data-toggle="modal" data-target="#posisi_jabatan_modal_edit"><i class="fa fa-pencil"></i></a></h3>
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Unit Organisasi</div>
                                            @if (!empty($users->unit_organisasi))
                                                <div class="text">{{ $users->unit_organisasi }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Unit Organisasi Induk</div>
                                            @if (!empty($users->unit_organisasi_induk))
                                                <div class="text">{{ $users->unit_organisasi_induk }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Jenis Jabatan </div>
                                            @if (!empty($users->jenis_jabatan))
                                                <div class="text">{{ $users->jenis_jabatan }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Eselon </div>
                                            @if (!empty($users->eselon))
                                                <div class="text">{{ $users->eselon }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Jabatan </div>
                                            @if (!empty($users->jabatan))
                                                <div class="text">{{ $users->jabatan }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">TMT</div>
                                            @if (!empty($users->tmt))
                                                <div class="text">{{ date('d F Y', strtotime($users->tmt)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tmt }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Lokasi Kerja </div>
                                            @if (!empty($users->lokasi_kerja))
                                                <div class="text">{{ $users->lokasi_kerja }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Golongan Ruang Awal </div>
                                            @if (!empty($users->gol_ruang_awal))
                                                <div class="text">{{ $users->gol_ruang_awal }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Golongan Ruang Akhir </div>
                                            @if (!empty($users->gol_ruang_akhir))
                                                <div class="text">{{ $users->gol_ruang_akhir }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">TMT Golongan</div>
                                            @if (!empty($users->tmt_golongan))
                                                <div class="text">{{ date('d F Y', strtotime($users->tmt_golongan)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tmt_golongan }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Gaji Pokok </div>
                                            @if (!empty($users->gaji_pokok))
                                                <div class="text">Rp. {{ number_format($users->gaji_pokok, 0, ',', '.') }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->gaji_pokok }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Masa Kerja (Tahun)</div>
                                            @if (!empty($users->masa_kerja_tahun))
                                                <div class="text">{{ $users->masa_kerja_tahun }} Tahun</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->masa_kerja_tahun }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Masa Kerja (Bulan)</div>
                                            @if (!empty($users->masa_kerja_bulan))
                                                <div class="text">{{ $users->masa_kerja_bulan }} Bulan</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->masa_kerja_bulan }}</div>
                                        </li>
                                        <li>
                                            <div class="title">No SPMT </div>
                                            @if (!empty($users->no_spmt))
                                                <div class="text">{{ $users->no_spmt }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                        <li>
                                            <div class="title">Tanggal SPMT</div>
                                            @if (!empty($users->tanggal_spmt))
                                                <div class="text">{{ date('d F Y', strtotime($users->tanggal_spmt)) }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                                <div hidden class="text">{{ $users->tanggal_spmt }}</div>
                                        </li>
                                        <li>
                                            <div class="title">KPPN </div>
                                            @if (!empty($users->kppn))
                                                <div class="text">{{ $users->kppn }}</div>
                                            @else
                                                <div class="text">N/A</div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Profile Pegawai Tab -->
            </div>
            <!-- Tab Content -->
        </div>
        <!-- /Page Content -->
    </div>
    <!-- /Page Wrapper -->


                <!-- Profile Informasi Modal -->
                <div id="profile_info" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Profil Informasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('profile/information/save2') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="name" name="name" value="{{ $users->name }}">
                                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $users->user_id }}">
                                                        <input type="hidden" class="form-control" id="nip" name="nip" value="{{ $users->nip }}">
                                                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $users->email }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <div class="cal-icon">
                                                            @if (!empty($users))
                                                                <input class="form-control datetimepicker" type="text" id="birthDate" name="birthDate" value="{{ $users->tgl_lahir }}">
                                                                <small class="text-danger">Example : 10-10-2013</small>
                                                            @else
                                                                <input class="form-control datetimepicker" type="text" id="birthDate" name="birthDate">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        @if (!empty($users))
                                                            <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" value="{{ $users->tmpt_lahir }}">
                                                        @else
                                                            <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        @if (!empty($users))
                                                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $users->alamat }}">
                                                        @else
                                                            <input type="text" class="form-control" id="alamat" name="alamat">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select class="select" id="jk" name="jk">
                                                            @if (!empty($users))
                                                                <option value="Laki-Laki" {{ $users->jk === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                                <option value="Perempuan" {{ $users->jk === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                            @else
                                                                <option value="Laki-Laki">Laki-Laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        @if (!empty($users))
                                                            <input type="hidden" class="form-control" id="avatar" name="avatar" value="{{ $users->avatar }}">
                                                        @else
                                                            <input type="hidden" class="form-control" id="avatar" name="avatar">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Perbaharui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Profile Informasi Modal -->

                <!-- Foto Profil Modal -->
                <div id="profile_info_avatar" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Foto Profil</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('profile/information/foto/save') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="profile-img-wrap edit-img">
                                                <img class="inline-block" id="imagePreview" src="{{ URL::to('/assets/images/' . $users->avatar) }}" alt="{{ $users->name }}">
                                                <div class="fileupload btn">
                                                    <span class="btn-text">Unggah</span>
                                                    <input class="upload" type="file" id="image" name="images" onchange="previewImage(event)">
                                                    @if (!empty($users))
                                                        <input type="hidden" name="hidden_image" id="e_image" value="{{ $users->avatar }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control" id="name" name="name" value="{{ $users->name }}">
                                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $users->user_id }}">
                                                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $users->email }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Perbaharui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Foto Profil Modal -->

                <!-- Profil Pegawai Modal Edit -->
                <div id="profil_pegawai_modal_edit" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Profil Pegawai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user/profile/pegawai/edit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control" name="user_id" value="{{ $users->user_id }}" readonly>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIP <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ $users->nip }}">
                                                @error('nip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gelar Depan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror" name="gelar_depan" value="{{ $users->gelar_depan }}">
                                                @error('gelar_depan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gelar Belakang <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" name="gelar_belakang" value="{{ $users->gelar_belakang }}">
                                                @error('gelar_belakang')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ $users->tempat_lahir }}">
                                                @error('tempat_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ $users->tanggal_lahir }}">
                                                @error('tanggal_lahir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                                <select class="select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                                    <option selected disabled>-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-Laki" {{ $users->jenis_kelamin === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                    <option value="Perempuan" {{ $users->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="agama">Agama</label>
                                                <span class="text-danger">*</span><br>
                                                <select class="theSelect @error('agama') is-invalid @enderror" name="agama" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Agama --</option>
                                                    @foreach($agamaOptions as $id => $namaAgama)
                                                        <option value="{{ $id }}" {{ $id == $users->agama ? 'selected' : '' }}>{{ $namaAgama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('agama')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Dokumen</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control @error('jenis_dokumen') is-invalid @enderror" name="jenis_dokumen" value="KTP" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"></label> 
                                                <label>Nomor Induk Kependudukan</label>
                                                <span class="text-danger">*</span>
                                                <input type="number" class="form-control @error('no_dokumen') is-invalid @enderror" name="no_dokumen" value="{{ $users->no_dokumen }}">
                                                @error('no_dokumen')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Provinsi</label>
                                                <span class="text-danger">*</span><br>
                                                <select class="theSelect @error('provinsi') is-invalid @enderror" name="provinsi" id="provinsi" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Provinsi --</option>
                                                    @foreach ($provinces as $provinsi)
                                                        <option value="{{ $provinsi->name }}" @if ($users->provinsi == $provinsi->name) selected @endif>{{ $provinsi->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('provinsi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <br><small class="text-danger">*Silahkan memilih dengan pilihan yang berbeda, setelah itu Anda dapat memilih pilihan anda kembali.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kota/Kabupaten</label>
                                                <span class="text-danger">*</span><br>
                                                <select class="theSelect @error('kota') is-invalid @enderror" name="kota" id="kotakabupaten" style="width: 100% !important" value="{{ $users->kota }}">
                                               
                                                </select>
                                                @error('kota')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kecamatan</label>
                                                <span class="text-danger">*</span><br>
                                                <select class="theSelect @error('kecamatan') is-invalid @enderror" name="kecamatan" id="kecamatan" style="width: 100% !important" value="{{ $users->kecamatan }}">
                                               
                                                </select>
                                                @error('kecamatan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Desa/Kelurahan</label>
                                                <span class="text-danger">*</span><br>
                                                <select class="theSelect @error('kelurahan') is-invalid @enderror" name="kelurahan" id="desakelurahan" style="width: 100% !important" value="{{ $users->kelurahan }}">
                                               
                                                </select>
                                                @error('kelurahan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Pos </label> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" value="{{ $users->kode_pos }}">
                                                @error('kode_pos')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor HP </label> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ $users->no_hp }}">
                                                @error('no_hp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor Telepon </label> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ $users->no_telp }}">
                                                @error('no_telp')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Pegawai </label> <span class="text-danger">*</span></label><br>
                                                <select class="theSelect @error('jenis_pegawai') is-invalid @enderror" name="jenis_pegawai" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Jenis Pegawai --</option>
                                                    @foreach($jenispegawaiOptions as $id => $namaJenisPegawai)
                                                        @if(in_array($namaJenisPegawai, ['ASN', 'Non ASN', 'PPPK', 'CPNS']))
                                                            <option value="{{ $id }}" {{ $id == $users->jenis_pegawai ? 'selected' : '' }}>{{ $namaJenisPegawai }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('jenis_pegawai')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kedudukan PNS </label> <span class="text-danger">*</span></label><br>
                                                <select class="theSelect @error('kedudukan_pns') is-invalid @enderror" name="kedudukan_pns" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Kedudukan --</option>
                                                    @foreach($kedudukanOptions as $id => $namaKedudukan)
                                                        <option value="{{ $id }}" {{ $id == $users->kedudukan_pns ? 'selected' : '' }}>{{ $namaKedudukan }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kedudukan_pns')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status Pegawai </label> <span class="text-danger">*</span></label><br>
                                                <select class="theSelect @error('status_pegawai') is-invalid @enderror" name="status_pegawai" style="width: 100% !important">
                                                    <option selected disabled>-- Pilih Status Pegawai --</option>
                                                    <option value="Aktif" {{ $users->status_pegawai === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="Tidak Aktif" {{ $users->status_pegawai === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                </select>
                                                @error('status_pegawai')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TMT PNS </label> <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tmt_pns') is-invalid @enderror" name="tmt_pns" value="{{ $users->tmt_pns }}">
                                                @error('tmt_pns')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor Seri Kartu Pegawai </label> <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('no_seri_karpeg') is-invalid @enderror" name="no_seri_karpeg" value="{{ $users->no_seri_karpeg }}">
                                                @error('no_seri_karpeg')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TMT CPNS </label> <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tmt_cpns') is-invalid @enderror" name="tmt_cpns" value="{{ $users->tmt_cpns }}">
                                                @error('tmt_cpns')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tingkat Pendidikan </label> <span class="text-danger">*</span></label><br>
                                                <select class="theSelect @error('tingkat_pendidikan') is-invalid @enderror" name="tingkat_pendidikan" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Tingkat Pendidikan --</option>
                                                    @foreach($tingkatpendidikanOptions as $id => $namaTingkatPendidikan)
                                                        <option value="{{ $id }}" {{ $id == $users->tingkat_pendidikan ? 'selected' : '' }}>{{ $namaTingkatPendidikan }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tingkat_pendidikan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pendidikan Terakhir</label> <span class="text-danger">*</span></label><br>
                                                <select class="theSelect @error('pendidikan_terakhir') is-invalid @enderror" name="pendidikan_terakhir" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Pendidikan Terakhir --</option>
                                                    @foreach($pendidikanterakhirOptions as $id => $namaPendidikanTerakhir)
                                                        <option value="{{ $id }}" {{ $id == $users->pendidikan_terakhir ? 'selected' : '' }}>{{ $namaPendidikanTerakhir }}</option>
                                                    @endforeach
                                                </select>
                                                @error('pendidikan_terakhir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bidang </label> <span class="text-danger">*</span></label>
                                                <br>
                                                <select class="theSelect  @error('bidang') is-invalid @enderror" name="bidang" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Bidang --</option>
                                                    @foreach($bidangOptions as $id => $namaBidang)
                                                        <option value="{{ $id }}" {{ $id == $users->bidang ? 'selected' : '' }}>{{ $namaBidang }}</option>
                                                    @endforeach
                                                </select>
                                                @error('bidang')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Perbaharui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Profil Pegawai Modal Edit -->

                <!-- Posisi Jabatan Modal Edit -->
                <div id="posisi_jabatan_modal_edit" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Posisi & Jabatan Pegawai</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="validation" action="{{ route('user/profile/posisi/jabatan/edit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control" name="user_id" value="{{ $users->user_id }}" readonly>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Unit Organisasi <span class="text-danger">*</span></label>
                                                @if (!empty($users->unit_organisasi))
                                                    <input type="text" class="form-control" name="unit_organisasi" value="{{ $users->unit_organisasi }}">
                                                @else
                                                    <input type="text" class="form-control" name="unit_organisasi">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Unit Organisasi Induk <span class="text-danger">*</span></label>
                                                @if (!empty($users->unit_organisasi_induk))
                                                    <input type="text" class="form-control" name="unit_organisasi_induk" value="{{ $users->unit_organisasi_induk }}">
                                                @else
                                                    <input type="text" class="form-control" name="unit_organisasi_induk">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Jabatan <span class="text-danger">*</span></label><br>
                                                <select class="theSelect" name="jenis_jabatan" style="width: 100% !important"><br>
                                                        <option selected disabled>-- Pilih Jenis Jabatan --</option>
                                                    @foreach ($jenisjabatanOptions as $optionValue => $jenisJabatan)
                                                        <option value="{{ $optionValue }}" @if ($optionValue == $users->jenis_jabatan) selected @endif>{{ $jenisJabatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Eselon</label>
                                                @if (!empty($users->eselon))
                                                    <input type="text" class="form-control" name="eselon" value="{{ $users->eselon }}">
                                                @else
                                                    <input type="text" class="form-control" name="eselon">
                                                @endif
                                                    <small class="text-danger">*Jika bukan eselon dapat diisi tanda ( - )</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jabatan</label>
                                                @if (!empty($users->jabatan))
                                                    <input type="text" class="form-control" name="jabatan" value="{{ $users->jabatan }}">
                                                @else
                                                    <input type="text" class="form-control" name="jabatan">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TMT</label>
                                                @if (!empty($users->tmt))
                                                    <input type="date" class="form-control" name="tmt" value="{{ $users->tmt }}">
                                                @else
                                                    <input type="date" class="form-control" name="tmt">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Lokasi Kerja</label>
                                                @if (!empty($users->lokasi_kerja))
                                                    <input type="text" class="form-control" name="lokasi_kerja" value="{{ $users->lokasi_kerja }}">
                                                @else
                                                    <input type="text" class="form-control" name="lokasi_kerja">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Golongan Ruang Awal</label><br>
                                                <select class="theSelect" name="gol_ruang_awal" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Golongan Ruang Awal --</option>
                                                    @foreach ($golonganOptions as $optionValue => $golAwal)
                                                        <option value="{{ $optionValue }}" @if ($optionValue == $users->gol_ruang_awal) selected @endif>{{ $golAwal }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Golongan Ruang Akhir</label><br>
                                                <select class="theSelect" name="gol_ruang_akhir" style="width: 100% !important">
                                                        <option selected disabled>-- Pilih Golongan Ruang Akhir --</option>
                                                    @foreach ($golonganOptions as $optionValue => $golAkhir)
                                                        <option value="{{ $optionValue }}" @if ($optionValue == $users->gol_ruang_akhir) selected @endif>{{ $golAkhir }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>TMT Golongan</label>
                                                @if (!empty($users->tmt_golongan))
                                                    <input type="date" class="form-control" name="tmt_golongan" value="{{ $users->tmt_golongan }}">
                                                @else
                                                    <input type="date" class="form-control" name="tmt_golongan">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gaji Pokok</label>
                                                @if (!empty($users->gaji_pokok))
                                                    <input type="number" class="form-control" name="gaji_pokok" value="{{ $users->gaji_pokok }}">
                                                @else
                                                    <input type="number" class="form-control" name="gaji_pokok">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Masa Kerja (Tahun)</label>
                                                @if (!empty($users->masa_kerja_tahun))
                                                    <input type="number" class="form-control" name="masa_kerja_tahun" value="{{ $users->masa_kerja_tahun }}">
                                                @else
                                                    <input type="number" class="form-control" name="masa_kerja_tahun">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Masa Kerja (Bulan)</label>
                                                @if (!empty($users->masa_kerja_bulan))
                                                    <input type="number" class="form-control" name="masa_kerja_bulan" value="{{ $users->masa_kerja_bulan }}">
                                                @else
                                                    <input type="number" class="form-control" name="masa_kerja_bulan">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor SPMT</label>
                                                @if (!empty($users->no_spmt))
                                                    <input type="number" class="form-control" name="no_spmt" value="{{ $users->no_spmt }}">
                                                @else
                                                    <input type="number" class="form-control" name="no_spmt">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal SPMT</label>
                                                @if (!empty($users->tanggal_spmt))
                                                    <input type="date" class="form-control" name="tanggal_spmt" value="{{ $users->tanggal_spmt }}">
                                                @else
                                                    <input type="date" class="form-control" name="tanggal_spmt">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>KPPN</label>
                                                @if (!empty($users->kppn))
                                                    <input type="text" class="form-control" name="kppn" value="{{ $users->kppn }}">
                                                @else
                                                    <input type="text" class="form-control" name="kppn">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Perbaharui</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Posisi Jabatan Modal Edit -->

                <!-- Upload Dokumen KTP Modal -->
                <div id="unggah_dokumen_ktp" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Dokumen KTP</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user/profile/upload-ktp') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ $users->user_id }}">
                                    <div class="row">
                                        <div class="dropzone-box-1" style="max-width: 50rem !important">
                                            <label>File Dokumen KTP</label>
                                            <div class="dropzone-area-1" style="min-height: 15rem !important">
                                                <div class="file-upload-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 4rem !important; width: 6rem !important;" height="16" width="12" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM216 408c0 13.3-10.7 24-24 24s-24-10.7-24-24V305.9l-31 31c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l72-72c9.4-9.4 24.6-9.4 33.9 0l72 72c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-31-31V408z"/></svg>
                                                </div>
                                                <p class="info-pesan-form" style="font-size: 1rem !important">Klik untuk mengunggah atau seret dan lepas</p>
                                                <input type="file" id="dokumen_ktp" name="dokumen_ktp">
                                                <input type="hidden" name="hidden_dokumen_ktp" id="e_dokumen_ktp" value="">
                                                <p class="info-draganddrop-1" style="font-size: 1rem !important">Tidak ada file yang di pilih</p>
                                            </div>
                                            <small class="text-danger">*Harap unggah dokumen dalam format PDF.</small>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" id="submit-button" class="btn btn-primary submit-btn">Unggah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Upload Dokumen KTP Modal -->

    @section('script')
        <script>
            $('#validation').validate({  
                rules: {  
                    unit_organisasi: 'required',
                    unit_organisasi_induk: 'required',
                    jenis_jabatan: 'required',
                    eselon: 'required',
                    jabatan: 'required',
                    tmt: 'required',
                    lokasi_kerja: 'required',
                    gol_ruang_awal: 'required',
                    gol_ruang_akhir: 'required',
                    tmt_golongan: 'required',
                    gaji_pokok: 'required',
                    masa_kerja_tahun: 'required',
                    masa_kerja_bulan: 'required',
                    no_spmt: 'required',
                    tanggal_spmt: 'required',
                    kppn: 'required',
                },  
                messages: {
                    unit_organisasi: 'Bidang unit organisasi wajib diisi.',
                    unit_organisasi_induk: 'Bidang unit organisasi induk wajib diisi.',
                    jenis_jabatan: 'Bidang jenis jabatan wajib diisi.',
                    eselon: 'Bidang eselon wajib diisi.',
                    jabatan: 'Bidang jabatan wajib diisi.',
                    tmt: 'Bidang tmt wajib diisi.',
                    lokasi_kerja: 'Bidang lokasi kerja wajib diisi.',
                    gol_ruang_awal: 'Bidang golongan ruang awal wajib diisi.',
                    gol_ruang_akhir: 'Bidang golongan ruang akhir wajib diisi.',
                    tmt_golongan: 'Bidang tmt golongan wajib diisi.',
                    gaji_pokok: 'Bidang gaji pokok wajib diisi.',
                    masa_kerja_tahun: 'Bidang masa kerja tahun wajib diisi.',
                    masa_kerja_bulan: 'Bidang masa kerja bulan wajib diisi.',
                    no_spmt: 'Bidang nomor spmt wajib diisi.',
                    tanggal_spmt: 'Bidang tanggal spmt wajib diisi.',
                    kppn: 'Bidang kppn wajib diisi.',
                },  
                submitHandler: function(form) {  
                    form.submit();
                }  
            });  
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                if (!$('.datatable').hasClass('dataTable')) {
                    $('.datatable').DataTable({
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "columnDefs": [
                            { "targets": [9, 10, 11], "orderable": false },
                            { "targets": [9, 10, 11], "searchable": false }
                        ]
                    });
                }
            });
        </script>

        <script>
            function previewImage(event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('imagePreview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

        <!-- FancyBox Foto Profil -->
        <script>
            $(document).ready(function() {
                $('[data-fancybox="foto-profil"]').fancybox({
                });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
        <!-- /FancyBox Foto Profil -->

        <script src="{{ asset('assets/js/drag-drop-file.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
		    $(".theSelect").select2();
	    </script>

        <script>
            $(function () {
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                $(function () {
                    $('#provinsi').on('change', function (){
                        let nama_provinsi = $('#provinsi option:selected').text();
                        $.ajax({
                            type : 'POST',
                            url : "{{ route('getkota') }}",
                            data : {nama_provinsi: nama_provinsi},
                            cache : false,

                            success: function(msg){
                                $('#kotakabupaten').html(msg);
                                $('#kecamatan').html('');
                                $('#desakelurahan').html('');
                            },
                            error: function(data){
                                console.log('error:', data.responseText);
                            },
                        })
                    })

                    $('#kotakabupaten').on('change', function (){
                        let nama_kotakabupaten = $('#kotakabupaten option:selected').text();
                        $.ajax({
                            type : 'POST',
                            url : "{{ route('getkecamatan_employee') }}",
                            data : {nama_kotakabupaten: nama_kotakabupaten},
                            cache : false,

                            success: function(msg){
                                $('#kecamatan').html(msg);
                                $('#desakelurahan').html('');
                            },
                            error: function(data){
                                console.log('error:', data.responseText);
                            },
                        })
                    })

                    $('#kecamatan').on('change', function (){
                        let nama_kecamatan= $('#kecamatan option:selected').text();
                        $.ajax({
                            type : 'POST',
                            url : "{{ route('getkelurahan') }}",
                            data : {nama_kecamatan: nama_kecamatan},
                            cache : false,

                            success: function(msg){
                                $('#desakelurahan').html(msg);
                            },
                            error: function(data){
                                console.log('error:', data.responseText);
                            },
                        })
                    })

                })
            });
        </script>

        <script src="{{ asset('assets/js/memuat-ulang.js') }}"></script>

    @endsection
@endsection