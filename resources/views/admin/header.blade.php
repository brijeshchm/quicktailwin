<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">     
    <link href="{{asset('client/images/favicon.png')}}" rel="icon">
	<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>Quick Dials</title>
	 <!-- SCRIPT-ANGULAR-JS -->
    <script src="<?php echo asset('admin/node_modules/angular/angular.min.js') ?>"></script>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo asset('admin/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
	
    <!-- Bootstrap DateTimePicker -->
    <link href="<?php echo asset('vendor/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
	
	<!-- Select2 Core CSS -->
    <link href="<?php echo asset('admin/vendor/select2/css/select2.min.css'); ?>" rel="stylesheet">

	<!-- Select2-Bootstrap CSS -->
    <link href="<?php echo asset('admin/vendor/select2/css/select2-bootstrap.css'); ?>" rel="stylesheet">	
	
    <!-- MetisMenu CSS -->
    <link href="<?php echo asset('admin/vendor/metisMenu/metisMenu.min.css'); ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo asset('admin/vendor/datatables-plugins/dataTables.bootstrap.css'); ?>" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo asset('admin/vendor/datatables-responsive/dataTables.responsive.css'); ?>" rel="stylesheet">	
	
    <!-- Custom CSS -->
    <link href="<?php echo asset('admin/dist/css/sb-admin-2.css'); ?>" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo asset('admin/vendor/morrisjs/morris.css'); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('admin/dist/css/style.css'); ?>" rel="stylesheet">
	
	<!-- jquery-ui(datepicker) -->
	<link href="<?php echo asset('admin/vendor/datepicker/jquery-ui.css'); ?>" rel="stylesheet">

	<!-- SCRIPT-SPINNER -->
	<script data-cfasync="false" src="<?php echo asset('vendor/spinner/spin.min.js'); ?>"></script>
	
  	<link rel="stylesheet" href="{{ asset('admin/vendor/chosen-js/chosen.css') }}">

</head>

<body class="nav-md">
	<!-- SPINNER -->
	<div id="spinnerBkgd"></div>
	<div id="spinnerCntr"></div>
	<!-- SPINNER -->
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('developer/dashboard')}}">Quick Dials</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
          
				@if(Auth::user()->current_user_can('administrator'))
					 				 												
                    @if(Request::segment(2)=='dashboard' || Request::segment(2) =='lead-dashboard')
                        
                        
                    <li class="counsellor-list" style="width:150px">
                        <select class="form-control select2-single counsellor-control"  >
                            <option value="">Select User</option>
                            <?php $getUserList = getUserList(); ?>								
                            
                            @if(isset($getUserList))
                                @foreach($getUserList as $counsellor)
                                    <option value="{{$counsellor->id}}" <?php if(Request::segment(3)==$counsellor->id) { echo "selected"; } ?> >{{$counsellor->first_name}} {{$counsellor->last_name}}</option>
                                @endforeach
                            @endif
                            </select>
                    </li>
                        @endif
                        @endif
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">  
			 
					<?php if(Auth::user()->first_name){ echo Auth::user()->first_name; } ?>
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user"> 
                      <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li> 
                        <li><a href="/developer/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>                    
                </li>                
            </ul>           
        @include('admin.sidebar')		 
        </nav>