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
						$query = db_delete('tbl_kota','id_kota',$_GET['delete']);
						$proses = db_run($query);

						if($proses){
							success_snap('Berhasil Menghapus kota : '.$_GET['delete'].' !');
						}else{
							error_snap('Gagal Menghapus kota :'.$_GET['delete'].' !');
						}
					}

					if( isset( $_POST['proses_edit'] ) ){

						$nama_kota = $_POST['nama_kota'];
						$get_kota = $_GET['edit'];

						$query = " UPDATE tbl_kota SET
							nama_kota = '$nama_kota'
							WHERE id_kota = '$get_kota'
							";

						$proses = mysqli_query($conn,$query);
						if($proses){
							success_snap('Update kota '.$_GET['edit'].' berhasil !');
						}else{
							error_snap('Gagal Update kota '.$_GET['edit'].' !');
						}

					}

					if( isset( $_POST['proses_add'] ) ){

						// validation
						$error = '';

						if( empty($_POST['nama_kota']) ){
							$error .= 1;
							error_snap('Inputan Nama Kota masih kosong !');
						}

						if( strlen($_POST['nama_kota']) > 50 ){
							$error .= 1;
							error_snap('id kota maksimal 50 karakter !');
						}


						if( $error == '' ){
						//prepare data dan pemasukan
							$array = array( 
										'nama_kota' => $_POST['nama_kota']
										 );
							$query = db_add('tbl_kota',$array);
							$proses = db_run($query);

							if($proses){
								success_snap('kota '.$_POST['nama_kota'].' berhasil di tambah kan !');
							}else{
								error_snap('Gagal Memasukan kota !');
							}

						}

					} // end isset proses

					$ph_id = '';
					$ph_name = '';
					$button = 'proses_add';
					$button_name = "Simpan";
					if( isset($_GET['edit']) ){

						$query = db_select('tbl_kota','id_kota',$_GET['edit']);
						$proses = db_run($query);
						$data = mysqli_fetch_assoc($proses);

						$ph_name = $data['nama_kota'];
						$button = 'proses_edit';
						$button_name = "Update";

					}

				?>
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>Tambah Nama Kota</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form method="POST" class="form-horizontal">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="typeahead">Nama Kota </label>
								  <div class="controls">
									<input type="text" name="nama_kota" value="<?=$ph_name?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" >
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
								$query = db_select('tbl_kota','id_kota',$_GET['view']);
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
								<h2><i class="halflings-icon white edit"></i><span class="break"></span>Data Kota</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								
								<?php

									$query = db_select('tbl_kota');
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