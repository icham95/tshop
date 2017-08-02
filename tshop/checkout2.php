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
                        // if( isset($_POST['cekout1']) ){
                        //     $nama_lengkap = $_POST['nama_lengkap'];
                        //     $email = $_POST['email'];
                        //     $telepon = $_POST['telepon'];
                        //     $provinsi = $_POST['provinsi'];
                        //     $kabupaten = $_POST['kabupaten'];
                        //     $pos = $_POST['pos'];
                        //     $alamat = $_POST['alamat'];
                        //     $id_trans = $_POST['id_trans'];

                        //     $query = 
                        //     "
                        //         UPDATE tbl_transaksi
                        //         SET
                        //         nama_pembeli = '$nama_lengkap' ,
                        //         email_pembeli = '$email' ,
                        //         telepon = '$telepon' ,
                        //         id_provinsi = '$provinsi' ,
                        //         id_kota = '$kabupaten' ,
                        //         kode_pos = '$pos' ,
                        //         alamat_lengkap = '$alamat'
                        //         WHERE id_user = '$id_user' AND id_transaksi ='$id_trans' ;
                        //     ";

                        //     $proses = mysqli_query($conn,$query);

                        //     if( !$proses ){
                        //         header("location:basket.php");
                        //     }

                        // }

                    ?>
                </div>

                <div class="col-md-9" id="checkout">

                    <div class="box">
                        <form method="post" action="checkout3.php">
                            <h1>Metode Pengiriman</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="checkout1.php"><i class="fa fa-map-marker"></i><br>Alamat</a>
                                </li>
                                <li class="active"><a href="#"><i class="fa fa-truck"></i><br>Pengiriman</a>
                                </li>
                                <li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Pembayaran</a>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="box shipping-method">

                                            <h4>JNE REGULER</h4>

                                            <p>Reguler : 3 - 7 hari.</p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="delivery" value="JNE_REGULER">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="box shipping-method">

                                            <h4>JNE KILAT</h4>

                                            <p>Kilat : 1 - 3 hari</p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="delivery" value="JNE_KILAT">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="box shipping-method">

                                            <h4>SICEPAT KILAT</h4>

                                            <p>1 - 3 hari.</p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="delivery" value="SICEPAT_KILAT">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.content -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Addresses</a>
                                </div>
                                <div class="pull-right">
                                    <input type="hidden" name="id_trans" value="<?=$id_trans?>" >
                                    <button type="submit" name="cekout2" class="btn btn-primary">Continue to Payment Method<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col-md-9 -->

                <div class="col-md-3">

                    <div class="box" id="order-summary">
                        <div class="box-header">
                            <h3>Order summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Order subtotal</td>
                                        <th>$446.00</th>
                                    </tr>
                                    <tr>
                                        <td>Shipping and handling</td>
                                        <th>$10.00</th>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <th>$0.00</th>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <th>$456.00</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
<?php

    include_once('pages/footer.php');    

?>