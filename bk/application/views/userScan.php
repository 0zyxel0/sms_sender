<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->

    <link href="<?php echo base_url(); ?>ui/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>ui/css/sb-admin-2.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>ui/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url(); ?>ui/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>ui/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>ui/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>ui/js/sb-admin-2.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="wrapper">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">Tapper</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            
            <!-- /.navbar-static-side -->
        </nav>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
             
                    <div class="row">
            			<div class="col-md" style="text-align:center; margin-top:10%;;">
            				<img src="<?php echo base_url(); ?>ui/img/stock.png" width="300" height="300">
                        </div>       
                    </div>
        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Number</th>
                                            <th>111250</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td>Mark Man</td>
                                        </tr>
                                        <tr>
                                            <td>College</td>
                                            <td>CCS</td>
                                        </tr>
                                        <tr>
                                          <td>Time Stamp</td>
                                          <td>2:00 pm</td>
                                        </tr>
                                    </tbody>
                                </table>
                          
                            <!-- /.table-responsive -->
            </div>
                        <p>
                        	<button type="button" class="btn btn-primary btn-lg btn-block">button</button>
      </p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
