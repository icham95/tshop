<?php
	include_once('pages/header.php');

?>
	
	<div class="container-fluid-full">
			<div class="row-fluid">
				
		<?php
			include_once('pages/left-bar.php');
		?>
			
			<!-- start: Content -->
			<div id="content" class="span10">
				
				<div class="row-fluid">	

					<?php

						$query = 
						"
							SELECT COUNT(*) AS jumlahUser FROM tbl_user
						";
						$proses = mysqli_query($conn,$query);
						$data = mysqli_fetch_assoc( $proses );

					?>

					<a class="quick-button metro yellow span3">
						<i class="icon-group"></i>
						<p>Jumlah user</p>
						<span class="badge"><?= $data['jumlahUser'] ?></span>
					</a>

					<?php

						$query = 
						"
							SELECT COUNT(*) AS jumlahBarang FROM tbl_barang
						";
						$proses = mysqli_query($conn,$query);
						$data = mysqli_fetch_assoc( $proses );

					?>

					<a href="management-barang.php" class="quick-button metro blue span3">
						<i class="icon-shopping-cart"></i>
						<p>Jumlah barang</p>
						<span class="badge"><?= $data['jumlahBarang'] ?></span>
					</a>

					<?php

						$query = 
						"
							SELECT COUNT(*) AS jumlahPembelian FROM tbl_transaksi
						";
						$proses = mysqli_query($conn,$query);
						$data = mysqli_fetch_assoc( $proses );

					?>

					<a href="pembelian.php" class="quick-button metro green span3">
						<i class="icon-comments"></i>
						<p>Jumlah Pembelian</p>
						<span class="badge"><?= $data['jumlahPembelian'] ?></span>
					</a>
				</div>
		
				<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	</div> <!-- end div container-fluid-full -->
	
	<div class="clearfix"></div>
	
<?php
	
	include_once('pages/footer.php');

?>