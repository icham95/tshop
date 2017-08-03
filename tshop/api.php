<?php 
require 'vendor/autoload.php';
$_key = '5faf414a-2f6b-43da-b0cd-fb1e5e5cbea5';
if (isset($_GET['kurirs'])) {
  $couriers = new AfterShip\Couriers($_key);
  $response = $couriers->all();
  echo json_encode($response);
}

if (isset($_GET['tracking']) && isset($_GET['slug']) && isset($_GET['id'])) {
  $trackings = new AfterShip\Trackings($_key);
  $tracking_info = [
      'slug'    => $_GET['slug']
  ];
  $response_tracking = $trackings->create($_GET['id'], $tracking_info);
  $id = $response_tracking['data']['tracking']['id'];

  $response = $trackings->getById($id);
  echo json_encode($response);
}