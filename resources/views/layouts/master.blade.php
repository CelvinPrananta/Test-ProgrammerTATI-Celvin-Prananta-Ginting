<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="SoengSouy Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="SoengSouy Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title id="pageTitle">Beranda | Aplikasi Simpeg</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('assets/img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/font-awesome.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/line-awesome.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{ URL::to('ssets/plugins/morris/morris.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/abea6a9d41.js" crossorigin="anonymous"></script>

    {{-- message toastr --}}
    <link rel="stylesheet" href="{{ URL::to('assets/css/toastr.min.css') }}">
    <script src="{{ URL::to('assets/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/toastr.min.js') }}"></script>
</head>

<body oncontextmenu="return false">
    @yield('style')
    <style>
        .invalid-feedback {
            font-size: 14px;
        }
        .error {
            color: red;
        }
    </style>

    <style>
        @foreach($result_tema as $sql_mode => $mode_tema)
            body{background-color: {{ $mode_tema->warna_sistem }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .peta-jabatan{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema2{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .edit-icon{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .edit-icon-avatar{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema-sub-terang{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema2-sub-terang{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema-sub-gelap{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .fitur-tema2-sub-gelap{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .view-icons .btn{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .nav-tabs .nav-link.active{background-color: {{ $mode_tema->warna_sistem }} !important;}
            .page-item.disabled .page-link{background-color: {{ $mode_tema->warna_sistem }} !important; color : {{ $mode_tema->warna_sistem_tulisan }} !important; border-color: {{ $mode_tema->warna_mode }} !important;}
            .page-link{background-color: {{ $mode_tema->warna_sistem }} !important; border: 1px solid {{ $mode_tema->warna_mode }} !important;}
            .datepicker{background-color: {{ $mode_tema->warna_sistem }} !important; color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .select2-dropdown {background-color: {{ $mode_tema->warna_sistem }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .select2-search--dropdown{background-color: {{ $mode_tema->warna_sistem }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .select2-container--default .select2-search--dropdown .select2-search__field{background-color: {{ $mode_tema->warna_sistem }} !important; color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .bootstrap-datetimepicker-widget table td.day:hover,
            .bootstrap-datetimepicker-widget table td.hour:hover,
            .bootstrap-datetimepicker-widget table td.minute:hover,
            .bootstrap-datetimepicker-widget table td.second:hover{color: {{ $mode_tema->warna_sistem }} !important}

            .card-title{color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .table{color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-pesan-form{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-1{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-2{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-3{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-4{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-5{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-6{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-7{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-8{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-9{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-10{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-11{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-12{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-13{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-14{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-15{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-16{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-17{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-18{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-19{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-20{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-21{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-22{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-23{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-24{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-25{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-26{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-27{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-28{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-29{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-30{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-31{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-32{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-33{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-34{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-35{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-36{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-37{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-38{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-39{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-40{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-41{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-42{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-43{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .info-draganddrop-44{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-1{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-2{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-3{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-4{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-5{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-6{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-7{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-8{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-9{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-10{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-11{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-12{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-13{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-14{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-15{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-16{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-17{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-18{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-19{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-20{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-21{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-22{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-23{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-24{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-25{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-26{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-27{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-28{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-29{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-30{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-31{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-32{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-33{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-34{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-35{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-36{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-37{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-38{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-39{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-40{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-41{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-42{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-43{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropzone-area-44{border: 2px dashed {{ $mode_tema->warna_sistem_tulisan }} !important;}
            table.table td h2 a{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            svg{fill : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            a{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .boc-input>label{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .text-muted{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .user-name{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .personal-info li .title{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .personal-info li .text{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .page-header .breadcrumb a{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .page-header .breadcrumb{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .nav-tabs.nav-justified > li > a{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .apexcharts-text{fill : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .apexcharts-yaxis-label{fill : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .fitur-tema-tulisan-terang{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .fitur-tema2-tulisan-terang{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .fitur-tema-tulisan-gelap{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .fitur-tema2-tulisan-gelap{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .page-header .page-title{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .page-header .breadcrumb-item.active{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .dropdown-item{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .notification-title{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .clear-noti{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .logo-text{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .fa{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .cal-icon:after{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .bar-icon span{background-color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .apexcharts-legend-text{color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .form-header h3{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
            .form-header p{color: {{ $mode_tema->warna_sistem_tulisan }} !important}

            .apexcharts-xaxistooltip, .apexcharts-yaxistooltip{background: {{ $mode_tema->warna_mode }} !important; color : {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .form-control{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .profile-widget{background-color: {{ $mode_tema->warna_mode }} !important;}
            .card{background-color: {{ $mode_tema->warna_mode }} !important;}
            .sidebar {background-color: {{ $mode_tema->warna_mode }} !important;}
            .custom-table tr{background-color: {{ $mode_tema->warna_mode }} !important;}
            .modal-content{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-1{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-2{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-3{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-4{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-5{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-6{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-7{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-8{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-9{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-10{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-11{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-12{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-13{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-14{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-15{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-16{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-17{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-18{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-19{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-20{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-21{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-22{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-23{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-24{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-25{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-26{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-27{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-28{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-29{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-30{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-31{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-32{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-33{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-34{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-35{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-36{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-37{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-38{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-39{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-40{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-41{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-42{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-43{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropzone-box-44{background-color: {{ $mode_tema->warna_mode }} !important;}
            .boc-edit-form-instruments{background-color: {{ $mode_tema->warna_mode }} !important;}
            .boc-edit-form-fields{background-color: {{ $mode_tema->warna_mode }} !important;}
            .status-persetujuan-user{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important}
            .continue-btn{background-color: {{ $mode_tema->warna_mode }}}
            .cancel-btn{background-color: {{ $mode_tema->warna_mode }}}
            .card-header{background-color: {{ $mode_tema->warna_mode }} !important;}
            .nav-tabs{background-color: {{ $mode_tema->warna_mode }} !important;}
            .profile-img-wrap{background : {{ $mode_tema->warna_mode }} !important;}
            .header{background: {{ $mode_tema->warna_mode }} !important; box-shadow: {{ $mode_tema->bayangan_kotak_header }} !important;}
            .btn-white{background-color: {{ $mode_tema->warna_mode }} !important;}
            .btn-outline-secondary{background-color: {{ $mode_tema->warna_mode }} !important;}
            .page-item.active .page-link{background: {{ $mode_tema->warna_mode }} !important; border-color: {{ $mode_tema->warna_mode }} !important;}
            .boc-light .boc-input>input, .boc-light .boc-input>select{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .apexcharts-tooltip.apexcharts-theme-light {background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropdown-item.active, .dropdown-item:active{background-color: {{ $mode_tema->warna_mode }} !important;}
            .dropdown-item:focus, .dropdown-item:hover{background-color: {{ $mode_tema->warna_mode }} !important; border-radius : 10px !important; width: 90% !important; margin-left: 10px !important;}
            .notifications ul.notification-list > li a:hover{background-color: {{ $mode_tema->warna_mode }} !important;}
            .input-group-text{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .select2-container--default .select2-selection--single .select2-selection__rendered{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .form-focus .select2-container--default .select2-selection--single .select2-selection__rendered{background-color: {{ $mode_tema->warna_mode }} !important; color: {{ $mode_tema->warna_sistem_tulisan }} !important;}
            .custom-select{background: {{ $mode_tema->warna_mode }} url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='{{ $mode_tema->warna_sistem_tulisan }}' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat !important;}

            .form-control::-webkit-input-placeholder{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            .form-control::-moz-placeholder{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            .form-control:-ms-input-placeholder{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            .form-control::-ms-input-placeholder{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            .form-control::placeholder{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            .form-focus .focus-label{color: {{ $mode_tema->tabel_tulisan_tersembunyi }} !important;}
            
            .table-striped tbody tr:nth-of-type(odd){background-color: {{ $mode_tema->tabel_warna }} !important;}
            .select2-container--default .select2-selection--single{background-color: {{ $mode_tema->tabel_warna }} !important;}

            .dropdown-menu{background-color: {{ $mode_tema->warna_dropdown_menu }} !important;}
            .dash-widget-icon{background-color: {{ $mode_tema->ikon_plugin }} !important;}
            
            .apexcharts-tooltip.apexcharts-theme-light .apexcharts-tooltip-title{background: {{ $mode_tema->warna_mode_2 }} !important;}
            .select2-container--default .select2-results__option--selected{background-color: {{ $mode_tema->warna_mode_2 }} !important;}

            @foreach($result_tema as $sql_user => $aplikasi_tema)
                @if ($aplikasi_tema->tema_aplikasi == 'Gelap')
                    .cancel-btn{color: #f43b48 !important}
                    .cancel-btn:hover, .cancel-btn:focus, .cancel-btn:active {color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                    .topnav-dropdown-footer a:hover{color: #f83f37 !important}
                    .topnav-dropdown-header .clear-noti:hover{color: #f83f37 !important}
                    .notification-message.noti-read .noti-title{color: #989c9e !important}
                    .boc-edit-form-header{background-color: {{ $mode_tema->warna_dropdown_menu }} !important; border-radius: 0px !important;}
                    .boc-dark .boc-input>label.focused,.boc-light .boc-input>label.focused{color:#039be5 !important}

                    @foreach ($belum_dibaca as $notifikasi_belum_dibaca)
                        #popup-notifikasi_{{ $notifikasi_belum_dibaca->id }} {background: {{ $mode_tema->warna_mode }} !important}
                        .noti-details2{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                        .noti-time3{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                        .fa-clock{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                    @endforeach
                    @foreach ($dibaca as $notifikasi_dibaca)
                        #popup-notifikasi_{{ $notifikasi_dibaca->id }} {background: {{ $mode_tema->warna_mode }} !important}
                        .noti-details2{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                        .noti-time3{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                        .fa-clock{color: {{ $mode_tema->warna_sistem_tulisan }} !important}
                    @endforeach
                @endif
            @endforeach

            @foreach ($belum_dibaca as $notifikasi_belum_dibaca)
            #popup-notifikasi_{{ $notifikasi_belum_dibaca->id }} {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fff;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0px 0px 100px rgba(0, 0, 0, 0.2);
            }

            #close-popup_{{ $notifikasi_belum_dibaca->id }} {
                background-color: #e74a3b;
                border-color: #e74a3b;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 15px;
            }

            #close-popup_{{ $notifikasi_belum_dibaca->id }}:hover {
                background-color: #e02d1b;
                border-color: #d52a1a;
            }

            .close-notifikasi {
                bottom: 20px;
                left: 440px;
                text-align: center;
                position: absolute;
            }
            
            .logo-rsud2 img{
                display: block;
                width: 15%;
                margin-left: 87%;
            }

            .noti-time3 {
                position: absolute;
                bottom: 5px;
                right: 15px;
                float: right;
                color: #333;
                font-size: 14px;
                font-family: 'Poppins';
                text-align: center;
            }
            @endforeach

            @foreach ($dibaca as $notifikasi_dibaca)
            #popup-notifikasi_{{ $notifikasi_dibaca->id }} {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fff;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0px 0px 100px rgba(0, 0, 0, 0.2);
            }

            #close-popup_{{ $notifikasi_dibaca->id }} {
                background-color: #e74a3b;
                border-color: #e74a3b;
                color: #fff;
                border: none;
                padding: 0px 5px;
                border-radius: 20px;
            }

            #close-popup_{{ $notifikasi_dibaca->id }}:hover {
                background-color: #e02d1b;
                border-color: #d52a1a;
            }

            .close-notifikasi-2 {
                position: absolute;
                top: 15px;
                right: 15px;
            }

            .logo-rsud2 img{
                display: block;
                width: 15%;
                margin-left: 87%;
            }

            .noti-time3 {
                position: absolute;
                bottom: 5px;
                right: 15px;
                float: right;
                color: #333;
                font-size: 14px;
                font-family: 'Poppins';
                text-align: center;
            }
            @endforeach
        @endforeach
    </style>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Loader -->
        <div id="loader-wrapper">
            <div id="loader">
                <div class="loader-ellips">
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                </div>
            </div>
        </div>
        <!-- /Loader -->

        <!-- Header -->
        <div class="header">
            
                <!-- Untuk Mengatur Tema Aplikasi -->
                @foreach($result_tema as $sql_user => $aplikasi_tema)
                    <div class="fitur-tema2">
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle nav-link" id="temaAplikasi" data-toggle="dropdown" aria-expanded="false">
                                @if ($aplikasi_tema->tema_aplikasi == 'Terang')
                                    {{-- <i class="fa-regular fa-sun" style="color: #fdae4b; font-size: 25px;"></i> --}}
                                    <svg fill="currentColor" style="color: #fdae4b; margin-top: -7px; margin-left: -4px; width: 37px; height: 37px;" aria-hidden="true" data-slot="icon" viewBox="0 0 20 20" class="h-4 w-4 fill-hurricane">
                                        <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2Zm0 13a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15Zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.657-1.596a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06Zm-9.193 9.192a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10Zm9.596 5.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z"></path>
                                    </svg>
                                @elseif ($aplikasi_tema->tema_aplikasi == 'Gelap')
                                    <i class="fa-solid fa-moon fa-rotate-by" style="color: #fdae4b; margin-top: -5px; font-size: 32px; --fa-rotate-angle: 320deg;"></i>
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="temaAplikasi">
                                <form action="{{ route('updateTemaAplikasi', $aplikasi_tema->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <!-- Untuk Mode Terang -->
                                    <button type="submit" class="dropdown-item" name="tema_aplikasi" value="Terang">
                                        <div class="fitur-tema2-sub-terang">
                                            {{-- <i class="fa-regular fa-sun" style="color: #fdae4b; font-size: 20px; margin-top: 6px;"></i> --}}
                                            <svg fill="currentColor" style="fill: #fdae4b !important; margin-top: 1px; margin-left: 0px; width: 30px; height: 29px;" aria-hidden="true" data-slot="icon" viewBox="0 0 20 20" class="h-4 w-4 fill-hurricane">
                                                <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2Zm0 13a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15Zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.657-1.596a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06Zm-9.193 9.192a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10Zm9.596 5.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z"></path>
                                            </svg>
                                        </div>
                                        <div class="fitur-tema2-tulisan-terang">Terang</div>
                                    </button>
                                    <!-- /Untuk Mode Terang -->
                                    
                                    <!-- Untuk Mode Gelap -->
                                    <button type="submit" class="dropdown-item" name="tema_aplikasi" value="Gelap">
                                        <div class="fitur-tema2-sub-gelap">
                                            <i class="fa-solid fa-moon fa-rotate-by" style="color: #fdae4b; font-size: 24px; margin-top: 4px; margin-left: -2px; --fa-rotate-angle: 320deg;"></i>
                                        </div>
                                        <div class="fitur-tema2-tulisan-gelap">Gelap</div>
                                    </button>
                                    <!-- /Untuk Mode Gelap -->
                                    
                                </form>
                            </div>
                        </li>
                    </div>
                @endforeach
            <!-- /Untuk Mengatur Tema Aplikasi -->

            <!-- Logo -->
            <div class="header-left">
                <a href="{{ route('home') }}" class="logo" style="font-size: 24px; color: #3b5c03; font-weight: bold;">
                    <i class="fa fa-user" style="display: inline-block;"></i>
                    <span class="logo-text" style="display: inline-block;">SIMPEG</span>
                </a>
            </div>

            <!-- /Logo -->
            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!-- /Header Title -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

            <!-- Header Menu -->
            <ul class="nav user-menu">

                <!-- Untuk Mengatur Tema Aplikasi -->
                @foreach($result_tema as $sql_user => $aplikasi_tema)
                    <div class="fitur-tema">
                        <li class="nav-item dropdown">
                            <a href="#" class="dropdown-toggle nav-link" id="temaAplikasi" data-toggle="dropdown" aria-expanded="false">
                                @if ($aplikasi_tema->tema_aplikasi == 'Terang')
                                    {{-- <i class="fa-regular fa-sun" style="color: #fdae4b; font-size: 25px;"></i> --}}
                                    <svg fill="currentColor" style="color: #fdae4b; margin-top: -7px; margin-left: -4px; width: 37px; height: 37px;" aria-hidden="true" data-slot="icon" viewBox="0 0 20 20" class="h-4 w-4 fill-hurricane">
                                        <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2Zm0 13a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15Zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.657-1.596a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06Zm-9.193 9.192a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10Zm9.596 5.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z"></path>
                                    </svg>
                                @elseif ($aplikasi_tema->tema_aplikasi == 'Gelap')
                                    <i class="fa-solid fa-moon fa-rotate-by" style="color: #fdae4b; margin-top: -5px; font-size: 32px; --fa-rotate-angle: 320deg;"></i>
                                @endif
                            </a>
                            <div class="dropdown-menu" aria-labelledby="temaAplikasi">
                                <form action="{{ route('updateTemaAplikasi', $aplikasi_tema->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <!-- Untuk Mode Terang -->
                                    <button type="submit" class="dropdown-item" name="tema_aplikasi" value="Terang">
                                        <div class="fitur-tema-sub-terang">
                                            {{-- <i class="fa-regular fa-sun" style="color: #fdae4b; font-size: 20px; margin-top: 6px;"></i> --}}
                                            <svg fill="currentColor" style="fill: #fdae4b !important; margin-top: 1px; margin-left: 0px; width: 30px; height: 29px;" aria-hidden="true" data-slot="icon" viewBox="0 0 20 20" class="h-4 w-4 fill-hurricane">
                                                <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2Zm0 13a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15Zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm5.657-1.596a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06Zm-9.193 9.192a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10Zm9.596 5.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z"></path>
                                            </svg>
                                        </div>
                                        <div class="fitur-tema-tulisan-terang">Terang</div>
                                    </button>
                                    <!-- /Untuk Mode Terang -->
                                    
                                    <!-- Untuk Mode Gelap -->
                                    <button type="submit" class="dropdown-item" name="tema_aplikasi" value="Gelap">
                                        <div class="fitur-tema-sub-gelap">
                                            <i class="fa-solid fa-moon fa-rotate-by" style="color: #fdae4b; font-size: 24px; margin-top: 4px; margin-left: -2px; --fa-rotate-angle: 320deg;"></i>
                                        </div>
                                        <div class="fitur-tema-tulisan-gelap">Gelap</div>
                                    </button>
                                    <!-- /Untuk Mode Gelap -->
                                    
                                </form>
                            </div>
                        </li>
                    </div>
                @endforeach
                <!-- /Untuk Mengatur Tema Aplikasi -->

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge badge-pill">{{ $unreadNotifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifikasi</span>
                            <form method="POST" action="{{ route('notifikasi.dibaca-semua') }}">
                                @csrf
                                <button type="submit" class="clear-noti">Tandai Semua Dibaca</button>
                            </form>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list" style="display: block">
                                @if(auth()->user()->unreadNotifications->isEmpty() && auth()->user()->readNotifications->isEmpty())
                                    <li class="notification-message noti-unread">
                                        <p class="noti-details" style="margin-top: 30px; text-align: center;">
                                            <i class="fa-solid fa-bell-slash fa-fade fa-2xl"></i>
                                        </p>
                                        <p class="noti-details" style="margin-top: 10px; text-align: center;">Tidak ada notifikasi baru</p>
                                    </li>
                                @endif

                                @foreach ($belum_dibaca->where('notifiable_id', auth()->id()) as $notifikasi_belum_dibaca)
                                @php
                                    $notifikasiDataBelumDibaca = json_decode($notifikasi_belum_dibaca->data);
                                    $created_at = \Carbon\Carbon::parse($notifikasi_belum_dibaca->created_at);
                                    $read_at = \Carbon\Carbon::parse($notifikasi_belum_dibaca->read_at);
                                @endphp
                                    <li class="notification-message noti-unread">
                                        <a href="#" id="open-popup_{{ $notifikasi_belum_dibaca->id }}">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ URL::to('/assets/images/' . $notifikasiDataBelumDibaca->avatar) }}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details">
                                                        <span class="noti-title">
                                                            <b>{{ $notifikasiDataBelumDibaca->message3 }} {{ $notifikasiDataBelumDibaca->name }}</b>
                                                        </span><br>
                                                            Ada pesan baru untuk anda   !!
                                                    </p>
                                                    <p class="noti-time">
                                                        <i class="fa-solid fa-clock" style="color: #808080;" aria-hidden="true"></i>
                                                        <span class="notification-time">{{ $created_at->diffForHumans() }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                                @foreach ($dibaca->where('notifiable_id', auth()->id()) as $notifikasi_dibaca)
                                @php
                                    $notifikasiDataDibaca = json_decode($notifikasi_dibaca->data);
                                    $created_at = \Carbon\Carbon::parse($notifikasi_dibaca->created_at);
                                    $read_at = \Carbon\Carbon::parse($notifikasi_dibaca->read_at);
                                @endphp
                                    <li class="notification-message noti-read">
                                        <a href="#" id="open-popup_{{ $notifikasi_dibaca->id }}">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ URL::to('/assets/images/' . $notifikasiDataDibaca->avatar) }}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details">
                                                        <span class="noti-title">
                                                            <b>{{ $notifikasiDataDibaca->message3 }} {{ $notifikasiDataDibaca->name }}</b>
                                                        </span><br>
                                                            Ada pesan baru untuk anda   !!
                                                    </p>
                                                    <p class="noti-time">
                                                        <i class="fa-solid fa-clock" style="color: #808080;" aria-hidden="true"></i>
                                                        <span class="notification-time">{{ $created_at->diffForHumans() }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer"><a href="{{ route('tampilan-semua-notifikasi') }}">Lihat Semua Notifikasi</a></div>
                    </div>
                </li>
				<!-- /Notifications -->

                <!-- Notifikasi Belum Dibaca Modal -->
                @foreach ($belum_dibaca as $notifikasi_belum_dibaca)
                @php
                    $notifikasiDataBelumDibaca = json_decode($notifikasi_belum_dibaca->data);
                    $created_at = \Carbon\Carbon::parse($notifikasi_belum_dibaca->created_at);
                    $read_at = \Carbon\Carbon::parse($notifikasi_belum_dibaca->read_at);
                @endphp
                <div id="popup-notifikasi_{{ $notifikasi_belum_dibaca->id }}">
                    <li class="notification-message noti-unread">
                        <div class="media">
                            <div class="media-body">
                                <p class="noti-details3"><br>
                                    <a><b>{{ $notifikasiDataBelumDibaca->name }}</b></a><br>
                                    <a>{{ $notifikasiDataBelumDibaca->message }} / {{ \Carbon\Carbon::parse($notifikasiDataBelumDibaca->message2)->format('d F Y') }}</a><br>
                                    <a style="color: #808080; font-weight: 500; font-size: 12px">ID Notifikasi: {{ substr($notifikasi_belum_dibaca->id, 0, 8) }}</a>
                                </p><br>
                                <p class="noti-details2">
                                    <i>{{ $notifikasiDataBelumDibaca->message4 }} <b>{{ $notifikasiDataBelumDibaca->message5 }}</b> {{ $notifikasiDataBelumDibaca->message6 }}<br>
                                    {{ $notifikasiDataBelumDibaca->message7 }}<b>{{ $notifikasiDataBelumDibaca->message8 }}</b><br>
                                    Kepada <b>{{ $notifikasiDataBelumDibaca->name }}</b> {{ $notifikasiDataBelumDibaca->message9 }}</i>
                                <br><br></p>
                                <p class="logo-rsud2">
                                    <img src="{{ asset('assets/images/Logo_RSUD_Caruban.png') }}" alt="Logo RSUD Caruban">
                                </p>
                                <p class="noti-time3">
                                    <b>RSUD Caruban</b><br>
                                    <i class="fa-solid fa-clock" style="color: #808080;" aria-hidden="true"></i>
                                    <span class="notification-time">{{ $created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>
                    </li>
                    <div class="close-notifikasi">
                        <a href="{{ route('notifikasi.dibaca', $notifikasi_belum_dibaca->id) }}"><button id="close-popup_{{ $notifikasi_belum_dibaca->id }}">Tutup</button></a>
                    </div>
                </div>
                @endforeach
                <!-- /Notifikasi Belum Dibaca Modal -->

                <!-- Notifikasi Dibaca Modal -->
                @foreach ($dibaca as $notifikasi_dibaca)
                @php
                    $notifikasiDataDibaca = json_decode($notifikasi_dibaca->data);
                    $created_at = \Carbon\Carbon::parse($notifikasi_dibaca->created_at);
                    $read_at = \Carbon\Carbon::parse($notifikasi_dibaca->read_at);
                @endphp
                <div id="popup-notifikasi_{{ $notifikasi_dibaca->id }}">
                    <li class="notification-message noti-unread">
                        <div class="media">
                            <div class="media-body">
                                <p class="noti-details3"><br>
                                    <a><b>{{ $notifikasiDataDibaca->name }}</b></a><br>
                                    <a>{{ $notifikasiDataDibaca->message }} / {{ \Carbon\Carbon::parse($notifikasiDataDibaca->message2)->format('d F Y') }}</a><br>
                                    <a style="color: #808080; font-weight: 500; font-size: 12px">ID Notifikasi: {{ substr($notifikasi_dibaca->id, 0, 8) }}</a>
                                </p><br>
                                <p class="noti-details2">
                                    <i>{{ $notifikasiDataDibaca->message4 }} <b>{{ $notifikasiDataDibaca->message5 }}</b> {{ $notifikasiDataDibaca->message6 }}<br>
                                    {{ $notifikasiDataDibaca->message7 }}<b>{{ $notifikasiDataDibaca->message8 }}</b><br>
                                    Kepada <b>{{ $notifikasiDataDibaca->name }}</b> {{ $notifikasiDataDibaca->message9 }}</i>
                                <br><br></p>
                                <p class="logo-rsud2">
                                    <img src="{{ asset('assets/images/Logo_RSUD_Caruban.png') }}" alt="Logo RSUD Caruban">
                                </p>
                                <p class="noti-time3">
                                    <b>RSUD Caruban</b><br>
                                    <i class="fa-solid fa-clock" style="color: #808080;" aria-hidden="true"></i>
                                    <span class="notification-time">{{ $created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>
                    </li>
                    <div class="close-notifikasi-2">
                        <button type="button" class="close" id="close-popup_{{ $notifikasi_dibaca->id }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endforeach
                <!-- /Notifikasi Dibaca Modal -->

                <!-- Profil -->
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{ URL::to('/assets/images/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            <span class="status online"></span>
                        </span>
                        <span>{{ Session::get('name') }}</span>
                    </a>
                    <div class="dropdown-menu">
                        @if (Auth::user()->role_name == 'Kepala Dinas')
                            <a class="dropdown-item" href="{{ route('kepala-dinas-profile') }}">Profil Saya</a>
                        @endif
                        @if (Auth::user()->role_name == 'Kepala Bidang')
                            <a class="dropdown-item" href="{{ route('kepala-bidang-profile') }}">Profil Saya</a>
                        @endif
                        @if (Auth::user()->role_name == 'Staff')
                            <a class="dropdown-item" href="{{ route('staff-profile') }}">Profil Saya</a>
                        @endif                        
                        @if (Auth::user()->role_name == 'Kepala Dinas')
                            <a class="dropdown-item" href="{{ route('pengaturan-perusahaan') }}">Pengaturan</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @if (Auth::user()->role_name == 'Kepala Dinas')
                        <a class="dropdown-item" href="{{ route('kepala-dinas-profile') }}">Profil Saya</a>
                    @endif
                    @if (Auth::user()->role_name == 'Kepala Bidang')
                        <a class="dropdown-item" href="{{ route('kepala-bidang-profile') }}">Profil Saya</a>
                    @endif
                    @if (Auth::user()->role_name == 'Staff')
                        <a class="dropdown-item" href="{{ route('staff-profile') }}">Profil Saya</a>
                    @endif                        
                    @if (Auth::user()->role_name == 'Kepala Dinas')
                        <a class="dropdown-item" href="{{ route('pengaturan-perusahaan') }}">Pengaturan</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
            <!-- /Mobile Menu -->

        </div>
        <!-- /Header -->
        <!-- Sidebar -->
        @include('sidebar.sidebar')
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        @yield('content')
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::to('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ URL::to('assets/js/popper.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ URL::to('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/chart.js') }}"></script>
    <script src="{{ URL::to('assets/js/Chart.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/line-chart.js') }}"></script>
    <!-- Slimscroll JS -->
    <script src="{{ URL::to('assets/js/jquery.slimscroll.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ URL::to('assets/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ URL::to('assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Multiselect JS -->
    <script src="{{ URL::to('assets/js/multiselect.min.js') }}"></script>
    <!-- validation-->
    <script src="{{ URL::to('assets/js/jquery.validate.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ URL::to('assets/js/app.js') }}"></script>

    <script>
        @foreach ($belum_dibaca as $notifikasi_belum_dibaca)
            $(document).ready(function() {
                $("#open-popup_{{ $notifikasi_belum_dibaca->id }}").click(function() {
                    $("#popup-notifikasi_{{ $notifikasi_belum_dibaca->id }}").fadeIn();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('close-popup_{{ $notifikasi_belum_dibaca->id }}').addEventListener('click', function() {
                    document.querySelector('#popup-notifikasi_{{ $notifikasi_belum_dibaca->id }}').style.display = 'none';
                });
            });
        @endforeach
    </script>

    <script>
        @foreach ($dibaca as $notifikasi_dibaca)
            $(document).ready(function() {
                $("#open-popup_{{ $notifikasi_dibaca->id }}").click(function() {
                    $("#popup-notifikasi_{{ $notifikasi_dibaca->id }}").fadeIn();
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('close-popup_{{ $notifikasi_dibaca->id }}').addEventListener('click', function() {
                    document.querySelector('#popup-notifikasi_{{ $notifikasi_dibaca->id }}').style.display = 'none';
                });
            });
        @endforeach
    </script>

    <script>
        var toggleBtn = document.getElementById("toggle_btn");
        var logoText = document.querySelector(".logo-text");
        var faUser = document.querySelector(".fa-user");

        toggleBtn.addEventListener("click", function() {
            if (logoText.style.display === "none") {
                logoText.style.display = "inline-block";
                faUser.style.display = "inline-block";
            } else {
                logoText.style.display = "none";
                faUser.style.display = "inline-block";
            }
        });
    </script>
    @yield('script')
    
</body>
</html>