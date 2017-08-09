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
  
  
}
