<?php
    include_once('pages/header.php');
?>

<?php
    
    if( isset( $_GET['produk'] ) ){
        $id_produk = $_GET['produk'];
    }

    $query = 
            "
                SELECT * FROM tbl_barang 
                INNER JOIN tbl_negara
                INNER JOIN tbl_merk
                ON tbl_barang.id_negara = tbl_negara.id_negara AND tbl_barang.id_merk = tbl_merk.id_merk
                WHERE tbl_barang.id_barang = '".$id_produk."';
            ";
    $proses = db_run($query);
    $data = mysqli_fetch_assoc($proses);

?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    
                    <!-- info tambahan here -->

                </div>

                <div class="col-md-12">

                    <div class="row" id="productMain">
                        <div class="col-sm-6">
                            <div id="mainImage" style="background-color:white;">
                                <img id="zoom" data-zoom-image="../admin/img/barang/<?=$data['gambar']?>" src="../admin/img/barang/<?=$data['gambar']?>" alt="" style="width:60%;" class="img-responsive">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box">
                                <h1 class="text-center"><?=$data['nama_barang']?></h1>
                                <p class="goToDescription">
                                <a href="#details" class="scroll-to">
                                    Scroll ke bawah untuk melihat spesifikasi.
                                </a>
                                </p>
                                <p class="price">Rp.<?=$data['harga']?></p>

                                <p class="text-center buttons">
                                <?php  
                                    if( $login === 1 ){
                                ?>
                                    <a href="basket.php?order=<?=$data['id_barang']?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to cart</a> 
                                    <a href="basket.php?wish=<?=$data['id_barang']?>" class="btn btn-default"><i class="fa fa-heart"></i> Add to wishlist</a>
                                <?php }else{ ?>
                                    <span style="font-size: 12px;color:crimson;">Kamu harus login terlebih dahulu , untuk membeli !</span>
                                <?php } ?>
                                </p>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-1">
                        
                    </div>
                    <div class="box text-center col-md-10 col-xs-12" id="details">
                        <div style="position: absolute;right: 3%;">
                            Stok produk : <?=$data['stok']?> 
                        </div>
                            <h3>Product details</h3>

                            <h4>Brands</h4>
                            <p>
                                <?=strtoupper($data['nama_merk'])?>
                            </p>

                            <h4>Model</h4>
                            <p>
                                <?=strtoupper($data['model'])?>
                            </p>

                            <h4>Negara</h4>
                            <p>
                                <?=$data['nama_negara']?>
                            </p>

                            <h4>Tahun Produksi</h4>
                            <p>
                                <?=$data['thn_produksi']?>
                            </p>

                            <h4>Garansi</h4>
                            <p>
                                <?=$data['garansi']?>
                            </p>

                            <h4>Spesifikasi</h4>
                            <p>
                                <?=$data['spesifikasi']?>
                            </p>

                    </div>

                            

                </div>
                <!-- /.col-md-12 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
    </div>
    <script src='views/js/jquery-1.8.3.min.js'></script>
    <script src='views/js/jquery.elevatezoom.js'></script>
    <script>
        $('#zoom').elevateZoom(); 
    </script>

<?php
    
    include_once('pages/footer.php');

?>