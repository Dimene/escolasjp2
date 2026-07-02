 <?php  use App\http\controllers\Admin\configuraceosController;
    $funcao = new configuraceosController();
    $avatar= $funcao->getLogoMarca()->avatar;


 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SGE| @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon-precomposed"   sizes="144x144" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
    <link rel="apple-touch-icon-precomposed"  sizes="144x144" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
    <link rel="apple-touch-icon-precomposed"  rel="icon" type="imagem/gif" sizes="144x144" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
    <link rel="apple-touch-icon-precomposed"  rel="icon" type="imagem/JPG" sizes="144x144" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
  <link rel="apple-touch-icon-precomposed" href="{{ asset('storage/logoMarca/'.$avatar.'')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/Fonte-Famile/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/dist/css/adminlte.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/iCheck/flat/blue.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/morris/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/iCheck/all.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/timepicker/bootstrap-timepicker.min.css')}}">
<link  href="{{ asset('Datatable/css/buttons.dataTables.min.css')}}"></script>
  <link  href="{{ asset('Datatable/css/jquery.dataTables.min.css')}}"></script>

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/plugins/datatables/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('Admin-LTE/fonte-family/fonte-family.css')}}">


  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="{{ asset('Admin-LTE/plugins/Fonte-Famile/css?family=Source+Sans+Pro:300,
  400,400i,700'')}}" rel="stylesheet"> --}}


  @stack('style')
</head>
<style>
body{
font-family: 'Inria Serif', serif;
}
</style>
<body class=" shold-transition sidebar-mini layout-fixed

 layout-navbar-fixed
 layout-footer-fixed layout-top-nav">
<div class="wrapper layout-navbar-fixed   col"  >

  <!-- Navbar -->
  @include('layouts.nav-header')
  <!-- /.navbar -->
</div>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4  sidebar-light-primary ">
    <!-- Brand Logo -->

    <a href="/" class="brand-link">
      <img src="{{ asset('storage/logoMarca/'.$avatar.'')}}" alt=" Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SGFarm&aacute;cia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar no-shadow" style="background-color: #e9ecef">
      <!-- Sidebar user panel (optional) -->

  @include('layouts.sider-menu')
  <!-- /.sidebar-menu -->
</div>
   <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content-wrapper  ">


<div class="container no-shadow ">


@yield('content')
</div>

    </div>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">Linktech.LTD</a>.</strong>
   Todo Direitos Reservado
    <div class="float-right d-none d-sm-inline-block">
      <b>Vers&atilde;o</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('Admin-LTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('Admin-LTE/plugins/Fonte-Famile/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('Admin-LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('Admin-LTE/plugins/Fonte-Famile/raphael-min.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/morris/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('Admin-LTE/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('Admin-LTE/plugins/knob/jquery.knob.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('Admin-LTE/plugins/Fonte-Famile/moment.min.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('Admin-LTE/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('Admin-LTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ asset('Admin-LTE/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('Admin-LTE/plugins/fastclick/fastclick.js')}}"></script>

<!-- iCheck -->
<script src="{{ asset('Admin-LTE/plugins/iCheck/icheck.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('Admin-LTE/dist/js/adminlte.js')}}"></script>
<script src="{{ asset('Admin-LTE/dist/js/app.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('Admin-LTE/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- date-range-picker -->
<script src="{{ asset('Admin-LTE/plugins/Fonte-Famile/moment.min2.js')}}"></script>
<script src="{{ asset('Admin-LTE/dplugins/daterangepicker/daterangepicker.js')}}"></script>

<script src="{{ asset('Admin-LTE/plugins/select2/select2.full.min.js')}}"></script>
<!-- InputMask -->


<script src="{{ asset('Admin-LTE/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/pdfobject/pdfobject.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('Admin-LTE/plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js')}}"></script>

<!-- date-range-picker -->
<script src="{{ asset('Admin-LTE/dist/js/demo.js')}}"></script>




@stack('script')



@stack('scripts')


</body>
</html>
