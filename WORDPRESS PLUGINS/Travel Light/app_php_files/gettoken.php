<?php

 header("Access-Control-Allow-Origin: *");

   header("Content-Type: application/json; charset=UTF-8");

   $path = $_SERVER['DOCUMENT_ROOT'];

   include_once $path . '/wp-config.php';

   include_once $path . '/wp-load.php';

   include_once $path . '/wp-includes/wp-db.php';

   include_once $path . '/wp-includes/pluggable.php';



caldst($_REQUEST[complist]);

function caldst($mapmarkers) {

  ob_clean();

   global $post;

$totalmeters = 0;


for ($x = 0; $x < sizeof($mapmarkers); $x++) {

$args = array( 'posts_per_page' => -1 , 'post_type' => 'place_of_interest','place_of_interest_map' => 'Jamaica');

$myposts = get_posts( $args );


echo $mapmarkers[$x];

foreach ( $myposts as $post ) : setup_postdata( $post ); 

$s = get_post_meta( $post->ID );



if($s[company][0] === $mapmarkers[$x]) 

{



$latlng = str_replace('(','',$s[latlng][0]);

$latlng = str_replace(')','', $latlng);

$a = array();

$a = explode(",",$latlng);

$R = 6378137;

$dLat = ((str_replace(' ', '',$a[0]) - 18.166673)* pi() )/180;

$dLong = ((str_replace(' ', '',$a[1]) - (-76.381451))* pi() )/180;

$a = sin($dLat / 2) * sin($dLat / 2) + cos((str_replace(' ', '',$a[0]) * pi() )/180) * cos((18.166673 * pi() )/180) * sin($dLong / 2) * sin($dLong / 2);

$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

$d = $R * $c;

$totalmeters = $d + $totalmeters;

$totalKmeters = ($totalmeters * 2) * 0.001;

$miles = $totalKmeters * 0.621371192;

echo $miles;

}

endforeach;

} 

return $totalmeters;


}


function pathdistance ($lat,$long) {


echo $lat .' '. $long;

$R = 6378137;

$dLat = (($lat - 18.166673)* pi() )/180;

$dLong = (($long - (-76.381451))* pi() )/180;

$a = sin($dLat / 2) * sin($dLat / 2) + cos(($lat * pi() )/180) * cos((18.166673 * pi() )/180) * sin($dLong / 2) * sin($dLong / 2);

$c = 2 * atan2(sqrt($a), sqrt(1 - $a));

$d = $R * $c;

return $d;



}


?>