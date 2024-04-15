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
                        <h3 class="page-title">Predikat Kinerja</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Predikat Kinerja</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            {!! Toastr::message() !!}
            
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('tampilan-predikat-kinerja') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hasil_kerja"><h4 class="label-hasil-kerja">Hasil Kerja :</h4></label>
                                    <select class="select" name="hasil_kerja" id="hasil_kerja">
                                        <option selected disabled>-- Pilih Hasil Kerja --</option>
                                        <option value="diatas ekspektasi">Diatas Ekspektasi</option>
                                        <option value="sesuai ekspektasi">Sesuai Ekspektasi</option>
                                        <option value="dibawah ekspektasi">Dibawah Ekspektasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="perilaku"><h4 class="label-perilaku">Perilaku :</h4></label>
                                    <select class="select" name="perilaku" id="perilaku">
                                        <option selected disabled>-- Pilih Hasil Kerja --</option>
                                        <option value="diatas ekspektasi">Diatas Ekspektasi</option>
                                        <option value="sesuai ekspektasi">Sesuai Ekspektasi</option>
                                        <option value="dibawah ekspektasi">Dibawah Ekspektasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tombol-predikat">
                            <button type="submit" class="btn btn-hello" style="width: 50%">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card-1">
                <div class="card-header">
                    @isset($predikat)
                        <h4 class="predikat-kinerja">Hasil Predikat Kinerja : <br></h4>
                        {{ $predikat }}
                    @endisset
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

    <style>
        .card {
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }
        
        .card-1 {
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-header {
          padding: 15px;
          background-color: rgb(70 70 70 / 17%);
        }

        .predikat-kinerja {
            font-family: 'Poppins';
            font-weight: 550;
        }

        .tombol-predikat {
            text-align: center;
        }

        .label-perilaku{
            font-family: 'Poppins';
            font-weight: 600;
        }

        .label-hasil-kerja{
            font-family: 'Poppins';
            font-weight: 600;
        }
    </style>

    @section('script')
        <script>
            history.pushState({}, "", '/tampilan/predikat/kinerja');
        </script>
        
        <script>
            document.getElementById('pageTitle').innerHTML = 'Predikat Kinerja | Aplikasi Simpeg';
        </script>
        
    @endsection
@endsection