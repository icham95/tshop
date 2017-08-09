<div class="col-md-3">
    <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Brands</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked index-menu" id="merk">

            </ul>
        </div>
    </div>
    <!-- *** MENUS AND FILTERS END *** -->

    <div class="banner">
        
    </div>
</div>

<script>
    let url = 'http://localhost/tshop/tshop/api/merk'
    let merk = document.getElementById('merk');
    fetch(url, {method: 'GET'})
    .then(resp => resp.json())
    .then(data => {
        for (let i = 0; i < data.length; i++) {
            merk.innerHTML += 
            `
            <li>
                <a href="?h=<?= $page ?>&p=<?= $p ?>&brands=${data[i]['id_merk']}"> ${data[i]['nama_merk']} </a>
            </li>
            `
        }
    })
</script>
