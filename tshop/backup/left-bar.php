<ul class="nav nav-pills nav-stacked index-menu">
            <?php
                $query = "SELECT * FROM tbl_merk";
                $proses = db_run($query);
                while( $data= mysqli_fetch_assoc($proses) ){
            ?>
                <li>
                    <a href="<?= '?h='.$page.'&p='.$p.'&brands='.$data['id_merk'] ?>"><?=$data['nama_merk']?> 
                    <?php
                        $queryJumMerk = "SELECT COUNT(id_merk) AS jumlahMerk FROM tbl_barang WHERE id_merk = '".$data['id_merk']."'";
                        $prosesJumMerk = mysqli_query($conn,$queryJumMerk);
                        $jumlahMerk = mysqli_fetch_assoc($prosesJumMerk);
                    ?>
                    <span class="badge pull-right"><?=$jumlahMerk['jumlahMerk']?></span>

                    </a>
                </li>
            <?php } ?>
            </ul>