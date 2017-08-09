<?php 

namespace classes;
include_once('vendor/autoload.php');
include_once('classes/autoload.php');

use classes\Helper;
use classes\Database;
use AfterShip\Trackings;

class Controller_api
{
  private $_key = '5faf414a-2f6b-43da-b0cd-fb1e5e5cbea5';
  private $db = null;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function tracking()
  {
    $payload = Helper::get_contents();
    $slugKurir = $payload->slug;
    $idKurir = $payload->id;
    $trackings = new Trackings($this->_key);
    $tracking_info = [
        'slug'    => $slugKurir
    ];
    $response_tracking = $trackings->create($idKurir, $tracking_info);
    $id = $response_tracking['data']['tracking']['id'];

    $response = $trackings->getById($id);
    Sapi::toJSON($response);
  }

  public function merk()
  {
    Sapi::toJSON($this->db->gets('tbl_merk'));
  }

  public function hal_utama()
  {
    $payload = Helper::get_contents();
    
    if( $payload->brandId !== null){
      $qCount = "select count(id_barang) as total from tbl_barang where id_merk = '$payload->brandId'";
      $qTampil = "SELECT * FROM tbl_barang WHERE id_merk = '".$payload->brandId."' LIMIT $payload->start,$payload->perPage";
    }else{
      $qCount = "select count(id_barang) as total from tbl_barang";
      $qTampil = "SELECT * FROM tbl_barang LIMIT $payload->start,$payload->perPage";
    }

    $ndata = [];
    $total = $this->db->query($qCount);
    $ndata['total'] = $total[0];

    $data = $this->db->query($qTampil);
    $ndata['count'] = count($data);
    $i = 0;
    foreach ($data as $key => $value) {
      $ndata[$i]['id_barang'] = $value['id_barang'];
      $ndata[$i]['nama_barang'] = $value['nama_barang'];
      $ndata[$i]['id_merk'] = $value['id_merk'];
      $ndata[$i]['thn_produksi'] = $value['thn_produksi'];
      $ndata[$i]['id_negara'] = $value['id_negara'];
      $ndata[$i]['harga'] = $value['harga'];
      $ndata[$i]['gambar'] = $value['gambar'];
      $i++;
    }

    Sapi::toJSON($ndata);

    // //pagination number
    // if( isset($_GET['brands']) ){
    //     $qTampil_barang = db_select("tbl_barang","id_merk",$_GET['brands']);
    // }else{
    //     $qTampil_barang = db_select("tbl_barang");
    // }
    // $pNumber = db_run($qTampil_barang);
    // $jumlah_barang = mysqli_num_rows($pNumber);
    // $hitungBarang = $jumlah_barang / $per_page ;
    // $pagingNumber = ceil($hitungBarang);
    // //end pagintaion number

    // //paging other
    // $diperlihatkan = $page * $per_page;
  }
  
  
}
