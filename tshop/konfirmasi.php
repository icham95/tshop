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

            		if( isset( $_GET['id'] ) ){

            			$id_transaksi = $_GET['id'];
            			// validasi id apakah bener si pemiliknya
            			$query_cek = "SELECT * FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi' AND id_user = '$id_user'; ";
            			$proses_cek = mysqli_query($conn,$query_cek);
            			$hitung_cek = mysqli_num_rows( $proses_cek );
            			if( $hitung_cek < 1 ){

            				echo '<script> location.replace("index.php"); </script>';

            			}else{

	            			if( isset( $_POST['bkonfirmasi'] ) ){
	            				
	            				// validation 
	            				$error = 0;
	            				if( empty( $_POST['nama'] ) ){
	            					error_snap(" Nama masih kosong ! ");
	            					$error += 1;
	            				}

	            				if( empty( $_POST['tanggal'] ) ){
	            					error_snap(" Tangga masih kosong ! ");
	            					$error += 1;
	            				}
	            				// end validation

	            				if( $error > 0 ){
	            					error_snap( "Gagal konfirmasi" );
	            				}else{

	            					// prepare data
	            					$nama = $_POST['nama'];
	            					$tanggal = $_POST['tanggal'];
	            					// end prepare data

	            					$query = " UPDATE tbl_transaksi SET pentransfer = '$nama' , tanggal_transfer = '$tanggal' , konfirmasi = '1' , id_status = '3' WHERE id_transaksi = '$id_transaksi' ";
	            					$proses = mysqli_query($conn,$query);
	            					if( $proses ){
	            						echo '<script> location.replace("customer-orders.php"); </script>';
	            					}else{
	            						error_snap("Gagal konfirmasi !");
	            					}

	            				}

	            			}
	            		}

            		}else{
            			echo '<script> location.replace("index.php"); </script>';
            		}

            	?>
            	</div>

                <div class="col-md-12">

                    <div class="box">
                    	<form action="" method="POST">
                    		<div class="form-group col-md-6">
                                <label for="username">Nama yang men transfer</label>
                                <input type="text" name="nama" class="form-control" id="username">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl">Tanggal men transfer</label>
                                <input type="date" name="tanggal" class="form-control datepicker" id="tgl">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="bkonfirmasi" class="btn btn-block btn-primary">
                                	<i class="fa fa-sign-in"></i> 
                                	Konfirmasi
                                </button>
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