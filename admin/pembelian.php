<?php
	
	include_once('pages/header.php');

?>
	
	<div class="container-fluid-full">
		<div class="row-fluid">
				
		<?php
			include_once('pages/left-bar.php');
		?>
			
			<!-- start: Content -->
			<div id="content" class="span12">

				<?php

					if( isset( $_GET['x'] ) AND $_GET['x'] == 1 ){

						//prepare
						$id_transaksi = $_GET['id_trans'];
						$id_status = $_GET['status'];
						$id_barang = $_GET['id_barang'];
						$jumbel = $_GET['jumbel'];

						// cek apakah status ada di tbl_status
						$query_cek = "SELECT * FROM status_pembayaran WHERE id_status = '$id_status' ";
						$proses_cek = mysqli_query( $conn,$query_cek );
						$hitung_cek = mysqli_num_rows( $proses_cek );

						if( $hitung_cek < 1 ){
							error_snap("Kamu belum pilih status !");
						}else{

							if( $id_status > 3 ){
								$query1 = "UPDATE tbl_barang SET stok = stok - $jumbel WHERE id_barang = '$id_barang' ";
								mysqli_query( $conn,$query1 );
							}else{
								$query1 = "UPDATE tbl_transaksi SET konfirmasi = '0' WHERE id_transaksi = '$id_transaksi' ";
								mysqli_query( $conn,$query1 );
							}

							$query = 
							"
								UPDATE tbl_transaksi SET 
								id_status = '$id_status'
								WHERE id_transaksi = '$id_transaksi' 
							";

							if( mysqli_query( $conn,$query ) ){
								success_snap( "Status Berhasil di ganti !" );
							}else{
								error_snap("Gagal ganti status !");
							}
						}

					} 
				?>

				<div class="row-fluid" style="margin-top: 1%;">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white user"></i><span class="break"></span>Barang</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content table-responsive">
							<table align="center" class="table table-striped table-bordered bootstrap-datatable datatable">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama pembeli</th>
										<th>Nama pentransfer</th>
										<th>Tgl transfer</th>
										<th>Nama barang</th>
										<th>No Telepon</th>
										<th>Alamat</th>
										<th>Tanggal</th>
										<th>status</th>
										<th>Action</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
							<?php
								$query = '
											SELECT * FROM tbl_transaksi
											INNER JOIN tbl_barang
											INNER JOIN tbl_user
											INNER JOIN status_pembayaran
											INNER JOIN tbl_provinsi
											INNER JOIN tbl_kota
											ON tbl_transaksi.id_barang = tbl_barang.id_barang
											AND tbl_transaksi.id_user = tbl_user.id_user
											AND tbl_transaksi.id_status = status_pembayaran.id_status
											AND tbl_user.id_provinsi = tbl_provinsi.id_provinsi
											AND tbl_user.id_kota = tbl_kota.id_kota
											WHERE tbl_transaksi.id_status > 2;
										';
								$proses = db_run($query);
								$no = 1;
								$noStatus = 0;
								while( $data = mysqli_fetch_assoc($proses) ){
							?> 

								<tr>
									<td><?=$no++?></td>
									<td><?=$data['nama_user']?></td>
									<td><?=$data['pentransfer']?></td>
									<td><?=$data['tanggal_transfer']?></td>
									<td><?=$data['nama_barang']?></td>
									<td><?=$data['no_hp']?></td>
									<td>
										<?=$data['nama_provinsi']?>,
										<?=$data['nama_kota']?>,
										<?=$data['alamat']?>
									</td>
									<td><?=$data['tanggal_input']?></td>
									<td>
										<!-- <span class="label" style="background-color: #35C367;" >  -->
										<?=$data['nama_status']?> 
										<!-- </span> -->
										<br>
										<span class="label label-info"> 000<?= $data['id_status'] ?> </span>
									</td>
									
									<td>
										<form action="" method="GET">
										<?php
											$noStatus = $noStatus + 1;
											$inputNameStatus = "status".$noStatus;
										?>
											<select name="status" style="width: 150px;">
												<option> -- pilih status -- </option>}
										<?php
											$query_status = "SELECT * FROM status_pembayaran";
											$proses_status = mysqli_query($conn,$query_status);
											while( $data_status = mysqli_fetch_assoc($proses_status) ){
										?>
											
												<option value="<?=$data_status['id_status']?>"> <?=$data_status['nama_status']?> </option>
										<?php
											}
										?>
											</select>
											
									</td>
									<td>
										<?php
										?>
										<input type="hidden" name="x" value="1">
										<input type="hidden" name="id_trans" value="<?=$data['id_transaksi']?>">
										<input type="hidden" name="id_barang" value="<?=$data['id_barang']?>">
										<input type="hidden" name="jumbel" value="<?=$data['jumlah_beli']?>">
										<button name="b<?=$inputNameStatus?>" class="btn btn-primary" >
											OK                                           
										</button>
									</td>
									</form>
								</tr>
								


							<?php } ?>       
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
	
				<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	</div> <!-- end div container-fluid-full -->

	<div class="clearfix"></div>
	
<?php
	
	include_once('pages/footer.php');

?>