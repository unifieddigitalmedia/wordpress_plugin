<?php
/*
$directory = '/home/udigitalmedia32/public_html/dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/images/mapicons/';

$scanned_directory = array_diff(scandir($directory), array('..', '.'));

foreach ($scanned_directory as $value)

{

echo '<span> <img class="thumb" src="/home/udigitalmedia32/public_html/dragonbayinnjamaica.com/wp-content/plugins/DragonBayInn/images/mapicons/'.$value.'"/></span>';

}*/
echo 'ad';

$args = array( 'post_status'=> 'publish','posts_per_page' => 5 , 'post_type' => 'place_of_interest','place_of_interest_map' => 'Jamaica');

$myposts = get_posts( $args );



print_r($myposts);


?>