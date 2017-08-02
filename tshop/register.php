<?php
    include_once('pages/header.php');
?>  

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <!-- info apapaun -->
                    <?php

                        if( isset($_POST['submit_login']) && $_POST['submit_login'] == 'submit_login' ){
                            

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

                            $query = "SELECT * FROM tbl_user WHERE email = '".$_POST['email_login']."' AND password = '".$_POST['password_login']."';";
                            $proses = mysqli_query($conn,$query);
                            $hitung_login = mysqli_num_rows($proses);

                            if( $hitung_login < 1 ){
                                $error = 1;
                                error_snap("Email dan password tidak cocok !");
                            }

                            if( $error == 1 ){
                                error_snap(" Gagal Login ! ");
                            }else{
                                $data = mysqli_fetch_assoc( $proses );
                                $_SESSION['id_user'] = $data['id_user'];
                                $_SESSION['nama_user'] = $data['nama_user'];
                                echo '<script> location.replace("index.php"); </script>';
                            }

                        }

                        // submit register
                        if( isset($_POST['bregister']) && $_POST['bregister'] == 'register_submit' ){

                            // validation here

                            $error = 0;
                            $ket = '';
                            if( empty($_POST['nama']) ){
                                $error = 1;
                            }else if( empty($_POST['username']) ){
                                $error = 1;
                            }else if( empty($_POST['password']) ){
                                $error = 1;
                            }else if( empty($_POST['email']) ){
                                $error = 1;
                            }else if( empty($_POST['kontak']) ){
                                $error = 1;
                            }else if( empty($_POST['jenis_kelamin']) ){
                                $error = 1;
                            }else if( empty($_POST['tgl_lahir']) ){
                                $error = 1;
                            }else if( empty($_POST['negara']) ){
                                $error = 1;
                            }else if( empty($_POST['provinsi']) ){
                                $error = 1;
                            }else if( empty($_POST['kota']) ){
                                $error = 1;
                            }else if( empty($_POST['alamat']) ){
                                $error = 1;
                            }

                            if( empty($_POST['username']) ){
                                error_snap("Username masih kosong !");
                            }

                            if( empty($_POST['nama']) ){
                                error_snap("Nama masih kosong !");
                            }

                            if( empty($_POST['password']) ){
                                error_snap("Password masih kosong !");
                            }

                            if( empty($_POST['email']) ){
                                error_snap("Email masih kosong !");
                            }

                            if( empty($_POST['kontak']) ){
                                error_snap("Kontak masih kosong !");
                            }

                            if( empty($_POST['jenis_kelamin']) ){
                                error_snap("Jenis Kelamin masih kosong !");
                            }

                            if( empty($_POST['tgl_lahir']) ){
                                error_snap("Tanggal Lahir masih kosong !");
                            }

                            if( empty($_POST['negara']) ){
                                error_snap("Negara masih kosong !");
                            }

                            if( empty($_POST['provinsi']) ){
                                error_snap("Provinsi masih kosong !");
                            }

                            if( empty($_POST['kota']) ){
                                error_snap("kota masih kosong !");
                            }

                            if( empty($_POST['alamat']) ){
                                error_snap("alamat masih kosong !");
                            }

                            $query = db_select('tbl_user','email',$_POST['email']);
                            $run = db_run($query);
                            $hitung_email = mysqli_num_rows($run);

                            if( $hitung_email > 0 ){
                                $error = 1;
                                error_snap("Email telah digunakan !");
                            }

                            $query = db_select('tbl_user','id_user',$_POST['username']);
                            $run = db_run($query);
                            $hitung_username = mysqli_num_rows($run);

                            if( $hitung_username > 0 ){
                                $error = 1;
                                error_snap("Username telah digunakan !");
                            }

                            // end validation



                            // prepare data
                            if( $error == 1 ){

                                error_snap("Pendaftaran Gagal");

                            }else{

                                $username = $_POST['username'];
                                $nama = $_POST['nama'];
                                $password = $_POST['password'];
                                $email = $_POST['email'];
                                $kontak = $_POST['kontak'];
                                $jenis_kelamin = $_POST['jenis_kelamin'];
                                $tgl_lahir = $_POST['tgl_lahir'];
                                $negara = $_POST['negara'];
                                $provinsi = $_POST['provinsi'];
                                $kota = $_POST['kota'];
                                $alamat = $_POST['alamat'];

                                $array = array
                                (
                                    "id_user"   => $username ,
                                    "nama_user" => $nama ,
                                    "password"  => $password ,
                                    "email"     => $email ,
                                    "no_hp"     => $kontak ,
                                    "id_jk"     => $jenis_kelamin ,
                                    "tgl_lahir" => $tgl_lahir ,
                                    "id_negara" => $negara ,
                                    "id_provinsi" => $provinsi ,
                                    "id_kota"   => $kota ,
                                    "alamat"    => $alamat
                                );

                                $query = db_add('tbl_user',$array);
                                $run = db_run($query);
                                if( $run ){
                                    success_snap('Pendaftaran Berhasil');
                                }else{
                                    error_snap('Pendaftaran Gagal !');
                                }
                            }



                            // end prepare data

                        }

                    ?>

                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>New account</h1>

                        <p class="lead">Not our registered customer yet?</p>
                        <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.php">contact us</a>, our customer service center is working for you 24/7.</p>

                        <hr>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="nama" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir">
                            </div>
                            <div class="form-group">
                                <label for="negara">Negara</label>
                                <select name="negara" class="form-control" id="negara">
                                <?php
                                    $query = db_select('tbl_negara');
                                    $run = db_run($query);
                                    while( $data=mysqli_fetch_assoc($run) ){
                                ?>
                                    <option value="<?=$data['id_negara']?>"><?=strtolower($data['nama_negara'])?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="provinsi">provinsi</label>
                                <select name="provinsi" class="form-control" id="provinsi">
                                <?php
                                    $query = db_select('tbl_provinsi');
                                    $run = db_run($query);
                                    while( $data=mysqli_fetch_assoc($run) ){
                                ?>
                                    <option value="<?=$data['id_provinsi']?>"><?=strtolower($data['nama_provinsi'])?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kota">provinsi</label>
                                <select name="kota" class="form-control" id="kota">
                                <?php
                                    $query = db_select('tbl_kota');
                                    $run = db_run($query);
                                    while( $data=mysqli_fetch_assoc($run) ){
                                ?>
                                    <option value="<?=$data['id_kota']?>"><?=strtolower($data['nama_kota'])?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" id="alamat"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="kontak">Kontak</label>
                                <input type="text" name="kontak" class="form-control" id="kontak">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="bregister" value="register_submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>Login</h1>

                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies
                            mi vitae est. Mauris placerat eleifend leo.</p>

                        <hr>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email_login" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password_login" class="form-control" id="password">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="submit_login" value="submit_login" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


<?php

    include_once('pages/footer.php');

?>