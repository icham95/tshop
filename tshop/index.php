<?php
    include_once('pages/header.php'); // load header dan menu navbar
?>

<?php
    // token
    $_SESSION['_token_detail'] = generate_token();

    // kena effect di left-bar.php
    if( isset($_GET['h']) ){
        $page = (int)$_GET['h'];
    }else{
        $page = 1;
    }
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
                                Total : <strong id="hu_jumbar">0</strong> Henpon
                            </div>
                        </div>
                    </div>

                    <div class="row products" id="hu_barang">
                        
                    </div>
                    <!-- /.products -->

                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<script>
    let pathSearch = window.location.search;
    pathSearch = pathSearch.substr(1)
    let perPage = 6;
    let page = 1;
    let brandId = null;
    let arrPs = pathSearch.split('&');
    let start = 0;

    for (let i = 0; i < arrPs.length; i++) {
        let itemPs = arrPs[i].split('=');
        if (itemPs.length > 0) {
            let keyPs = itemPs[0];
            let valuePs = itemPs[1];
            if (keyPs == 'p') {
                perPage = valuePs;
            }
            if (keyPs == 'h') { 
                page = valuePs;
            }
            if (keyPs == 'brands') {
                brandId = valuePs;
            }
        }
    }

    if (page > 1) {
        start = ( page * perPage ) - perPage; 
    }

    let hu_data = {
        perPage, 
        page, 
        brandId,
        start
    }
    let hu_url = 'http://localhost/tshop/tshop/api/hal-utama';

    let hu_barang = document.getElementById('hu_barang');
    let hu_jumbar = document.getElementById('hu_jumbar');

    fetch(hu_url, {
        method: 'POST',
        body: JSON.stringify(hu_data)
    }).then(resp => resp.json())
    .then(data => {
        hu_barang.innerHTML = '';
        hu_jumbar.innerHTML = data.total.total;
        for(let i = 0; i < data.count; i++) {
            hu_barang.innerHTML += 
            `
            <div class="col-md-4 col-sm-6">
                <div class="product">
                    <a href="detail.php?produk=${data[i].id_barang}">
                        <img src="../admin/img/barang/${data[i].gambar}" alt="" class="img-responsive">
                    </a>
                    <div class="text">
                        <h3><a href="detail.php?produk=${data[i].id_barang}">${data[i].nama_barang}</a></h3>
                        <p class="price">Rp.${data[i].harga}</p>
                        <p class="buttons">
                            <a href="detail.php?produk=${data[i].id_barang}" class="btn btn-default">Lihat detail</a>
                        </p>
                    </div>
                </div>
            </div>
            `;
        }
    })
    .catch(err => {
        console.log(err)
    })
</script>

<?php

    include_once('pages/footer.php');

?>