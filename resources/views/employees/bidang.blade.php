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
                        <h3 class="page-title"> Referensi Tabel Bidang</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Bidang</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_bidang"><i class="fa fa-plus"></i> Tambah Bidang</a>
                    </div>
                </div>
            </div>

            <!-- Pencaharian Bidang -->
            <form action="{{ route('form/ruangan/search') }}" method="GET" id="search-form">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="keyword" name="keyword">
                            <label class="focus-label">Nama Bidang</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button type="submit" class="btn btn-success btn-block btn_search">Cari</button>
                    </div>
                </div>
            </form>
            <!-- /Pencaharian Bidang -->

            <!-- /Page Header -->
            {!! Toastr::message() !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th class="no"><center>No</center></th>
                                    <th><center>Nama Bidang</center></th>
                                    <th class="aksi"><center>Aksi</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bidang as $sqlbidang => $result_bidang)
                                    <tr>
                                        <td class="id"><center>{{ $result_bidang->id }}</center></td>
                                        <td class="bidang"><center>{{ $result_bidang->bidang }}</center></td>

                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item edit_bidang" href="#"
                                                        data-toggle="modal" data-target="#edit_bidang"><i
                                                            class="fa fa-pencil m-r-5"></i>
                                                        Edit</a>
                                                    <a class="dropdown-item delete_bidang" href="#"
                                                        data-toggle="modal" data-target="#delete_bidang"><i
                                                            class="fa fa-trash-o m-r-5"></i>
                                                        Delete</a>
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

        <!-- Add Bidang Modal -->
        <div id="add_bidang" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bidang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/ruangan/save') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Bidang <span class="text-danger">*</span></label>
                                    <input class="form-control @error('bidang') is-invalid @enderror" type="text" id="bidang" name="bidang">
                                    @error('bidang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Bidang Modal -->

        <!-- Edit Bidang Modal -->
        <div id="edit_bidang" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Bidang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/ruangan/update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="form-group">
                                <label>Nama Bidang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bidang_edit" name="bidang" value="">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Bidang Modal -->

        <!-- Delete Bidang Modal -->
        <div class="modal custom-modal fade" id="delete_bidang" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Hapus Bidang</h3>
                            <p>Apakah anda yakin ingin menghapus data ini?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/ruangan/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">Hapus</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete Bidang Modal -->
    </div>

    <!-- /Page Wrapper -->
    @section('script')
        <script src="{{ asset('assets/js/referensibidang.js') }}"></script>

        <script src="{{ asset('assets/js/memuat-ulang.js') }}"></script>

        <script>
            history.pushState({}, "", '/referensi/bidang');
        </script>

        <script>
            document.getElementById('pageTitle').innerHTML = 'Data Referensi Bidang - Kepala Dinas | Aplikasi Simpeg';
        </script>

@endsection
@endsection
