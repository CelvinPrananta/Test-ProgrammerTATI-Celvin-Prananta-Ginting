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
                        <h3 class="page-title">Hello World 2</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Hello World 2</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            {!! Toastr::message() !!}
            
            <?php
                function helloworld($n) {
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
            ?>

            <div class="card-1">
                <div class="card-header">
                    <p>Hello World - Kelipatan 1 || helloworld(1)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n1()">Output</button>
            </div>

            <div class="card-2">
                <div class="card-header">
                    <p>Hello World - Kelipatan 2 || helloworld(2)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n2()">Output</button>

            </div>

            <div class="card-3">
                <div class="card-header">
                    <p>Hello World - Kelipatan 3 || helloworld(3)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n3()">Output</button>
            </div>
            
            <div class="card-4">
                <div class="card-header">
                    <p>Hello World - Kelipatan 4 || helloworld(4)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n4()">Output</button>
            </div>

            <div class="card-5">
                <div class="card-header">
                    <p>Hello World - Kelipatan 5 || helloworld(5)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n5()">Output</button>
            </div>

            <div class="card-6">
                <div class="card-header">
                    <p>Hello World - Kelipatan 6 || helloworld(6)</p>
                </div>
                <button type="button" class="btn btn-hello" onclick="n6()">Output</button>
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

            <div class="modal custom-modal fade" id="n1" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 1</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(1)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal custom-modal fade" id="n2" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 2</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(2)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal custom-modal fade" id="n3" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 3</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(3)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal custom-modal fade" id="n4" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 4</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(4)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal custom-modal fade" id="n5" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 5</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(5)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal custom-modal fade" id="n6" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="text-align: center ">Kelipatan 6</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3 style="text-align: center"><b><?php echo helloworld(6)?></b></h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->

    <style>
        .card {
            float: left;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }
        
        .card-1 {
            float: left;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-2 {
            float: right;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-3 {
            float: left;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-4 {
            float: left;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-5 {
            float: left;
            width: 50%;
            border: 1px solid #ededed;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        }

        .card-6 {
            float: right;
            width: 50%;
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
    </style>

    @section('script')
        <script>
            function n1() {
                $('#n1').modal('show');
            }

            function n2() {
                $('#n2').modal('show');
            }

            function n3() {
                $('#n3').modal('show');
            }

            function n4() {
                $('#n4').modal('show');
            }

            function n5() {
                $('#n5').modal('show');
            }

            function n6() {
                $('#n6').modal('show');
            }
        </script>

        <script>
            history.pushState({}, "", '/tampilan/hello/world/2');
        </script>
        
        <script>
            document.getElementById('pageTitle').innerHTML = 'Hello World 2 | Aplikasi Simpeg';
        </script>
        
    @endsection
@endsection