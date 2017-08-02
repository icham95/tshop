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
                        // if( isset($_POST['cekout2']) ){
                        //     $pengiriman = $_POST['delivery'];
                        //     $id_trans = $_POST['id_trans'];

                        //     $query = 
                        //     "
                        //     UPDATE tbl_transaksi
                        //     SET pengiriman = '$pengiriman'
                        //     WHERE id_user = '$id_user'
                        //     ";
                        //     $proses = mysqli_query($conn,$query);

                        //     if(!$proses){
                        //         header("location:basket.php");
                        //     }
                        // }

                    ?>
                </div>

                <div class="col-md-12" id="checkout">

                    <div class="box">
                        <form method="post" action="customer-orders.php">
                            <h1>Checkout - Payment method</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="checkout1.php"><i class="fa fa-map-marker"></i><br>Alamat</a>
                                </li>
                                <li><a href="checkout2.php"><i class="fa fa-truck"></i><br>Pengiriman</a>
                                </li>
                                <li class="active"><a href="#"><i class="fa fa-money"></i><br>Pembayaran</a>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="box payment-method">

                                            <h4>MANDIRI</h4>

                                            <p>Nomer rekening : 
                                                <br>
                                                HISYAM MAULANA  : 02394832093 <br>
                                                RAKA PRADIKA    : 89324720940 <br>
                                                LUCKY           : 43242332432
                                            </p>

                                            <div class="box-footer text-center">

                                                <input type="radio" name="payment" value="MANDIRI">
                                            </div>
                                        </div>
                                    </div>

                            </div>
                            <!-- /.content -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Shipping method</a>
                                </div>
                                <div class="pull-right">
                                    <input type="hidden" name="id_trans" value="<?=$id_trans?>" >
                                    <button type="submit" name="finish" class="btn btn-primary">Continue to Order review<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
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