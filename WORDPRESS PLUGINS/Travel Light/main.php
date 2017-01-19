<?php

 
    /*
    Plugin Name: Travel Light
    Plugin URI: https://travellight.herokuapp.com
    Description: Plugin for displaying places of interest in Portland Jamaica
    Author: M. Slack
    Version: 1.0
    Author URI: http://unifieddigitalmedia.herokuapp.com

   Travel Light is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 2 of the License, or
   any later version.
 
   Travel Lightis distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.
 
   You should have received a copy of the GNU General Public License
   along with Travel Light. If not, see http://www.gnu.org/licenses/gpl-2.0.html.



    */


defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


spl_autoload_register(function ($class) {


include dirname( __FILE__ ) . '/admin/'. $class .'.php';


});


if ( is_admin() ) {

db::dbini();

db_enqueue::db_enq_ini();

db_actions::db_actions_ini();

db_uni_tx::db_uni_tax();


  register_activation_hook( __FILE__, 'db_database::db_trip_create' );

}

else

{

db_srt::init();

db_enqueue::db_enq_ini_fe();

db::dbinife();




}



?>