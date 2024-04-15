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
                        <h3 class="page-title">Hello World 1</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Hello World 1</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            {!! Toastr::message() !!}
            
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('tampilan-hello-world-1') }}" method="POST">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kelipatan_hello_world"><h4 class="label-hello-world">Hello World ($n) :</h4></label>
                                <select class="select" name="kelipatan_hello_world" id="kelipatan_hello_world">
                                    <option selected disabled>-- Pilih Kelipatan Bilangan --</option>
                                    <option value="kelipatan 1">Kelipatan 1</option>
                                    <option value="kelipatan 2">Kelipatan 2</option>
                                    <option value="kelipatan 3">Kelipatan 3</option>
                                    <option value="kelipatan 4">Kelipatan 4</option>
                                    <option value="kelipatan 5">Kelipatan 5</option>
                                    <option value="kelipatan 6">Kelipatan 6</option>
                                </select>
                            </div>
                        </div>
                        <div class="tombol-hello-world">
                            <button type="submit" class="btn btn-hello" style="width: 50%">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card-1">
                <div class="card-header">
                    @isset($hasil_kelipatan)
                        <h4 class="hello-world-hasil">Hasil Kelipatan : <br></h4>
                        {{ $hasil_kelipatan }}
                    @endisset
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4><b>Contoh $n :</b></h4>
                    <?php
                        function helloworld2($n) {
                            $output = '';

                            for ($i = 1; $i <= $n; $i++) {
                                if ($i % 4 == 0 && $i % 5 == 0) {
                                    $output .= 'helloworld ';
                                } elseif ($i % 4 == 0) {
                                    $output .= 'hello ';
                                } elseif ($i % 5 == 0) {
                                    $output .= 'world ';
                                } else {
                                    $output .= $i . ' ';
                                }
                            }

                            return $output;
                        }
                        
                        echo "<p>helloworld(1) => ". helloworld2(1) ."</p>";
                        echo "<p>helloworld(2) => ". helloworld2(2) ."</p>";
                        echo "<p>helloworld(3) => ". helloworld2(3) ."</p>";
                        echo "<p>helloworld(4) => ". helloworld2(4) ."</p>";
                        echo "<p>helloworld(5) => ". helloworld2(5) ."</p>";
                        echo "<p>helloworld(6) => ". helloworld2(6) ."</p>";
                    ?>
                    <h5><b>Rumus : helloworld($n)</b></h5>
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

        .hello-world-hasil {
            font-family: 'Poppins';
            font-weight: 550;
        }

        .tombol-hello-world {
            text-align: center;
        }

        .label-hello-world{
            font-family: 'Poppins';
            font-weight: 600;
        }
    </style>

    @section('script')
        <script>
            history.pushState({}, "", '/tampilan/hello/world/1');
        </script>
        
        <script>
            document.getElementById('pageTitle').innerHTML = 'Hello World 1 | Aplikasi Simpeg';
        </script>
        
    @endsection
@endsection