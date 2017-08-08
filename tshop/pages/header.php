<?php
    
    session_start();
    include_once('function/conn.php');
    include_once('function/crud.php');
    include_once('function/shop.php');

    if (isset($_GET['search'])) {
        
    }

    $login = 0;
    if( isset( $_SESSION['id_user'] ) AND isset($_SESSION['nama_user']) ){
        $login = 1;

        $id_user = $_SESSION['id_user'];
        $nama_user = $_SESSION['nama_user'];

        $query = "SELECT * FROM tbl_transaksi WHERE id_user = '$id_user' AND id_status='1'";
        $proses = mysqli_query($conn,$query);
        $hitung = mysqli_num_rows($proses);
    }else{
        $nama_user = "";
    }

        if( isset($_POST['blogin']) && $_POST['blogin'] == 'blogin' ){

            // validation here
            $error = 0;
            if( empty($_POST['email_login']) ){
                $error = 1;
            }else if( empty($_POST['password_login']) ){
                $error = 1;
            }

            if( empty( $_POST['email_login'] ) ){
                error_snap("Email login masih kosong !");
            }

            if( empty( $_POST['password_login'] ) ){
                error_snap("Password login masih kosong !");
            }

            if( $error == 1 ){
                error_snap(" Gagal Login ! ");
            }else{

                $query = "SELECT * FROM tbl_user WHERE email = '".$_POST['email_login']."' AND password = '".$_POST['password_login']."';";
                $proses = mysqli_query($conn,$query);
                $hitung_login = mysqli_num_rows($proses);

                if( $hitung_login < 1 ){
                $error = 1;
                error_snap("Email dan password tidak cocok !");
                }else{
                    $data = mysqli_fetch_assoc( $proses );
                    $_SESSION['id_user'] = $data['id_user'];
                    $_SESSION['nama_user'] = $data['nama_user'];
                    echo '<script> location.replace("index.php"); </script>'; 
                }
                
            }

        }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Obaju e-commerce template">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz">
    <meta name="keywords" content="">

    <title>
        Henpon
    </title>

    <meta name="keywords" content="">
    
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="views/css/font-awesome.css" rel="stylesheet">
    <link href="views/css/bootstrap.min.css" rel="stylesheet">
    <link href="views/css/animate.min.css" rel="stylesheet">
    <link href="views/css/owl.carousel.css" rel="stylesheet">
    <link href="views/css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="views/css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="views/css/custom.css" rel="stylesheet">

    <script src="views/js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">

    <style type="text/css" media="screen">
        .alert-error{
            background-color:crimson;
            color:white;
        }
    </style>


</head>

<body>
    <!-- *** TOPBAR ***
 _________________________________________________________ -->
    <div id="top" style="">
        <div class="container">
            <div class="col-md-6 offer" data-animate="fadeInDown">

            </div>
            <div class="col-md-6" data-animate="fadeInDown">
                <ul class="menu">
                    <?php
                        if($login === 1){
                    ?>
                    <li style="color:gold;">Welcome , <?= $nama_user ?> </li>

                    <?php
                        }else{
                    ?>
                    <li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
                    </li>
                    <li><a href="register.php">Register</a>
                    </li>
                    <?php 
                        } 
                    ?>
                    <li><a href="contact.php">Contact</a>
                    </li>
                    <?php
                        if($login===1){
                    ?>
                    <li><a href="logout.php">Logout</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="Login">Customer login</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" name="email_login" class="form-control" id="email-modal" placeholder="email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_login" class="form-control" id="password-modal" placeholder="password">
                            </div>

                            <p class="text-center">
                                <button class="btn btn-primary" name="blogin" value="blogin"><i class="fa fa-sign-in"></i> Log in</button>
                            </p>

                        </form>

                        <p class="text-center text-muted">Not registered yet?</p>
                        <p class="text-center text-muted"><a href="register.php"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- *** TOP BAR END *** -->

    <!-- *** NAVBAR ***
 _________________________________________________________ -->

    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">

                <a class="navbar-brand home" href="index.php" data-animate-hover="bounce">
                    <!-- <span style="font-size: 24px;line-height: 45px;">Henpon</span> -->
                    <img src="views/img/hr.jpg">
                </a>

                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                    <?php
                        if( $login === 1 ){
                    ?>
                    <a class="btn btn-default navbar-toggle" href="basket.php">
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs"><?=$hitung?> items in cart</span>
                    </a>
                    <?php } ?>
                </div>
                
            </div>
            <!--/.navbar-header -->
            <!-- menu asli -->

            <div class="navbar-collapse collapse" id="navigation">

                <ul class="nav navbar-nav navbar-left">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class=""><a href="tracking.php">tracking</a></li>
                    <?php if( $login === 1 ){ ?>
                    <li class=""><a href="customer-orders.php">Cek order</a></li>
                    <?php } ?>
                </ul>

            </div>
            <!--/.nav-collapse -->

            <div class="navbar-buttons">

                <?php
                    if( $login === 1 ){
                ?>

                <div class="navbar-collapse collapse right" id="basket-overview">
                    <a href="basket.php" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?=$hitung?> items in cart</span></a>
                </div>
                <!--/.nav-collapse -->
                <?php } ?>

                <div class="navbar-collapse collapse right" id="search-not-mobile">
                    <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                </div>

            </div>

            <div class="collapse clearfix" id="search">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /#navbar -->

    <!-- *** NAVBAR END *** -->