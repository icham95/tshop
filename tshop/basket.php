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
                        $user_query = "select * from tbl_user 
                        inner join tbl_kota on tbl_user.id_kota = tbl_kota.id_kota
                        where id_user = '". $_SESSION['id_user']."'";
                        // $proses_user_query = db_select('tbl_user', 'id_user', $_SESSION['id_user']);
                        $proses_user_query = db_run($user_query);
                        $asd = mysqli_fetch_object($proses_user_query);
                        var_dump($asd);
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
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="1">Rp.
                                            <?php 
                                                if ($total > 1000000) {
                                                    echo 'anda mendapaktan freeshipping ';
                                                } else {
                                                    
                                                }
                                                echo 'Rp.' .$total;
                                            ?>
                                            
                                            </th>
                                        </tr>
                                        <form action="" id="form_alamat">


                                        </form>
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

                                    <select id="hu_kurir">
                                        <option value="jne"> JNE </option>
                                    </select>

                                    <button id="hu_btn_kurir" onclick="hu_kurir"> OK </button>

                                </div>
                                <div class="pull-right">
                                    <input type="hidden" name="id_trans" value="<?=$array?>" >

                                    <button type="submit" name="bnext" onclick="nextAlamat(event)" class="btn btn-primary"> Selanjutnya, alamat pengiriman <i class="fa fa-chevron-right"></i>
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
        <?php include_once('pages/modals/alamat.php');?>
        <?php include_once('pages/modals/kurir.php');?>

        <script>

            function nextAlamat(e) {
                e.preventDefault();
                let huModalAlamat = document.getElementById('hu_modal_alamat');
                huModalAlamat.style.display = 'block';
            }

            // let header = new Headers();
            // header.append('key', '57293e54bd156185722653e7648c2a69');
            // let myBody['API-Key'] = 'e71cc3eedf38ffb30eb262707e26a041';
            let formData = new FormData();
            formData.append('API-Key', 'e71cc3eedf38ffb30eb262707e26a041');
            // formData.append('from', 'jakarta');
            // formData.append('to', 'bogor');
            // formData.append('weight', '1800');
            formData.append('courier', 'jne');
            formData.append('format', 'json');
            // city
            // formData.append('query', 'bog');
            // formData.append('type', 'origin');
            // let url = 'http://api.ongkir.info/cost/find';
            let url = 'http://api.ongkir.info/city/list';
            fetch(url, {
                method: 'POST',
                header: new Headers({
                    'content': 'x-www-form-urlencoded'
                }),
                // header: header,
                mode: 'no-cors',
                // body: {
                //     'API-Key':'e71cc3eedf38ffb30eb262707e26a041'
                // }
                body: formData
            })
            .then(resp => console.log(resp.text()))
            .catch(err => {
                console.log(err);
            });

            function hu_kurir(event){
                let formData = new FormData();
                formData.append('API-Key', 'e71cc3eedf38ffb30eb262707e26a041');
                formData.append('from', 'bogor');
                formData.append('to', '<?= $asd->nama_kota ?>');
                formData.append('courier', 'jne');
                formData.append('format', 'json');
                let url = 'http://api.ongkir.info/city/list';
                fetch(url, {
                    method: 'POST',
                    header: new Headers({
                        'content': 'x-www-form-urlencoded'
                    }),
                    // header: header,
                    mode: 'no-cors',
                    // body: {
                    //     'API-Key':'e71cc3eedf38ffb30eb262707e26a041'
                    // }
                    body: formData
                })
                .then(resp => console.log(resp.text()))
                .catch(err => {
                    console.log(err);
                });

            }
            
        </script>
<?php

    include_once('pages/footer.php');

?>