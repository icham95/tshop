<?php
	
	/*
		==========================================
		coba-coba buat builder query pake procedural.
		siapa tau bisa buat framework php sendiri ,
		nanti -.-"
		==========================================
				 		Night Query 
				 	   Version 0.00001
				 ( Crud Query Builder MySQL )
					 By : Hisyam Maulana
				  Free to Use And Open Source
		==========================================
				for documentation is not created
				for download the script not yet
					   	  uploaded..
						Sorry for now..
		==========================================

	*/
	
	function db_run($query = NULL){
		global $conn;

		if($query === NULL){
			echo '<script>';
			echo 'alert("Query kosong !");';
			echo '</script>';
		}else{

			$proses = mysqli_query($conn,$query);
			return $proses;

		}

	}

	function db_delete($table=NULL , $where = NULL ,$as = NULL){

		if( isset($table) && isset($where) && isset($as) ){
			
			$query = "DELETE FROM ".$table." WHERE ".$where." = '".$as."'";

		}else{
			echo 'function db_delete : Parameter Kurang !';
		}

		return $query;

	}

	function db_select( $table , $where = NULL ,$as = NULL){ 

		if( $where === NULL AND $as === NULL ){

			$query = "SELECT * FROM ".$table;

		}elseif( $where === NULL){
			echo 'parameter kurang';
		}elseif( $as === NULL ){
			echo 'parameter kurang';
		}else{

			$query = "SELECT * FROM ".$table." WHERE ".$where."= '".$as."'";

		}

		return $query;

	}

	function db_tabled($query , $class_table = NULL, $link = NULL){
		GLOBAL $conn;

		// persiapan data
		$header = array();
		$isi = array();
		
		$query1 = $query;
		$query1 .= " LIMIT 1";

		// ambil data header table
		$proses = mysqli_query($conn,$query1);
		$data = mysqli_fetch_assoc($proses);
		$jum_per_row = 0;
		foreach ($data as $key => $value) {
			$jum_per_row += 1; 
			$header[] = $key;
		}

		// ambil isi data table
		$proses_isi = mysqli_query($conn,$query);
		$hitung_query = mysqli_num_rows($proses_isi);

		// masukin data table ke array isi
		$no = 0;
		while($data = mysqli_fetch_array($proses_isi) ){
			$no +=1;
			for($i=0;$i<$jum_per_row;$i++){
				$isi_header = $header[$i];
				$isi[$no][$isi_header] = $data[$i];
			}

		}

		$jumlah_isi = sizeof($isi);
		// end persiapan data

		// tampilkan header table
		echo '<table align="center" class="'.$class_table.'">';
		echo '<thead>';
		echo '<tr>';
		foreach ($header as $key => $value) {
			echo '<td class="center">'.$value.'</td>';
		}

		if( $link == 'link' ){
			echo '<td>Action</td>';
		}

		echo '<tr>';
		echo '</thead>';
		echo '<tbody>';
		//tampil isi table
		for($i=1;$i<=$jumlah_isi;$i++){
			echo '<tr>';
			for($z=0;$z<$jum_per_row;$z++ ){
				
				$isi_header = $header[$z];

				if($z == 0){
					$header1 = $isi[$i][$isi_header];
				}
				echo '<td class="center">'.$isi[$i][$isi_header].'</td>';
			}

			if( $link == 'link' ){
				echo '<td class="center">';
				echo '	<a class="btn btn-success" href="?edit='.$header1.'">
							<i class="halflings-icon white edit"></i>                                            
						</a>';
				echo '	<a class="btn btn-primary" href="?view='.$header1.'">
							<i class="halflings-icon white zoom-in"></i>                                            
						</a>';
				echo '	<a class="btn btn-danger" href="?delete='.$header1.'">
							<i class="halflings-icon white trash"></i>                                            
						</a>';
				echo '</td>';
			}
			

			echo '</tr>';
		}

		echo '</tbody>';		
		echo '</table>';		

	}

	function db_add($table, $data = array() ){
		GLOBAL $conn;

		$query = 'INSERT INTO '.$table.' (';

		foreach ($data as $key => $val) {
			$query .= ' '.$key." ,";
		}

		//hilang koma
		$hitung = strlen($query);
		$kurangin = (int)$hitung - 1;
		$ilangin = substr($query, 0, $kurangin);
		$query = $ilangin.') VALUES (';

		foreach ($data as $key) {
			$query .= " '".$key."' ,";
		}

		//hilang koma
		$hitung = strlen($query);
		$kurangin = (int)$hitung - 1;
		$ilangin = substr($query, 0, $kurangin);
		$query = $ilangin.') ';

		return $query;

	}	

	

?>