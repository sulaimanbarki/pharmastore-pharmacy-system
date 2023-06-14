
@include('admin.inc.header')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('admin.inc.mainHeader')
  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.inc.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <h1>
        @yield('sideMenuTitle')
        <small></small>
      </h1>
      <ol class="breadcrumb">

        <li class="active"> @yield('pageTitle')</li>
      </ol>
    </section>
    
    @yield('bodyContent')

    <!-- Main content -->
   
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('admin.inc.footer')


  