	<?php 
		include_once('conn.php');
		include_once('crud.php');

		if( isset($_GET['hapus']) && isset($_GET['id']) ){
			$id = $_GET['id'];
			$query = db_delete('pesan','id',$id);
			$proses = db_run($query);
			if ( $proses ){
				echo '<script>';
				echo 'alert(" data Berhasil Di hapus. ")';
				echo '</script>';
			}else{
				echo '<script>';
				echo 'alert(" Gagal Di hapus. ")';
				echo '</script>';
			}
		}

	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	<style type="text/css" media="screen">
		input{
			width:100%;
			padding: 3%;
		}
		#action > a{
			display: inline-block;
			text-align: center;
			width: 100%;
			color:crimson;
		}
		#action > a:first-child{
			color:purple;
		}
		#action > a:last-child{
			color:green;
		}
		table, th, td {
		   	border: 1px solid black;
		   	border-collapse: collapse;
		}
		th,td {
			padding: 15px;
		}
	</style>
</head>
<body>
	<table width="30%" align="center">
		<form action="" method="POST" accept-charset="utf-8">
			<caption>test function flexible crud</caption>
			<tr>
				<td> Email pengirim </td>
				<td> <input type="text" name="email_pengirim"> </td>
			</tr>
			<tr>
				<td> email penerima </td>
				<td> <input type="text" name="email_penerima"> </td>
			</tr>
			<tr>
				<td> judul </td>
				<td> <input type="text" name="judul"> </td>
			</tr>
			<tr>
				<td> isi </td>
				<td> <input type="text" name="isi"> </td>
			</tr>
			<tr>
				<td></td>
				<td > <input type="submit" name="kirim" value="tambah_data"> </td>
			</tr>
		</form>
	</table>
	<?php

		if( isset($_POST['kirim']) && $_POST['kirim'] === 'tambah_data' ){

			// ==== tambah data =====

			//persiapan data
				$data = array();
				$data['email_pengirim'] = $_POST['email_pengirim'];
				$data['email_penerima'] = $_POST['email_penerima'];
				$data['judul'] = $_POST['judul'];
				$data['isi'] = $_POST['isi'];
			// end persiapan data

			// validation here

			// end validation

			// pemasukan data

				$query = db_add('pesan',$data);
				$proses = db_run($query);

				if( $proses ){
					echo 'Data berhasil di tambah';
				}else{
					echo 'gagal tambah data';
				}

			// end pemasukan data
		}

		if( isset($_GET['lihat']) && isset($_GET['id']) ){
			$id = $_GET['id'];
			$query = db_select('pesan','id',$id);
			echo'<h3 style="text-align:center;">Lihat</h3>';
			db_tabled($query);

		}
	?>

	<table border="1" align="center" width="60%" style="position: relative;">
			
		<caption><h3>data</h3></caption>
		<thead>
			<tr>
				<td colspan="6" style="text-align:right;padding-right: 1%;">
					<a href="index.php" title="" style="color:chocolate;">Refresh</a>
				</td>
			</tr>
			<tr>
				<th>Email pengirim</th>
				<th>Email penerima</th>
				<th>judul</th>
				<th>isi</th>
				<th>tanggal</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// liat isi table
				$query = db_select('pesan');
				$proses = db_run($query);
				while( $data = mysqli_fetch_assoc($proses) ){

			?>
			<tr>
				<td><?= $data['email_pengirim'] ?></td>
				<td><?= $data['email_penerima'] ?></td>
				<td><?= $data['judul']?></td>
				<td><?= $data['isi'] ?></td>
				<td><?= $data['tgl'] ?></td>
				<td id="action">
					<a href="index.php?edit&id=<?=$data['id']?>" title="">edit</a>
					<a href="index.php?hapus&id=<?=$data['id']?>" title="">hapus</a>
					<a href="index.php?lihat&id=<?=$data['id']?>" title="">lihat</a>
				</td>
			</tr>

			<?php
				} // end while isi table 'pesan'
			?>

		</tbody>
	</table>

</body>
</html>