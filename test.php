<?php

include './library/Requests.php';

Requests::register_autoloader();

$data = Requests::get("https://www.instagram.com/". $_GET['user'] ."/media/");

$data = json_decode($data->body);

$slike = $data->items;

foreach($slike as $slika) {
  echo "<a href='" . $slika->images->standard_resolution->url . "'><img src='" . $slika->images->thumbnail->url . "' /></a> ";
}



// if ( isset($_GET['page']) ) {
//   $page = $_GET['page'];
// } else {
//   $page = 1;
// }
//
// $per_page = 10;
//
// require_once './Product.class.php';
//
// $p = new Product();
//
// var_dump($p->paginate($page, $per_page));
//
// $total_p = ceil( $p->num_prod()['num_prod'] / $per_page );
//
// for( $i = 1; $i <= $total_p; $i++) {
//   echo "<a href='test.php?page=$i'>$i</a>";
// }
// http://github.com/rmccue/Requests
