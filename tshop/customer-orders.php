<?php
    
    include_once('pages/header.php');

?>
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <!-- info tambahan here -->
                    <?php
                        if($login===0){
                            echo '<script> location.replace("index.php"); </script>';
                        }

                        

                        // if( isset( $_POST['finish'] ) ){

                        //     $qjum = 
                        //     "
                        //     SELECT SUM(harga) AS total
                        //     FROM tbl_barang
                        //     INNER JOIN tbl_transaksi
                        //     ON tbl_transaksi.id_barang = tbl_barang.id_barang
                        //     WHERE id_user = '$id_user'
                        //     ";
                        //     $prosesJum = mysqli_query($conn,$qjum);
                        //     $harga = 0;
                        //     while( $data = mysqli_fetch_assoc($prosesJum) ){
                        //         $harga = $harga + $data['total'];
                        //     }

                        //     if( isset($_POST['payment']) ){
                        //         $pembayaran = $_POST['payment'];
                        //     }else{
                        //         $pembayaran = 'belum di isi';
                        //     }

                        //     $query = 
                        //     "
                        //     UPDATE tbl_transaksi
                        //     SET pembayaran = '$pembayaran' , id_status = '2'
                        //     WHERE id_user = '$id_user'
                        //     ";

                        //     $proses = mysqli_query($conn,$query);

                        //     if($proses){
                        //         success_snap('Order telah diterima !');
                        //     }
                        // }
                    ?>

                </div>


                <div class="col-md-12" id="customer-orders">
                    <div class="box">
                        <h1>Order saya</h1>

                        <p class="lead">Kumpulan order yang kamu beli.</p>
                        <p class="text-muted">Jika kamu punya masalah , silahkan kunjungi <a href="contact.php">contact us</a>, customer service kami akan melayani anda dengan sebaik-baik nya.</p>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Nama barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>harga</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Konfirmasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                $query = 
                                "
                                SELECT * FROM tbl_transaksi 
                                INNER JOIN tbl_barang
                                INNER JOIN status_pembayaran
                                INNER JOIN tbl_provinsi
                                INNER JOIN tbl_kota
                                ON tbl_transaksi.id_barang = tbl_barang.id_barang
                                AND tbl_transaksi.id_status = status_pembayaran.id_status
                                AND tbl_transaksi.id_provinsi = tbl_provinsi.id_provinsi
                                AND tbl_transaksi.id_kota = tbl_kota.id_kota
                                WHERE id_user = '$id_user' AND tbl_transaksi.id_status > 1 ORDER BY tanggal_input DESC";
                                $proses = mysqli_query( $conn,$query );
                                while( $data = mysqli_fetch_assoc($proses) ){
                                ?>
                                    <tr>
                                        <td>#<?=$data['id_transaksi']?></td>
                                        <td><?=$data['nama_barang']?></td>
                                        <td><?=$data['jumlah_beli']?></td>
                                        <td><?=$data['tanggal_input']?></td>
                                        <td><?=$data['harga']?></td>
                                        <td>
                                            <?=$data['nama_provinsi']?> <br>   
                                            <?=$data['nama_kota']?> <br>   
                                            <?=$data['alamat_lengkap']?> <br>   
                                            <?=$data['kode_pos']?>   
                                        </td>
                                        <td><span class="label label-info"><?=$data['nama_status']?></span>
                                        </td>
                                        <td>
                                            <?php
                                                if( $data['konfirmasi'] == 1 ){
                                            ?>


                                            <?php
                                                }else if( $data['konfirmasi'] == 0 ){
                                            ?>
                                                <a class="btn btn-primary" href="konfirmasi.php?id=<?= $data['id_transaksi'] ?>" title=""> Konfirmasi </a>

                                            <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php
    
    include_once('pages/footer.php');

?>