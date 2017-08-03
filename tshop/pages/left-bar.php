<div class="col-md-3">
    <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Brands</h3>
        </div>

        <div class="panel-body">
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

        </div>
    </div>


    <!-- *** MENUS AND FILTERS END *** -->

    <div class="banner">
        
    </div>
</div>