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
				<?php

					if( isset( $_POST['edit_barang'] ) ){

						$id_barang = $_GET['edit'];

						// validation here
						$error = 0;
						if( empty($_POST['nama_barang']) ){
							$error .=1;
							error_snap('Nama barang masih kosong !');
						}
				
						if( empty($_POST['merek']) ){
							$error .=1;
							error_snap('Merk masih kosong !');
						}
						
						if( empty($_POST['tahun_produksi']) ){
							$error .=1;
							error_snap('Tahun produksi masih kosong !');
						}
						if( empty($_POST['negara']) ){
							$error .=1;
							error_snap(' Negara masih kosong !');
						}
						if( empty($_POST['harga']) ){
							$error .=1;
							error_snap(' Harga masih kosong !');
						}
						if( empty($_POST['model']) ){
							$error .=1;
							error_snap('Model masih kosong !');
						}
						if( empty($_POST['garansi']) ){
							$error .=1;
							error_snap('Garansi masih kosong !');
						}
						if( empty($_POST['stok']) ){
							$error .=1;
							error_snap('Stok masih kosong !');
						}
						if( empty($_POST['spesifikasi']) ){
							$error .=1;
							error_snap(' Spesifikasi masih kosong ! ');
						}

						// end validation



						// prepare data dan proses pemasukan
						if( $error === 0){
							
							$nama_barang = $_POST['nama_barang']; 
							$merk = $_POST['merek']; 
							// edit tahun produksi
							$tahun_produksis = $_POST['tahun_produksi']; 
							$bulan = substr($tahun_produksis, 0,2);
							$hari = substr($tahun_produksis, 3,2);
							$tahun = substr($tahun_produksis, 6,4);
							$tahun_produksi = $tahun.'-'.$bulan.'-'.$hari;

							$negara = $_POST['negara'];
							$harga = $_POST['harga'];
							$model = $_POST['model'];
							$garansi = $_POST['garansi'];
							$stok = $_POST['stok'];
							$spesifikasi = $_POST['spesifikasi'];

							// //prepare data
							// 	$array = array 
							// 	(
							// 		"nama_barang" => $nama_barang ,
							// 		"id_merk" => $merk,
							// 		"thn_produksi" => $tahun_produksi,
							// 		"id_negara" => $negara,
							// 		"harga" => $harga,
							// 		"spesifikasi" => $spesifikasi,
							// 		"model" => $model,
							// 		"gambar" => $gambar,
							// 		"stok" => $stok,
							// 		"garansi" => $garansi 
							// 	);
							// //end prepare data

							// apakah gambar di form ada atau engga 
							if( !empty( $_FILES['gambar']['name'] ) ){

								// validation gambar
								$target_dir = 'img/barang/';
								$name_file = basename($_FILES['gambar']['name']);
								$target_file= $target_dir . $name_file;
								$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

								$check = getimagesize($_FILES['gambar']['tmp_name']);
								if( $check === FALSE ){
									error_snap('File bukan gambar !');
								}else{
								
									// prepare data gambar untuk menghapus nanti
									$query_gambar = "SELECT * FROM tbl_barang WHERE id_barang = '$id_barang' ";
									$proses_gambar = db_run($query_gambar);
									$data_gambar = mysqli_fetch_assoc($proses_gambar);	
									$gambar = $name_file;

									//upload gambar
									if( move_uploaded_file($_FILES['gambar']['tmp_name'] , $target_file) ){
										
										$hapus_gambar_lama = 'img/barang/'.$data_gambar['gambar'];
										unlink($hapus_gambar_lama);
										success_snap('Gambar berhasil di tukar !');

									}else{
										error_snap('Gambar gagal di tukar !');
										$gambar = $data['gambar'];
									}

								} // end if check === false

								//persiapan query
								$query = 
								"
									UPDATE tbl_barang SET
									nama_barang 	= '$nama_barang' ,
									id_merk 		= '$merk' ,
									thn_produksi 	= '$tahun_produksi' ,
									id_negara		= '$negara' ,
									harga 			= '$harga' ,
									spesifikasi 	= '$spesifikasi' ,
									model 			= '$model' ,
									gambar 			= '$gambar' ,
									stok 			= '$stok' ,
									garansi 		= '$garansi' 
									WHERE id_barang = '$id_barang';
								";

							}else{

								$query = 
								"
									UPDATE tbl_barang SET
									nama_barang 	= '$nama_barang' ,
									id_merk 		= '$merk' ,
									thn_produksi 	= '$tahun_produksi' ,
									id_negara		= '$negara' ,
									harga 			= '$harga' ,
									spesifikasi 	= '$spesifikasi' ,
									model 			= '$model' ,
									stok 			= '$stok' ,
									garansi 		= '$garansi' 
									WHERE id_barang = '$id_barang';
								";

							} //  end if apakah gambar ada di form inputan atau engga							

							// insert db
							$proses = db_run($query);
							if($proses){
								success_snap("Barang berhasil di Edit !");
							}else{
								
								error_snap("Barang gagal di Edit !");
							}

						}else{

							error_snap('Pengisian Barang gagal !');

						}

						// end prepare data


					} // end if isset edit barang

					// value inputan default
					$nama_barang = '';
					$merk = '';
					$tahun_produksi = '';
					$negara = '';
					$harga = '';
					$model = '';
					$garansi = '';
					$gambar = '';
					$stok = '';
					$spesifikasi = '';
					//name submit default
					$button = 'add_barang';
					$vbutton = 'Tambah';

					if( isset( $_GET['edit'] ) ){

						$id_barang = $_GET['edit'];
						$query =
								"
									SELECT * FROM tbl_barang
									WHERE id_barang = '$id_barang'; 
								";
						$proses = mysqli_query($conn,$query);
						$data = mysqli_fetch_assoc($proses);
						// value inputan edit
						$nama_barang = $data['nama_barang'];
						$tahun_produksi = $data['thn_produksi'];
						$harga = $data['harga'];
						$model = $data['model'];
						$garansi = $data['garansi'];
						$stok = $data['stok'];
						$spesifikasi = $data['spesifikasi'];
						//name submit
						$button = 'edit_barang';
						$vbutton = 'Edit';


					}

					if( isset( $_GET['delete'] ) ){

						// query lihat
						$query1 = "SELECT * FROM tbl_barang WHERE id_barang = '".$_GET['delete']."';";
						$proses1 = db_run($query1);
						$per_data = mysqli_fetch_assoc($proses1);
						$hapus_gambar = 'img/barang/'.$per_data['gambar'];
						
						// die('asd'.$per_data['gambar']);

						// query delete
						$query = db_delete('tbl_barang','id_barang',$_GET['delete']);
						$proses = db_run($query);

						if( file_exists($hapus_gambar) ){
							unlink($hapus_gambar);
						}else{
							error_snap("gambar tidak ditemukan !");
						}

						if( $proses ){

							success_snap('Berhasil Menghapus merk : '.$_GET['delete'].' !');
						}else{
							error_snap('Gagal Menghapus merk :'.$_GET['delete'].' !');
						}
					}

					if( isset( $_POST['add_barang'] ) ){

						// validation here

						$error = 0;
						if( empty($_POST['nama_barang']) ){
							$error .=1;
							error_snap('Nama barang masih kosong !');
						}
				
						if( empty($_POST['merek']) ){
							$error .=1;
							error_snap('Merk masih kosong !');
						}
						
						if( empty($_POST['tahun_produksi']) ){
							$error .=1;
							error_snap('Tahun produksi masih kosong !');
						}
						if( empty($_POST['negara']) ){
							$error .=1;
							error_snap(' Negara masih kosong !');
						}
						if( empty($_POST['harga']) ){
							$error .=1;
							error_snap(' Harga masih kosong !');
						}
						if( empty($_POST['model']) ){
							$error .=1;
							error_snap('Model masih kosong !');
						}
						if( empty($_POST['garansi']) ){
							$error .=1;
							error_snap('Garansi masih kosong !');
						}
						if( empty($_POST['stok']) ){
							$error .=1;
							error_snap('Stok masih kosong !');
						}
						if( empty($_POST['spesifikasi']) ){
							$error .=1;
							error_snap(' Spesifikasi masih kosong ! ');
						}

						//gambar
							$target_dir = 'img/barang/';
							$name_file = basename($_FILES['gambar']['name']);
							$target_file= $target_dir . $name_file;
							$uploadOk = 0; 
							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

							$check = getimagesize($_FILES['gambar']['tmp_name']);
							if( $check === FALSE ){
								$uploadOk .= 1;
								error_snap('File bukan gambar !');
							}
							
							// cek apakah file sudah ada
							$query = db_select('tbl_barang','gambar',$name_file);
							$proses = db_run($query);
							$hitung_cek_gambar = mysqli_num_rows($proses);
							if($hitung_cek_gambar > 1){
								$uploadOk .= 1;
								error_snap('Gambar sudah ada !');
							}

						// end validation

						// prepare data dan proses pemasukan
						if($uploadOk !== 0){
							error_snap("Upload gambar gagal !");
							error_snap("Barang gagal ditambahkan !");
						}else if( $error === 0){
							
							$nama_barang = $_POST['nama_barang']; 
							$merk = $_POST['merek']; 
							// edit tahun produksi
							$tahun_produksis = $_POST['tahun_produksi']; 
							$bulan = substr($tahun_produksis, 0,2);
							$hari = substr($tahun_produksis, 3,2);
							$tahun = substr($tahun_produksis, 6,4);
							$tahun_produksi = $tahun.'-'.$bulan.'-'.$hari;

							$negara = $_POST['negara'];
							$harga = $_POST['harga'];
							$model = $_POST['model'];
							$garansi = $_POST['garansi'];
							$stok = $_POST['stok'];
							$spesifikasi = $_POST['spesifikasi'];
							$gambar = $name_file;

							//prepare data
								$array = array 
								(
									"nama_barang" => $nama_barang ,
									"id_merk" => $merk,
									"thn_produksi" => $tahun_produksi,
									"id_negara" => $negara,
									"harga" => $harga,
									"spesifikasi" => $spesifikasi,
									"model" => $model,
									"gambar" => $gambar,
									"stok" => $stok,
									"garansi" => $garansi 
								);
							//end prepare data
							
							//upload gambar
							if( move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file) ){

								// insert db
								$query = db_add("tbl_barang",$array);
								$proses = db_run($query);
								if($proses){
									success_snap("Barang berhasil di tambah kan !");
								}else{
									error_snap("Barang gagal di tambahkan !");
									if( file_exists($target_file) ){
										unlink($target_file);
									}
								}

							}else{
								error_snap('Maaf , Gambar gagal di upload. <br> Pengisian barang gagal !');
							}

						}else{

							error_snap('Pengisian Barang gagal !');

						}

						// end prepare data

					} // end if isset post

			if( isset($_GET['view']) ){		
			?>	
				<div class="row-fluid">
					<div class="box span12">
						<div class="box-header" data-original-title>
							<h2><i class="halflings-icon white edit"></i><span class="break"></span>id_barang : <?=$_GET['view']?></h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content text-center">
							<?php
								$query = db_select('tbl_barang','id_barang',$_GET['view']);
								db_tabled($query,'table table-striped table-bordered bootstrap-datatable datatable');
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
							<h2><i class="halflings-icon white user"></i><span class="break"></span>Tambah Barang</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<form method="POST" class="form-horizontal" enctype="multipart/form-data">
							  <fieldset>
								<div class="control-group">
								  <label class="control-label" for="nama_barang">Nama Barang</label>
								  <div class="controls">
									<input class="input-text" value="<?=$nama_barang?>" type="text" name="nama_barang" id="nama_barang" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="merek">Merek</label>
								  <div class="controls">
									<select name="merek">
									<?php
										$query = db_select( 'tbl_merk' );
										$run = db_run($query);
										while( $data = mysqli_fetch_assoc($run) ){
									?>
										<option value="<?=$data['id_merk']?>"><?=$data['nama_merk']?></option>
									<?php
										}
									?>
									</select>
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="tahun_produksi">Tahun Produksi</label>
								  <div class="controls">
									<input class="input-xlarge datepicker" value="<?=$tahun_produksi?>" type="text" name="tahun_produksi" id="tahun_produksi" >
								  </div>
								</div> 

								<div class="control-group">
								  <label class="control-label" for="negara">Negara</label>
								  <div class="controls">
									<select name="negara">
									<?php
										$query = db_select( 'tbl_negara' );
										$run = db_run($query);
										while( $data = mysqli_fetch_assoc($run) ){
									?>
										<option value="<?=$data['id_negara']?>"><?=strtolower($data['nama_negara'])?></option>
									<?php
										}
									?>
									</select>
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="harga">Harga</label>
								  <div class="controls">
									<input class="input-text" value="<?=$harga?>" type="number" name="harga" id="harga" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="model">model</label>
								  <div class="controls">
									<input class="input-text" value="<?=$model?>" type="text" name="model" id="model" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="garansi">Garansi</label>
								  <div class="controls">
									<input class="input-text" value="<?=$garansi?>" type="text" name="garansi" id="garansi" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="gambar">Gambar</label>
								  <div class="controls">
									<input class="input-file uniform_on" type="file" name="gambar" id="gambar" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="stok">Stok</label>
								  <div class="controls">
									<input class="input-text" value="<?=$stok?>" type="number" name="stok" id="stok" >
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="spesifikasi">Spesifikasi</label>
								  <div class="controls">
									<textarea class="cleditor" value="" name="spesifikasi" id="spesifikasi" > <?=$spesifikasi?>	 </textarea>
								  </div>
								</div>

								<div class="form-actions">

								  <button type="submit" name="<?= $button ?>" class="btn btn-primary"><?=$vbutton?></button>
								  <button type="reset" class="btn">Cancel</button>
								</div>
							  </fieldset>
							</form>
						</div>
					</div>
				</div>				

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
										<th>Nama</th>
										<th></th>
										<th>Merek</th>
										<th>Model</th>
										<th>Tahun Produksi</th>
										<th>garansi</th>
										<th>action</th>
									</tr>
								</thead>
								<tbody>
							<?php
								$query = '
											SELECT * FROM tbl_barang
											INNER JOIN tbl_merk
											ON tbl_barang.id_merk = tbl_merk.id_merk
											ORDER BY id_barang DESC;
										';
								$proses = db_run($query);
								$no = 1;
								while( $data = mysqli_fetch_assoc($proses) ){
							?> 

								<tr>
									<td><?=$no++?></td>
									<td><?=$data['nama_barang']?></td>
									<td><img src="../admin/img/barang/<?=$data['gambar']?>" width='50px' class="img-responsive" alt=""></td>
									<td><?=$data['nama_merk']?></td>
									<td><?=$data['model']?></td>
									<td><?=$data['thn_produksi']?></td>
									<td><?=$data['garansi']?></td>
									<td>
										<a class="btn btn-success" href="?edit=<?=$data['id_barang']?>">
											<i class="halflings-icon white edit"></i>                                            
										</a>
										<a class="btn btn-primary" href="?view=<?=$data['id_barang']?>">
											<i class="halflings-icon white zoom-in"> </i> 
										</a>
										<a class="btn btn-danger" href="?delete=<?=$data['id_barang']?>">
											<i class="halflings-icon white trash"></i>                                            
										</a>
									</td>
								</tr>
								


							<?php } ?>       
								</tbody>
							</table>
						</div>
					</div><!--/span-->
				</div>
				
	
				<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	</div> <!-- end div container-fluid-full -->
	<div class="clearfix"></div>
	
<?php
	
	include_once('pages/footer.php');

?>