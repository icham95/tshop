<?php
  include_once('pages/header.php');
?>

<style lang="">
  #modal {
    width:100%;
    height:99vh;
    background-color:rgba(0,0,0,0.4);
    position:fixed;
    top:0px;
    z-index:2;
    display:none;
  }
  #modal > div {
    width:80%;
    margin:5vh auto;
    height: 90vh;
    background-color:snow;
    padding:20px;
    position:relative;
  }
  #close {
    position: absolute;
    right:0px;
    top:0px;
    font-size:18px;
    background-color:crimson;
    padding:10px;
    color:white;
    cursor:pointer;
  }
  #loading {
    display: block;
  }
  #contentmodal {
    display: none;
  }
</style>

<div id="all">

  <div id="content">
    <div class="container">
      <div class="col-sm-12">
            <!-- info tambahan here -->
        <div class="box" style="min-height:300px;">
           <form method="post" action="" id="form">

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="firstname">kurir</label>
                  <!--<input type="text" name="nama_lengkap" class="form-control" id="firstname">-->
                  <select name="" id="select" class="form-control">
                    <option value="jne"> JNE </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="firstname">nomer resi</label>
                  <input type="text" name="nama_lengkap" class="form-control" id="noresi">
                </div>
              </div>
            </div>

            <button class="btn btn-primary" id="bgo" onclick="go(event)"> Go </button>

           </form>
        </div>
      </div>
    </div>
  </div>

  <div id="modal">
    <div>
      <div id="close" onclick="closeModal()"> X </div>
      <div id="loading"> tunggu sebentar, sedang mengambil data.. </div>
      <div id="contentmodal">
        <div id="slug">
        
        </div>
        <div id="tag">
        
        </div>
        <div id="delivery_time">
        
        </div>
        <div id="checkpoint">
        
        </div>
      </div>
    </div>
  </div>

  <script>

    function go (event) {
      event.preventDefault();
      let loading = document.getElementById('loading');
      let content = document.getElementById('contentmodal');
      let modal = document.getElementById('modal');
      
      let kurir = document.getElementById('select')
      let slugKurir = kurir[kurir.selectedIndex].value
      let noResi = document.getElementById('noresi').value
      let url = `http://localhost/tshop/tshop/api.php?tracking&slug=${slugKurir}&id=${noResi}`

      let slug = document.getElementById('slug');
      let tag = document.getElementById('tag');
      let checkpoint = document.getElementById('checkpoint');
      let delivery_time = document.getElementById('delivery_time');

      loading.style.display = 'block';
      content.style.display = 'none';
      modal.style.display = 'block'

      fetch(url, {method: 'GET'})
      .then(resp => resp.json())
      .then(body => {
        loading.style.display = 'none';
        content.style.display = 'block';
        let data = body.data.tracking;
        // console.log(body);
        slug.innerHTML = 'kurir : ' + data.slug;
        slug.innerHTML += '<br> no resi : ' + data.title;
        tag.innerHTML = 'status : ' + data.tag;
        delivery_time.innerHTML = 'waktu pengiriman : ' + data.delivery_time + ' hari';
        checkpoint.innerHTML = 'checkpoints : ';
        for (let i = 0; i < data.checkpoints.length; i++) {
          checkpoint_item = data.checkpoints[i];
          checkpoint.innerHTML += `<li> at : ${checkpoint_item.created_at} || lokasi : ${checkpoint_item.location} || pesan : ${checkpoint_item.message} || status : ${checkpoint_item.tag} </li>`;
        }
      })
      .catch(err => {
        loading.style.display = 'none';
        content.style.display = 'block';

        slug.innerHTML = 'maaf, error !';
      })
    }

    function closeModal () {
      let modal = document.getElementById('modal');
      modal.style.display = 'none';
    }
  </script>
    
<?php
  include_once('pages/footer.php');
?>
