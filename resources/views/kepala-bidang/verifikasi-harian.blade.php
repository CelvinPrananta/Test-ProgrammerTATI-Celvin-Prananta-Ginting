@extends('layouts.master')
@section('content')

    <style>
        .fa-eye {
            color: white;
        }

        @foreach($result_tema as $sql_user => $aplikasi_tema)
            @if ($aplikasi_tema->tema_aplikasi == 'Gelap')
                .text-warning, .dropdown-menu > li > a.text-warning {color: #ffbc34 !important;}
                .text-success, .dropdown-menu > li > a.text-success {color: #55ce63 !important;}
                .text-danger, .dropdown-menu > li > a.text-danger {color: #f62d51 !important;}
            @endif
        @endforeach
    </style>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Verifikasi Catatan Harian</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Verifikasi Catatan Harian</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                
                    <!-- Search Filter -->
                    <form action="{{ route('catatan/harian/verifikasi/kepala-bidang/cari') }}" method="GET" id="search-form">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="name">
                                    <label class="focus-label">Nama Pegawai</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <input type="date" class="form-control floating" name="tanggal_kegiatan">
                                    <label class="focus-label">Tanggal Kegiatan</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus select-focus">
                                    <select class="select floating" name="persetujuan_kepala_bidang">
                                        <option selected disabled>-- Pilih Status Catatan --</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                    <label class="focus-label">Status Catatan</label>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-3">
                                <button type="submit" class="btn btn-success btn-block btn_search">Cari</button>
                            </div>
                        </div>
                    </form>
                    <!-- Search Filter -->
                
                    {{-- message --}}
                    {!! Toastr::message() !!}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pegawai</th>
                                            <th>NIP</th>
                                            <th>Kegiatan</th>
                                            <th>Tanggal Kegiatan</th>
                                            <th>Persetujuan Kepala Bidang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_staff as $sqlcuti => $result_cuti)
                                        <tr>
                                            {{-- <td>{{ ++$sqlcuti }}</td> --}}
                                            <td class="id">{{ $result_cuti->id }}</td>
                                            <td class="name">{{ $result_cuti->name }}</td>
                                            <td class="nip">{{ $result_cuti->nip }}</td>
                                            <td class="catatan_kegiatan">{{ $result_cuti->catatan_kegiatan }}</td>
                                            <td class="tanggal_kegiatan">{{ $result_cuti->tanggal_kegiatan }}</td>

                                            <td class="persetujuan_kepala_bidang">
                                                <div class="dropdown">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" id="statusDropdown" data-toggle="dropdown" aria-expanded="false">
                                                        @if ($result_cuti->persetujuan_kepala_bidang == 'Disetujui')
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                        @elseif ($result_cuti->persetujuan_kepala_bidang == 'Pending')
                                                            <i class="fa fa-dot-circle-o text-warning"></i>
                                                        @elseif ($result_cuti->persetujuan_kepala_bidang == 'Ditolak')
                                                            <i class="fa fa-dot-circle-o text-danger"></i>
                                                        @endif
                                                        <span class="dropdown_pengajuan">{{ $result_cuti->persetujuan_kepala_bidang }}</span>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                                        <form action="{{ route('updateStatusCatatan', $result_cuti->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_bidang" value="Disetujui">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Disetujui
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_bidang" value="Pending">
                                                                <i class="fa fa-dot-circle-o text-warning"></i> Pending
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_bidang" value="Ditolak">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Ditolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- /Page Wrapper -->

    @section('script')
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

        <script src="{{ asset('assets/js/memuat-ulang.js') }}"></script>

        <script>
            history.pushState({}, "", '/catatan/harian/verifikasi/kepala-bidang');
        </script>

        <script>
            document.getElementById('pageTitle').innerHTML = 'Catatan Harian Verifikasi - Kepala Bidang | Aplikasi SIMPEG';
        </script>

    @endsection
@endsection