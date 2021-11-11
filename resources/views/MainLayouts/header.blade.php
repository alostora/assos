<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@lang('leftsidebar.menuqr')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">



  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url('dashboard_admin_panel/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



<!-- datatables -->
  <!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
  <!-- datatables -->










  @if(App::getLocale() == "ar" || App::getLocale() == "")
    <link rel="stylesheet" href="{{url('dashboard_admin_panel/bootstrap/css/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css1/AdminLTE-rtl.min.css')}}">
    <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css1/skins/_all-skins-rtl.min.css')}}">
    <?php $dir = "rtl" ?>
  @elseif(App::getLocale() == "en")
    <?php $dir = "ltr" ?> 
  @else
    <?php $dir = "rtl" ?>  
  @endif

<link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <link rel="stylesheet" href="{{url('dashboard_admin_panel/myStyle.css')}}">

<script src="{{url('dashboard_admin_panel/bower_components/ckeditor/ckeditor.js')}}"></script>
<script src="{{url('dashboard_admin_panel/bower_components/jquery/dist/jquery.min.js')}}"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>


  <!-- <link rel="stylesheet" href="{{url('dashboard_admin_panel/bootstrap/css/bootstrap-rtl.min.css')}}">

  <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css1/AdminLTE-rtl.min.css')}}">

  <link rel="stylesheet" href="{{url('dashboard_admin_panel/dist/css1/skins/_all-skins-rtl.min.css')}}"> -->



   





  

</head>

<body class="hold-transition skin-purple sidebar-mini" dir={{$dir}} >
<div class="wrapper">