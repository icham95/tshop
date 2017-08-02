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
						$query = db_delete('tbl_negara','id_negara',$_GET['delete']);
						$proses = db_run($query);

						if($proses){
							success_snap('Berhasil Menghapus Negara : '.$_GET['delete'].' !');
						}else{
							error_snap('Gagal Menghapus Negara : '.$_GET['delete'].' !');
						}
					}

					if( isset( $_POST['proses_edit'] ) ){

						$id_negara = $_POST['id_negara'];
						$nama_negara = $_POST['nama_negara'];
						$get_negara = $_GET['edit'];

						$query = " UPDATE tbl_negara SET
							id_negara = '$id_negara' ,
							nama_negara = '$nama_negara'
							WHERE id_negara = '$get_negara'
							";

						$proses = mysqli_query($conn,$query);
						if($proses){
							success_snap('Update negara '.$_GET['edit'].' berhasil !');
						}else{
							error_snap('Gagal Update negara '.$_GET['edit'].' !');
						}

					}

					if( isset( $_POST['proses_add'] ) ){

						// validation
						$error = '';
						if( empty($_POST['id_negara']) ){
							$error .= 1;
							error_snap('Inputan id negara masih kosong !');
						}

						if( empty($_POST['nama_negara']) ){
							$error .= 1;
							error_snap('Inputan nama negara masih kosong !');
						}

						if( strlen($_POST['id_negara']) > 3 ){
							$error .= 1;
							error_snap('id negara maksimal 3 karakter !');
						}

						if( strlen($_POST['nama_negara']) > 50 ){
							$error .= 1;
							error_snap('id negara maksimal 50 karakter !');
						}


						if( $error == '' ){
						//prepare data dan pemasukan
							$array = array( 
										'id_negara' => $_POST['id_negara'] ,
										'nama_negara' => $_POST['nama_negara']
										 );
							$query = db_add('tbl_negara',$array);
							$proses = db_run($query);

							if($proses){
								success_snap('Negara '.$_POST['nama_negara'].' berhasil di tambah kan !');
							}else{
								error_snap('Gagal Memasukan negara !');
							}

						}

					} // end isset proses

					$ph_id = '';
					$ph_name = '';
					$button = 'proses_add';
					$button_name = "Simpan";
					if( isset($_GET['edit']) ){

						$query = db_select('tbl_negara','id_negara',$_GET['edit']);
						$proses = db_run($query);
						$data = mysqli_fetch_assoc($proses);

						$ph_id = $data['id_negara'];
						$ph_name = $data['nama_negara'];
						$button = 'proses_edit';
						$button_name = "Update";

					}

				?>
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>Tambah nama negara</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form method="POST" class="form-horizontal">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="typeahead">id negara </label>
								  <div class="controls">
									<input type="text" name="id_negara" value="<?=$ph_id?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" >
								  </div>
								</div>
								<div class="control-group">
								  <label class="control-label" for="typeahead">Nama negara </label>
								  <div class="controls">
									<input type="text" name="nama_negara" value="<?=$ph_name?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" >
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
								$query = db_select('tbl_negara','id_negara',$_GET['view']);
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
								<h2><i class="halflings-icon white edit"></i><span class="break"></span>Data Negara</h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
									<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
								</div>
							</div>
							<div class="box-content">
								
								<?php

									$query = db_select('tbl_negara');
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