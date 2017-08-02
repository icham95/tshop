<?php

    include_once('pages/header.php');

    if($login===0){
        echo '<script> location.replace("index.php"); </script>';
    }

?>
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <!-- info tambahan here -->

                    <?php

                        if( isset( $_GET['ganti'] ) ){

                            $id_transaksi = $_GET['ganti'];

                             //cek apakah benar kepemilikan id_transaksi dengan si user
                            $query_cek = "
                                SELECT * FROM tbl_transaksi 
                                WHERE id_transaksi = '$id_transaksi' 
                                AND id_user = '$id_user'; ";
                            $proses_cek = mysqli_query($conn,$query_cek);
                            $hitung_cek = mysqli_num_rows( $proses_cek );

                            if( $hitung_cek < 1 ){
                                echo '<script> location.replace("index.php"); </script>';
                            }

                        }


                        if( isset($_POST['balamat']) ){
     
                            if( $hitung_cek < 1 ){
                                echo '<script> location.replace("index.php"); </script>';
                            }else{

                                $error = 0;
                                // validation here
                                if( empty( $_POST['nama_lengkap'] ) ){
                                    error_snap( "Nama lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['email'] ) ){
                                    error_snap( "Email lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['telepon'] ) ){
                                    error_snap( "Telepon lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['provinsi'] ) ){
                                    error_snap( "Provinsi lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['kabupaten'] ) ){
                                    error_snap( "Kabupaten lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['pos'] ) ){
                                    error_snap( "POS lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( empty( $_POST['alamat'] ) ){
                                    error_snap( "Alamat lengkap masih kosong !" );
                                    $error += 1;
                                }

                                if( $error > 0 ){
                                    error_snap(" Gagal ganti alamat ! ");
                                }else{

                                    // prepare data
                                    $nama_lengkap = $_POST['nama_lengkap'];
                                    $email = $_POST['email'];
                                    $telepon = $_POST['telepon'];
                                    $provinsi = $_POST['provinsi'];
                                    $kabupaten = $_POST['kabupaten'];
                                    $pos = $_POST['pos'];
                                    $alamat = $_POST['alamat'];

                                    $query = 
                                    "
                                        UPDATE tbl_transaksi SET 
                                        nama_pembeli    = '$nama_lengkap' ,
                                        email_pembeli   = '$email' , 
                                        telepon         = '$telepon' ,
                                        id_provinsi     = '$provinsi' ,
                                        id_kota         = '$kabupaten' ,
                                        alamat_lengkap  = '$alamat' ,
                                        kode_pos        = '$pos'
                                        WHERE id_transaksi = '$id_transaksi' AND id_user = '$id_user';
                                    ";

                                    $proses = mysqli_query($conn,$query);
                                    if( !$proses ){
                                        error_snap("Kesalah sistem ! gagal ganti alamat !");
                                    }else{
                                        echo '<script> location.replace("basket.php"); </script>';
                                    }

                                }

                            }

                        }

                    ?>

                </div>

                <div class="col-md-12" id="checkout">

                    <div class="box">
                        <form method="post" action="">
                            <h1>Alamat Pengiriman</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Alamat</a>
                                </li>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="firstname">Nama lengkap penerima</label>
                                            <input type="text" name="nama_lengkap" class="form-control" id="firstname">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email penerima</label>
                                            <input type="text" name="email" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telepon">Telepon penerima</label>
                                            <input type="text" name="telepon" class="form-control" id="telepon">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="provinsi">Provinsi</label>
                                            <select name="provinsi" class="form-control" id="provinsi">
                                            <?php
                                                $query = db_select("tbl_provinsi");
                                                $proses = db_run($query);
                                                while( $data = mysqli_fetch_assoc($proses) ){
                                            ?>
                                                <option value="<?=$data['id_provinsi']?>" ><?=strtoupper($data['nama_provinsi'])?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="kabupate">Kabupaten</label>
                                            <select name="kabupaten" class="form-control" id="kabupaten">
                                            <?php
                                                $query = db_select("tbl_kota");
                                                $proses = db_run($query);
                                                while( $data = mysqli_fetch_assoc($proses) ){
                                            ?>
                                                <option value="<?=$data['id_kota']?>" > 
                                                    <?=strtoupper($data['nama_kota'])?>
                                                </option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="state">Kode POS</label>
                                            <input type="text" name="pos" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <label for="alamat"> Alamat </label>
                                        <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                    </div>

                                </div>
                                <!-- /.row -->
                            </div>

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>
                                        Batal
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" name="balamat" class="btn btn-primary">
                                        Ganti alamat<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
<?php

    include_once('pages/footer.php');

?>