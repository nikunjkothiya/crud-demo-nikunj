<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laravel Crud</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">


</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper" id="app">

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LYT</span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{asset('images/avatar5.png')}}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{Auth::user()->name}}</p>
            <!-- Status -->
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">HEADER</li>

          <li class="active"><a href="{{url('userrecords')}}"><i class="fa fa-microchip"></i> <span>User records</span></a></li>

          <li class="">

            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
              <i class="fa fa-power-off text-red"></i> <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>

        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


      <!-- Main content -->
      <section class="content container-fluid">
        @yield('content')

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2021 <a href="#">Company</a>.</strong> All rights reserved.
    </footer>
  </div>


  <script src="{{asset('js/app.js')}}"></script>

  <script>
    $('#edit').on('show.bs.modal', function(event) {

      var button = $(event.relatedTarget);
      var user_id = button.attr('data-id');
      var modal = $(this);
      var url = button.attr('data-url')

      // modal.find('.modal-body #user_id').val(user_id);
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: url,
        dataType: 'JSON',
        data: {
          id: user_id
        },
        success: function(data) {
          console.log(data.detail.avatar);
          modal.find('.modal-body #old_user_id').val(data.detail.id);
          modal.find('.modal-body #name').val(data.detail.name);
          modal.find('.modal-body #email').val(data.detail.email);
          modal.find('.modal-body #date_joining').val(data.detail.date_joining);
          modal.find('.modal-body #avatar_old').val(data.detail.avatar);
          modal.find('.modal-body #avatar').removeAttr('required');
          modal.find('.modal-body #showImg').html('<img width="100px" height="100px" style="border-radius:50%;" src="' + data.detail.avatar + '" />');
          if (data.detail.date_leaving != '') {
            modal.find('.modal-body #date_leaving').val(data.detail.date_leaving);
          } else {
            modal.find('.modal-body #checkbox2').prop('checked', true);
          }
        }
      });
    });


    $('#delete').on('show.bs.modal', function(event) {

      var button = $(event.relatedTarget);
      var user_id = button.attr('data-id');
      var modal = $(this);

      modal.find('.modal-body #delete_user_id').val(user_id);
    })
  </script>

</body>

</html>