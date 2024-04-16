@extends('layouts.master')
@section('content')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <!-- Page Content -->
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Catatan Harian Pribadi Kepala Dinas</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Catatan Harian Pribadi Kepala Dinas</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#catatan_harian_pribadi_kepala_dinas"><i class="fa fa-plus"></i> Tambah Catatan Harian</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                    <!-- Cetak Dokumen Kelengkapan PDF -->
                    @php
                        $lastCuti = $data_pribadi_kepala_dinas->last();
                    @endphp
                    @if ($lastCuti)
                        <button type="button" class="btn btn-info" id="lihatSemua" style="border-radius: 20px">
                            <i id="icon2" class="fa fa-eye-slash"></i> Lihat Semua Progress
                        </button>
                    @else
                    @endif
                    <br><br>
                    <!-- /Cetak Dokumen Kelengkapan PDF -->

                    <!-- Search Filter -->
                    <form action="{{ route('catatan/harian/pribadi/kepala-dinas/cari') }}" method="GET" id="search-form">
                        @csrf
                        <div class="row filter-row">
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group form-focus">
                                    <input type="text" class="form-control floating" name="catatan_kegiatan">
                                    <label class="focus-label">Kegiatan</label>
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
                                    <select class="select floating" name="status_pengajuan">
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
                                            <th>Kegiatan</th>
                                            <th>Tanggal Kegiatan</th>
                                            <th>Status Catatan</th>
                                            <th>Progress Persetujuan</th>
                                            <th>Persetujuan Kepala Dinas</th>
                                            <th class="text-right no-sort">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_pribadi_kepala_dinas as $sqlcutipribadi => $result_cuti_pribadi)
                                        <tr>
                                            {{-- <td>{{ ++$sqlcuti }}</td> --}}
                                            <td class="id">{{ $result_cuti_pribadi->id }}</td>
                                            <td class="catatan_kegiatan">{{ $result_cuti_pribadi->catatan_kegiatan }}</td>
                                            <td class="tanggal_kegiatan">{{ $result_cuti_pribadi->tanggal_kegiatan }}</td>
                                            <td class="status_pengajuan">
                                                <div class="dropdown">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" id="statusDropdown" data-toggle="dropdown" aria-expanded="false">
                                                        @if ($result_cuti_pribadi->status_pengajuan == 'Disetujui')
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                        @elseif ($result_cuti_pribadi->status_pengajuan == 'Pending')
                                                            <i class="fa fa-dot-circle-o text-warning"></i>
                                                        @elseif ($result_cuti_pribadi->status_pengajuan == 'Ditolak')
                                                            <i class="fa fa-dot-circle-o text-danger"></i>
                                                        @endif
                                                            <span class="dropdown_pengajuan">{{ $result_cuti_pribadi->status_pengajuan }}</span>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                                        <form action="{{ route('updateStatusCatatan', $result_cuti_pribadi->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item" name="status_pengajuan" value="Disetujui">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Disetujui
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="status_pengajuan" value="Pending">
                                                                <i class="fa fa-dot-circle-o text-warning"></i> Pending
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="status_pengajuan" value="Ditolak">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Ditolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="progress_persetujuan">
                                                <div class="dropdown status-persetujuan-user">
                                                    @if ($result_cuti_pribadi->persetujuan_kepala_bidang == 'Disetujui')
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                    @elseif ($result_cuti_pribadi->persetujuan_kepala_bidang == 'Pending')
                                                        <i class="fa fa-dot-circle-o text-warning"></i>
                                                    @elseif ($result_cuti_pribadi->persetujuan_kepala_bidang == 'Ditolak')
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                    @endif
                                                    <span class="persetujuan_kepala_bidang">{{ $result_cuti_pribadi->persetujuan_kepala_bidang }}</span> (Kepala Bidang)
                                                </div>
                                                <div class="dropdown status-persetujuan-user">
                                                    @if ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Disetujui')
                                                        <i class="fa fa-dot-circle-o text-success"></i>
                                                    @elseif ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Pending')
                                                        <i class="fa fa-dot-circle-o text-warning"></i>
                                                    @elseif ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Ditolak')
                                                        <i class="fa fa-dot-circle-o text-danger"></i>
                                                    @endif
                                                        <span class="persetujuan_kepala_dinas">{{ $result_cuti_pribadi->persetujuan_kepala_dinas }}</span> (Kepala Dinas)
                                                </div>
                                            </td>
                                            <td class="persetujuan_kepala_dinas">
                                                <div class="dropdown">
                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" id="statusDropdown" data-toggle="dropdown" aria-expanded="false">
                                                        @if ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Disetujui')
                                                            <i class="fa fa-dot-circle-o text-success"></i>
                                                        @elseif ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Pending')
                                                            <i class="fa fa-dot-circle-o text-warning"></i>
                                                        @elseif ($result_cuti_pribadi->persetujuan_kepala_dinas == 'Ditolak')
                                                            <i class="fa fa-dot-circle-o text-danger"></i>
                                                        @endif
                                                        <span class="dropdown_pengajuan">{{ $result_cuti_pribadi->persetujuan_kepala_dinas }}</span>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                                        <form action="{{ route('updateStatusCatatan', $result_cuti_pribadi->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_dinas" value="Disetujui">
                                                                <i class="fa fa-dot-circle-o text-success"></i> Disetujui
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_dinas" value="Pending">
                                                                <i class="fa fa-dot-circle-o text-warning"></i> Pending
                                                            </button>
                                                            <button type="submit" class="dropdown-item" name="persetujuan_kepala_dinas" value="Ditolak">
                                                                <i class="fa fa-dot-circle-o text-danger"></i> Ditolak
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
    
                                            {{-- Edit & Hapus Catatan Harian--}}
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item edit_catatan_harian" href="#" data-toggle="modal" data-target="#edit_catatan_harian"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <a class="dropdown-item delete_catatan_harian" href="#" data-toggle="modal" data-target="#delete_catatan_harian"><i class='fa fa-trash-o m-r-5'></i> Delete</a>
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
                <!-- /Page Content -->

                <!-- Tambah Catatan Harian Modal -->
                <div id="catatan_harian_pribadi_kepala_dinas" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Catatan Harian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('catatan/harian/tambah-data') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->user_id }}">
                                        @foreach($data_profilkepaladinas_pribadi as $sqlcuti => $result_cuti)
                                            <input type="hidden" class="form-control" name="name"  value="{{ $result_cuti->name }}">
                                            <input type="hidden" class="form-control" name="nip" value="{{ $result_cuti->nip }}">
                                        @endforeach
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Hari Ini</label>
                                                    <br>
                                                    <textarea class="form-control" name="catatan_kegiatan" rows="5" cols="5" placeholder="Ceritakan kegiatan Anda hari ini"></textarea>
                                                    <small class="text-danger" style="font-size: 16px;">*Nb :<br>
                                                        <b>(Tekan Enter atau Shift + Enter untuk membuat paragraf baru)</b>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Kegiatan</label>
                                                    <input type="date" class="form-control" name="tanggal_kegiatan">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="status_pengajuan"  value="Pending">
                                        <input type="hidden" class="form-control" name="persetujuan_kepala_bidang"  value="Disetujui">
                                        <input type="hidden" class="form-control" name="persetujuan_kepala_dinas"  value="Pending">
                                        <div class="submit-section">
                                            <button type="submit" id="submit-button" class="btn btn-primary submit-btn">Simpan</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Tambah Catatan Harian Modal -->

                <!-- /Edit Catatan Harian Modal -->
                <div id="edit_catatan_harian" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Catatan Harian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('catatan/harian/edit-data') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <input type="hidden" name="id" id="e_id" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Kegiatan Hari Ini</label>
                                                    <br>
                                                    <textarea class="form-control" name="catatan_kegiatan" id="e_catatan_kegiatan" rows="5" cols="5" placeholder="Ceritakan kegiatan Anda hari ini"></textarea>
                                                    <small class="text-danger" style="font-size: 16px;">*Nb :<br>
                                                        <b>(Tekan Enter atau Shift + Enter untuk membuat paragraf baru)</b>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tanggal Kegiatan</label>
                                                    <input type="date" class="form-control" name="tanggal_kegiatan" id="e_tanggal_kegiatan" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-section">
                                            <button type="submit" id="submit-button" class="btn btn-primary submit-btn">Simpan</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Edit Catatan Harian Modal -->

                <!-- Delete Catatan Harian Modal -->
                <div class="modal custom-modal fade" id="delete_catatan_harian" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>Hapus Catatan Harian</h3>
                                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <form action="{{ route('catatan/harian/hapus-data') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" class="e_id_catatan" value="">
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="submit"
                                                    class="btn btn-danger continue-btn submit-btn">Hapus</button>
                                            </div>
                                            <div class="col-6">
                                                <a href="javascript:void(0);" data-dismiss="modal"
                                                    class="btn btn-primary cancel-btn">Kembali</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Delete Catatan Harian Modal -->

            </div>
            <!-- /Page Wrapper -->

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

        <script src="{{ asset('assets/js/catatanharian.js') }}"></script>
        <script src="{{ asset('assets/js/statuscatatan.js') }}"></script>
        <script src="{{ asset('assets/js/memuat-ulang.js') }}"></script>

        <script>
            history.pushState({}, "", '/catatan/harian/pribadi/kepala-dinas');
        </script>

        <script>
            document.getElementById('pageTitle').innerHTML = 'Catatan Harian Pribadi - Kepala Dinas | Aplikasi Simpeg';
        </script>

    @endsection
@endsection