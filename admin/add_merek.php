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
						$query = db_delete('tbl_merk','id_merk',$_GET['delete']);
						$proses = db_run($query);

						if($proses){
							success_snap('Berhasil Menghapus merk : '.$_GET['delete'].' !');
						}else{
							error_snap('Gagal Menghapus merk :'.$_GET['delete'].' !');
						}
					}

					if( isset( $_POST['proses_edit'] ) ){

						$nama_merk = $_POST['nama_merk'];
						$get_merk = $_GET['edit'];

						$query = " UPDATE tbl_merk SET
							nama_merk = '$nama_merk'
							WHERE id_merk = '$get_merk'
							";

						$proses = mysqli_query($conn,$query);
						if($proses){
							success_snap('Update merk '.$_GET['edit'].' berhasil !');
						}else{
							error_snap('Gagal Update merk '.$_GET['edit'].' !');
						}

					}

					if( isset( $_POST['proses_add'] ) ){

						// validation
						$error = '';

						if( empty($_POST['nama_merk']) ){
							$error .= 1;
							error_snap('Inputan Nama merk masih kosong !');
						}

						if( strlen($_POST['nama_merk']) > 50 ){
							$error .= 1;
							error_snap('id merk maksimal 50 karakter !');
						}


						if( $error == '' ){
						//prepare data dan pemasukan
							$array = array( 
										'nama_merk' => $_POST['nama_merk']
										 );
							$query = db_add('tbl_merk',$array);
							$proses = db_run($query);

							if($proses){
								success_snap('merk '.$_POST['nama_merk'].' berhasil di tambah kan !');
							}else{
								error_snap('Gagal Memasukan merk !');
							}

						}

					} // end isset proses

					$ph_id = '';
					$ph_name = '';
					$button = 'proses_add';
					$button_name = "Simpan";
					if( isset($_GET['edit']) ){

						$query = db_select('tbl_merk','id_merk',$_GET['edit']);
						$proses = db_run($query);
						$data = mysqli_fetch_assoc($proses);

						$ph_name = $data['nama_merk'];
						$button = 'proses_edit';
						$button_name = "Update";

					}

				?>
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>Tambah Nama merk</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form method="POST" class="form-horizontal">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="typeahead">Nama merk </label>
								  <div class="controls">
									<input type="text" name="nama_merk" value="<?=$ph_name?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" >
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
								$query = db_select('tbl_merk','id_merk',$_GET['view']);
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
								<h2><i class="halflings-icon white edit"></i><span class="break"></span>Data merk</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								
								<?php

									$query = db_select('tbl_merk');
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