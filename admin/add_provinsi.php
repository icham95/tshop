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
					if( isset( $_GET['delete'] ) ){
						$query = db_delete('tbl_provinsi','id_provinsi',$_GET['delete']);
						$proses = db_run($query);

						if($proses){
							success_snap('Berhasil Menghapus provinsi : '.$_GET['delete'].' !');
						}else{
							error_snap('Gagal Menghapus provinsi :'.$_GET['delete'].' !');
						}
					}

					if( isset( $_POST['proses_edit'] ) ){

						$nama_provinsi = $_POST['nama_provinsi'];
						$get_provinsi = $_GET['edit'];

						$query = " UPDATE tbl_provinsi SET
							nama_provinsi = '$nama_provinsi'
							WHERE id_provinsi = '$get_provinsi'
							";

						$proses = mysqli_query($conn,$query);
						if($proses){
							success_snap('Update provinsi '.$_GET['edit'].' berhasil !');
						}else{
							error_snap('Gagal Update provinsi '.$_GET['edit'].' !');
						}

					}

					if( isset( $_POST['proses_add'] ) ){

						// validation
						$error = '';

						if( empty($_POST['nama_provinsi']) ){
							$error .= 1;
							error_snap('Inputan Nama provinsi masih kosong !');
						}

						if( strlen($_POST['nama_provinsi']) > 50 ){
							$error .= 1;
							error_snap('id provinsi maksimal 50 karakter !');
						}


						if( $error == '' ){
						//prepare data dan pemasukan
							$array = array( 
										'nama_provinsi' => $_POST['nama_provinsi']
										 );
							$query = db_add('tbl_provinsi',$array);
							$proses = db_run($query);

							if($proses){
								success_snap('provinsi '.$_POST['nama_provinsi'].' berhasil di tambah kan !');
							}else{
								error_snap('Gagal Memasukan provinsi !');
							}

						}

					} // end isset proses

					$ph_id = '';
					$ph_name = '';
					$button = 'proses_add';
					$button_name = "Simpan";
					if( isset($_GET['edit']) ){

						$query = db_select('tbl_provinsi','id_provinsi',$_GET['edit']);
						$proses = db_run($query);
						$data = mysqli_fetch_assoc($proses);

						$ph_name = $data['nama_provinsi'];
						$button = 'proses_edit';
						$button_name = "Update";

					}

				?>
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>Tambah Nama provinsi</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form method="POST" class="form-horizontal">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="typeahead">Nama provinsi </label>
								  <div class="controls">
									<input type="text" name="nama_provinsi" value="<?=$ph_name?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" >
								  </div>
								</div>

								<div class="form-actions">

								  <button type="submit" name="<?=$button?>" class="btn btn-primary"><?=$button_name?></button>
								  <button type="reset" class="btn">Cancel</button>
								</div>
							  </fieldset>
							</form>   

						</div>
					</div><!--/span-->
				</div>
			<?php
				if( isset($_GET['view']) ){

				
			?>	
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>Lihat Data : <?=$_GET['view']?></h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content text-center">
							<?php
								$query = db_select('tbl_provinsi','id_provinsi',$_GET['view']);
								db_tabled($query,'table table-striped table-bordered bootstrap-datatable datatable','link');
							?>
						</div>
					</div>
				</div>
			<?php
				}
			?>
				<div class="row-fluid">
					<div class="box span12">
							<div class="box-header" data-original-title>
								<h2><i class="halflings-icon white edit"></i><span class="break"></span>Data provinsi</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								
								<?php

									$query = db_select('tbl_provinsi');
									db_tabled($query,'table table-striped table-bordered bootstrap-datatable datatable','link');

								?>

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