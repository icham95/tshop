<?php
    include_once('pages/header.php'); // load header dan menu navbar
?>

<?php
    // pagination tampil
    if( isset($_GET['p']) ){
        $p = (int)$_GET['p'];
        $per_page = $p;        
    }else{
        $p = 6;
        $per_page = 6;
    }

    if( isset($_GET['h']) ){
        $page = (int)$_GET['h'];
    }else{
        $page = 1;
    }

    if( $page > 1 ){
        $start = ( $page * $per_page ) - $per_page; 
    }else{
        $start = 0;
    }

    if( isset($_GET['brands']) ){
        $qTampil = "SELECT * FROM tbl_barang WHERE id_merk = '".$_GET['brands']."' LIMIT $start,$per_page ";
    }else{
        $qTampil = "SELECT * FROM tbl_barang LIMIT $start,$per_page ";
    }

    $pTampil = db_run($qTampil);
    // end pagination tampil

    //pagination number
    if( isset($_GET['brands']) ){
        $qTampil_barang = db_select("tbl_barang","id_merk",$_GET['brands']);
    }else{
        $qTampil_barang = db_select("tbl_barang");
    }
    $pNumber = db_run($qTampil_barang);
    $jumlah_barang = mysqli_num_rows($pNumber);
    $hitungBarang = $jumlah_barang / $per_page ;
    $pagingNumber = ceil($hitungBarang);
    //end pagintaion number

    //paging other
    $diperlihatkan = $page * $per_page;


?>

    <div id="all">

        <div id="content">

        <?php
            if( isset( $_GET['h'] ) || isset( $_GET['p'] ) || isset( $_GET['brands'] ) ){
                
            }else{
        ?>
            <div class="container">
                <div class="col-md-12">
                    <div id="main-slider">
                        <div class="item">
                            <img src="../admin/img/handpon.jpg"  class="img-responsive">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="../admin/img/pelangi.jpg" alt="">
                        </div>
                    </div>
                    <!-- /#main-slider -->
                </div>
            </div>
        <?php
            }
        ?>

            <div class="container">

                <div class="col-md-12">
                    <!-- diskon atau apapun info lain nya -->
                </div>

                <?php
                    include_once('pages/left-bar.php'); // load menu kiri
                ?>

                <div class="col-md-9">

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing">
                                Total : <strong><?=$jumlah_barang?></strong> Henpon
                            </div>

                            <div class="col-sm-12 col-md-8  products-number-sort">
                                <div class="row">
                                    <form class="form-inline">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="products-number">
                                                <strong>Perlihatkan</strong>
                                                <?php
                                                    if( isset($_GET['brands']) ){
                                                        $showing = "?h=".$page."&brands=".$_GET['brands'];
                                                    }else{
                                                        $showing = "?h=".$page;
                                                    }
                                                ?>
                                                <a href="<?=$showing.'&p=3'?>" class="btn btn-default btn-sm">3</a>
                                                <a href="<?=$showing.'&p=6'?>" class="btn btn-default btn-sm">6</a>  
                                                <a href="<?=$showing.'&p=12'?>" class="btn btn-default btn-sm">12</a> 
                                                <!-- Per halaman -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row products">

                    <?php
                        while( $data=mysqli_fetch_assoc($pTampil) ){
                    ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="product">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.php?produk=<?=$data['id_barang']?>">
                                                <img src="../admin/img/barang/<?=$data['gambar']?>" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.php?produk=<?=$data['id_barang']?>">
                                                <img src="../admin/img/barang/<?=$data['gambar']?>" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.php?produk=<?=$data['id_barang']?>" class="invisible">
                                    <img src="views/img/product1.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.php?produk=<?=$data['id_barang']?>"><?=$data['nama_barang']?></a></h3>
                                    <p class="price">Rp.<?=$data['harga']?></p>
                                    <p class="buttons">
                                        <a href="detail.php?produk=<?=$data['id_barang']?>" class="btn btn-default">Lihat detail</a>
                                        <?php  
                                            if( $login === 1 ){
                                        ?>
                                        <a href="basket.php?order=<?=$data['id_barang']?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Tambah ke keranjang</a>
                                        <?php } ?>
                                    </p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>
                        <!-- /.col-md-4 -->
                    <?php } ?>
                    </div>
                    <!-- /.products -->

                    <div class="pages">

                        <ul class="pagination">
                            <li><a href="?h=1">&laquo;</a>
                            </li>
                            <?php for( $i=1;$i<=$pagingNumber;$i++ ){?>
                            <li class="">
                                <?php
                                    if( isset($_GET['brands']) ){
                                        $pagn = "?h=".$i."&p=".$p."&brands=".$_GET['brands'];
                                    }else{
                                        $pagn = "?h=".$i."&p=".$p;
                                    }
                                ?>
                                <a href="<?=$pagn?>"><?=$i?></a>
                            </li>
                            <?php } ?>
                            <li><a href="#">&raquo;</a>
                            </li>
                        </ul>
                    </div>


                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php

    include_once('pages/footer.php');

?>