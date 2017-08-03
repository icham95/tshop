<?php
    include_once('pages/header.php');
    
?>


    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <?php
    
                        if($login===0){
                            echo '<script> location.replace("index.php"); </script>';
                        }


                        if( isset($_POST['bfinish']) ){

                            $id_transaksis = $_SESSION['id_transaksi'];
                            $jumlah_id_transaksis = sizeof( $id_transaksis );

                            foreach ($id_transaksis as $key => $value) {
                                
                                $query = 
                                "
                                    UPDATE tbl_transaksi SET
                                    id_status = '2' 
                                    WHERE id_transaksi = '". $value['id_transaksi'] ."';
                                ";

                                if( mysqli_query($conn,$query) ){
                                    unset($_SESSION['id_transaksi']);
                                    echo '<script> location.replace("customer-orders.php"); </script>';
                                }

                            }

                        }


                        if( isset( $_POST['update_barang'] ) ){

                            if( is_array($_POST['jumlah_beli']) ){

                                // array baru
                                $new_ijum = array();

                                // pemasukan data ke array baru
                                $ijumbel = $_POST['jumlah_beli'];
                                $no = 0;
                                foreach ($ijumbel as $key) {
                                    
                                    $new_ijum[$no]['jumbel'] = $key;
                                    $no++;

                                }

                                $sid_trans = $_SESSION['id_transaksi'];
                                $no =0;
                                foreach ($sid_trans as $key) {
                                    $new_ijum[$no]['id_transaksi'] = $key['id_transaksi'];
                                    $no++;
                                }
                                // end pemasukan data ke array baru

                                // for validation for the future 
                                // end validation

                                // update database
                                foreach ($new_ijum as $key) {
                                    
                                    $jumbel = $key['jumbel'];
                                    $id_transaksi = $key['id_transaksi'];

                                    $qjumbel = 
                                    "
                                        UPDATE tbl_transaksi SET
                                        jumlah_beli = '$jumbel'
                                        WHERE id_transaksi = '$id_transaksi';
                                    ";

                                    $proses_qjumbel = mysqli_query($conn,$qjumbel);

                                }

                            }else{
                                echo '<script> location.replace("index.php"); </script>';
                            }
                            

                        }

                        if( isset( $_GET['delete'] ) ){

                            // cek apakah orderan punya si empunya
                            $query = "SELECT * FROM tbl_transaksi WHERE id_user = '$id_user' AND id_transaksi = '".$_GET['delete']."'";
                            $proses= mysqli_query($conn,$query);
                            $hitung = mysqli_num_rows( $proses );
                            if( $hitung > 0 ){
                                // proses delete
                                $query = "DELETE FROM tbl_transaksi WHERE id_transaksi = '".$_GET['delete']."'";
                                $proses = mysqli_query( $conn,$query );
                                if( $proses ){
                                    success_snap("Berhasil menghapus order !");
                                }else{
                                    error_snap("Gagal menghapus order !");
                                }

                            }else{
                                error_snap( "Gagal menghapus order !" );
                            }

                        }

                        if( isset($_GET['order']) && $_SESSION['_token_detail'] == $_GET['token'] ){

                            $id_barang_order = $_GET['order'];

                            $cek_jum_beli = "SELECT * FROM tbl_transaksi WHERE id_barang = '$id_barang_order' AND id_user = '$id_user' AND id_status < 2 ";
                            $proses_cjb = mysqli_query($conn,$cek_jum_beli);
                            $hitung_cjb = mysqli_num_rows( $proses_cjb );
                            if( $hitung_cjb > 0 ){

                                $query = 
                                "

                                    UPDATE tbl_transaksi
                                    SET jumlah_beli = jumlah_beli + 1
                                    WHERE id_barang = '$id_barang_order' AND id_user = '$id_user';

                                ";

                            }else{

                                $query_iu = "SELECT * FROM tbl_user WHERE id_user = '$id_user' ";
                                $proses_iu = mysqli_query($conn,$query_iu);
                                $data_iu = mysqli_fetch_assoc( $proses_iu );
                                $iu_provinsi = $data_iu['id_provinsi'];
                                $iu_kota = $data_iu['id_kota'];
                                $iu_alamat = $data_iu['alamat'];
                                $iu_pos = $data_iu['kode_pos'];

                                $query = "
                                            INSERT INTO tbl_transaksi 
                                            (id_barang,id_user,id_status,jumlah_beli,id_provinsi,id_kota,alamat_lengkap,kode_pos) 
                                            VALUES 
                                            ('$id_barang_order','$id_user','1','1','$iu_provinsi','$iu_kota','$iu_alamat','$iu_pos') ";

                            }

                            if ( db_run($query) ){
                                success_snap("Order di tambahkan !");
                            }else{
                                error_snap("Gagal menambahkan order !");
                            }

                            $_SESSION['_token_detail'] = generate_token();

                        } // end if isset order

                        $query = 
                            "
                                SELECT * FROM tbl_transaksi
                                INNER JOIN tbl_barang
                                INNER JOIN tbl_provinsi
                                INNER JOIN tbl_kota
                                ON tbl_transaksi.id_barang = tbl_barang.id_barang
                                AND tbl_transaksi.id_provinsi = tbl_provinsi.id_provinsi
                                AND tbl_transaksi.id_kota = tbl_kota.id_kota
                                WHERE tbl_transaksi.id_user = '".$id_user."' AND id_status = '1' AND jumlah_beli > 0
                                ORDER BY id_transaksi DESC;
                            ";

                        $proses = db_run($query);

                        // masukin data ke array 
                        $array = array();
                    
                        $jumlah = mysqli_num_rows($proses);

                    ?>
                </div>

                <div class="col-md-12" id="basket">

                    <div class="box">

                        <form method="post" action="">

                            <h1>Keranjang belanja</h1>
                            <p class="text-muted">Kamu mempunyai <?=$jumlah?> produk di dalam keranjang.</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Produk</th>
                                            <th>Jumlah</th>
                                            <th colspan="" >Harga</th>
                                            <th colspan="" >Alamat pengiriman</th>
                                            <th colspan="" >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $total = 0;
                                        while( $data = mysqli_fetch_assoc($proses) ){
                                            
                                            $total_per_barang = $data['jumlah_beli'] * $data['harga'];
                                            $total = $total + $total_per_barang;
                                            $id_trans = $data['id_transaksi'];
                                            $array[]['id_transaksi'] = $id_trans;
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="detail.php?produk=<?=$data['id_barang']?>">
                                                    <img src="../admin/img/barang/<?=$data['gambar']?>" alt="White Blouse Armani">
                                                </a>
                                            </td>
                                            <td><a href="detail.php?produk=<?=$data['id_barang']?>"><?= $data['nama_barang']?></a>
                                            </td>
                                            <td class="">
                                                <input type="number" name="jumlah_beli[]" value="<?= $data['jumlah_beli'] ?>">
                                            </td>
                                            <td>Rp.<?= $total_per_barang ?></td>
                                            <td>
                                                <?= $data['nama_provinsi'] ?> <br>
                                                <?= $data['nama_kota'] ?> <br>
                                                <?= $data['alamat_lengkap'] ?> <br>
                                                <?= $data['kode_pos'] ?>
                                            </td>
                                            <td align="">

                                                <a class="btn btn-danger" href="basket.php?delete=<?=$data['id_transaksi']?>">
                                                    Hapus
                                                    <i class="fa fa-trash-o"></i>
                                                </a>

                                                <a href="alamat.php?ganti=<?= $data['id_transaksi'] ?>" class="btn btn-warning">
                                                    <i class="fa fa-home"></i>            
                                                    Ganti alamat
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="1">Rp.<?=$total?></th>
                                        </tr>
                                    </tfoot>
                                </table>


                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">

                                <?php
                                    $query1 = "SELECT * FROM tbl_transaksi WHERE id_status > 1";
                                    $proses1 = mysqli_query($conn,$query);
                                    $hitung1 = mysqli_num_rows($proses1);

                                    if($hitung1 > 0){
                                ?>
                                <div class="pull-left">

                                    <button type="submit" name="update_barang" class="btn btn-info btn-block">    
                                        Update jumlah barang
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    <input type="hidden" name="token" value="<?= $_token ?>">

                                </div>
                                <div class="pull-right">
                                    <input type="hidden" name="id_trans" value="<?=$array?>" >

                                    <button type="submit" name="bfinish" class="btn btn-primary">Beli <i class="fa fa-chevron-right"></i>
                                    </button>
                                    
                                </div>
                                <?php
                                    }

                                    $_SESSION['id_transaksi'] = $array;
                                ?>
                            </div>

                        </form>

                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col-md-9 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
<?php

    include_once('pages/footer.php');

?>