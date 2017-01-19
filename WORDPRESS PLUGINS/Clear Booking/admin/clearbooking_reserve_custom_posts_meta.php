<?php

if ( ! defined( 'ABSPATH' ) ) exit;
 
class clearbooking_reserve_custom_posts_meta

{
  




 public static function clearbooking_reserve_custom_posts_meta_()
  

  {
    

 add_meta_box( 'rooms_meta_box','Clear Bookings Reserve Custom Fields',array( 'clearbooking_reserve_custom_posts_meta', 'clearbooking_reserve_rooms_install' ),'clearbooking_rooms', 'normal', 'high');

 add_meta_box( 'coupons_meta_box','Clear Bookings Reserve Custom Fields',array( 'clearbooking_reserve_custom_posts_meta', 'clearbooking_reserve_coupons_install' ),'clearbooking_coupons', 'normal', 'high');

 add_meta_box( 'add_ons_meta_box','Clear Bookings  Reserve Custom Fields',array( 'clearbooking_reserve_custom_posts_meta', 'clearbooking_reserve_add_ons_install' ),'clearbooking_add_ons', 'normal', 'high');


  }


 
public static function clearbooking_reserve_rooms_install($cb_rooms)
  

  {
    

 $room_name = esc_attr( get_post_meta( $cb_rooms->ID, 'room_name', true ) );

 $room_description = esc_attr( get_post_meta( $cb_rooms->ID, 'room_description', true ) );

 $room_occupancy = esc_attr( get_post_meta( $cb_rooms->ID, 'room_occupancy', true ) );

 $room_price_thousands = esc_attr( get_post_meta( $cb_rooms->ID, 'room_price_thousands', true ) );

 $room_price_cents = esc_attr( get_post_meta( $cb_rooms->ID, 'room_price_cents', true ) );
   


?>
   
<table id='rooms_meta_box'> 
 

<?php wp_nonce_field( 'clearbooking_post_nonce', 'clearbooking_post_security_check' ); ?>

<tr> <td><label> Name &nbsp;
 </label> </td> <td><input id="room_name" class="form-control" type="text" placeholder="" name="room_name" value="<?php echo $room_name; ?>"/> </td></tr>

<tr> <td><label>Description &nbsp;
</label> </td> <td><textarea id="room_description" class="form-control" type="text" placeholder="" name="room_description" value="<?php echo $room_description; ?>" resize="none"/> </textarea></td></tr>

<tr> <td> <label>Occupancy &nbsp;
</label></td> <td><select id="room_occupancy" class="form-control" type="text" placeholder="" name="room_occupancy" value="<?php echo $room_occupancy; ?>" />

<?php 


for ($x = 1; $x <= 20; $x++) 


{

  if($room_occupancy == $x) 

  {

   
       echo "<option value='".$x."' selected>".$x."</option>";



  }
  else
  {


      echo "<option value='".$x."'>".$x."</option>";


  }


}  

?>

</select> </td></tr>

<tr> <td> <label>Price &nbsp;
</label></td> <td> <input id="price" name="room_price_thousands" class="form-control" type="text" placeholder="0000" value="<?php echo $room_price_thousands; ?>" size='4'/>.<input id="cents" name="room_price_cents" class="form-control" type="text" placeholder="00" value="<?php echo $room_price_cents; ?>" size='2'/>-<input id="domination" name="domination" class="form-control" type="text" value="<?php echo $room_price_domination; ?>" size='3'/></td></tr>



</table>


<?php

}

   
        public static function clearbooking_reserve_add_ons_install($cb_add_ons)
  

  {
    

 $add_on_name = esc_attr( get_post_meta( $cb_add_ons->ID, 'add_on_name', true ) );

 $add_on_description = esc_attr( get_post_meta( $cb_add_ons->ID, 'add_on_description', true ) );

 $add_on_frequency = esc_attr( get_post_meta( $cb_add_ons->ID, 'add_on_frequency', true ) );

 $add_on_price_thousands = esc_attr( get_post_meta( $cb_add_ons->ID, 'add_on_price_thousands', true ) );

 $add_on_price_cents = esc_attr( get_post_meta( $cb_add_ons->ID, 'add_on_price_cents', true ) );
   


?>
   
<table id='rooms_meta_box'> 
 

<?php wp_nonce_field( 'clearbooking_post_nonce', 'clearbooking_post_security_check' ); ?>

<tr> <td><label> Name &nbsp;
 </label> </td> <td><input id="room_name" class="form-control" type="text" placeholder="" name="add_on_name" value="<?php echo $add_on_name; ?>"/> </td></tr>

<tr> <td><label>Description &nbsp;
</label> </td> <td><textarea id="add_on_description" class="form-control" type="text" placeholder="" name="add_on_description" value="<?php echo $add_on_description; ?>" resize="none"/> </textarea></td></tr>


<tr> <td> <label>Frequency &nbsp;

</label> </td> <td> <select id="add_on_frequency" class="form-control" type="text" placeholder="" name="add_on_frequency" value="<?php echo $add_on_frequency; ?>" />

<option value=''>  </option>

<option value='night' <?php if($add_on_frequency == 'night'){echo "selected";} ?>  >per night </option>

<option value='room' <?php if($add_on_frequency == 'room'){echo "selected";} ?>   >per room </option>

<option value='person' <?php if($add_on_frequency == 'person' ){echo "selected";} ?> >per person  </option>


</select> </td> </tr>


<tr> <td> <label>Price &nbsp;
</label></td> <td> <input id="price" name="add_on_price_thousands" class="form-control" type="text" placeholder="0000" value="<?php echo $add_on_price_thousands; ?>" size='4'/>.<input id="cents" name="add_on_price_cents" class="form-control" type="text" placeholder="00" value="<?php echo $add_on_price_cents; ?>" size='2'/>-<input id="domination" name="domination" class="form-control" type="text" value="<?php echo $room_price_domination; ?>" size='3'/></td></tr>



</table>

    <?php

}

public static function clearbooking_reserve_coupons_install($cb_coupons)
  

  {
    

 $coupon_name = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_name', true ) );

 $coupon_description = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_description', true ) );

 $coupon_discount = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_discount', true ) );

 $coupon_valid = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_valid', true ) );

 $coupon_expiry = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_expiry', true ) );

 $coupon_token = esc_attr( get_post_meta( $cb_coupons->ID, 'coupon_token', true ) );

?>
   
<table id='coupons_meta_box'> 
 

<?php wp_nonce_field( 'clearbooking_post_nonce', 'clearbooking_post_security_check' ); ?>

<tr> <td><label> Name &nbsp;
 </label> </td> <td><input id="coupon_name" class="form-control" type="text" placeholder="" name="coupon_name" value="<?php echo $coupon_name; ?>"/> </td></tr>

<tr> <td><label>Description &nbsp;
</label> </td> <td><textarea id="coupon_description" class="form-control" type="text" placeholder="" name="coupon_description" value="<?php echo $coupon_description; ?>" resize="none"/> </textarea></td></tr>

<tr> <td> <label>Discount &nbsp;
</label></td> <td><select id="coupon_discount" class="form-control" type="text" placeholder="" name="coupon_discount" value="<?php echo $coupon_discount; ?>"/>

<?php 


for ($x = 1; $x <= 100; $x++) {


    if($coupon_discount == $x) 

  {

   
       echo "<option value='".$x."' selected>".$x."</option>";



  }
  else
  {


      echo "<option value='".$x."'>".$x."</option>";


  }


}  

?>

</select> %
</td></tr>

<tr> <td> <label> Code &nbsp;
</label></td> <td> <input id="coupon_token" name="coupon_token" class="form-control" type="text" placeholder="" value="<?php echo $coupon_token; ?>" /></td></tr>


<tr> <td> <label>Valid Date &nbsp;
</label></td> <td> <input id="coupon_valid" name="coupon_valid" class="form-control" type="text" placeholder="" value="<?php echo $coupon_valid; ?>"/></td></tr>


<tr> <td> <label>Expiry Date &nbsp;
</label></td> <td> <input id="coupon_expiry" name="coupon_expiry" class="form-control" type="text" placeholder="" value="<?php echo $coupon_expiry; ?>" /></td></tr>

<script type="text/javascript">

            jQuery(document).ready(function() {

jQuery(function() {

                jQuery('#coupon_valid').datepicker({
                   
      defaultDate: "+1w",
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {

        $( "#coupon_expiry" ).datepicker( "option", "minDate", selectedDate );

      }


                });

            jQuery('#coupon_expiry').datepicker({
                   
      defaultDate: "+1w",
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {

        $( "#coupon_valid" ).datepicker( "option", "maxDate", selectedDate );

      }


                });

            });

        });

        </script>    

</table>

    <?php

  }



public static function clearbooking_reserve_custom_posts_meta_save($post_id,$post,$update) {


$slug = 'cb_rooms';


$slug1 = 'cb_coupons';


$slug2 = 'cb_add_ons';


if ( get_post_status($post_id) === 'publish' && $slug1 === $post->post_type )


{


if ( 
    ! isset( $_POST['clearbooking_post_security_check'] ) 
    || ! wp_verify_nonce( $_POST['clearbooking_post_security_check'], 'clearbooking_post_nonce' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {



if ( isset( $_REQUEST['coupon_name'] ) ) {
        update_post_meta( $post_id, 'coupon_name', sanitize_text_field( $_REQUEST['coupon_name'] ) );
    }else{ wp_die( 'Please enter a name for this coupon', '' ) ; }

if ( isset( $_REQUEST['coupon_description'] ) ) {
        update_post_meta( $post_id, 'coupon_description', sanitize_text_field( $_REQUEST['coupon_description'] ) );
    }else{ wp_die( 'Please enter a description for this coupon', '' ) ; }

if ( isset( $_REQUEST['coupon_discount'] ) ) {
        update_post_meta( $post_id, 'coupon_discount', sanitize_text_field( $_REQUEST['coupon_discount'] ) );
    }else{ wp_die( 'Please select a discount amount ', '' ) ; }

if ( isset( $_REQUEST['coupon_valid'] ) ) {
        update_post_meta( $post_id, 'coupon_valid', sanitize_text_field( $_REQUEST['coupon_valid'] ) );
    }else{ wp_die( 'Please enter a start date ', '' ) ; }

if ( isset( $_REQUEST['coupon_expiry'] ) ) {
        update_post_meta( $post_id, 'coupon_expiry', sanitize_text_field( $_REQUEST['coupon_expiry'] ) );
    }else{ wp_die( 'Please enter an expiry date ', '' ) ; }


$date = str_replace('/', '-', $_REQUEST['coupon_valid']);

$coupon_valid = date('Y-m-d', strtotime($date));

$date1 = str_replace('/', '-', $_REQUEST['coupon_expiry']);

$coupon_expiry = date('Y-m-d', strtotime($date1));


$coupon_name= get_post_meta($post_id, 'coupon_name', true);



global $wpdb;

$table_name = $wpdb->prefix . 'cb_coupons';



if($wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = '$post_id' " ) != 0 )

{


  

        $wpdb->update( 
  $table_name, 
  array( 
            'name' => $_REQUEST['coupon_name'], 
      'description' => $_REQUEST['coupon_description'], 
      'amount' => $_REQUEST['coupon_discount'], 
                        'validdate' => $coupon_valid, 
                        'exdate' => $coupon_expiry, 
                        'token' => $_REQUEST['coupon_token'], 
                        
  ), 
  array( 'post_id' => $post_id )
  
);




}

else

{


  
  $wpdb->insert( 
    $table_name, 
    array( 

      'name' => $_REQUEST['coupon_name'], 
      'description' => $_REQUEST['coupon_description'], 
      'amount' => $_REQUEST['coupon_discount'], 
                        'validdate' => $coupon_valid, 
                        'exdate' => $coupon_expiry, 
                        'token' => $_REQUEST['coupon_token'], 
                        'post_id' => $post_id, 
    ) 

  );



}
       


}




}



if ( get_post_status($post_id) === 'publish' && $slug2 === $post->post_type )


{



if ( 
    ! isset( $_POST['clearbooking_post_security_check'] ) 
    || ! wp_verify_nonce( $_POST['clearbooking_post_security_check'], 'clearbooking_post_nonce' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {



$add_on_name= get_post_meta($post_id, 'add_on_name', true);


if ( isset( $_REQUEST['add_on_name'] ) && $_POST['add_on_name'] != '' ) {
        update_post_meta( $post_id, 'add_on_name', sanitize_text_field( $_REQUEST['add_on_name'] ) );
    }else{ wp_die( 'Please enter a name for this amenity ', '' ) ; }

if ( isset( $_REQUEST['add_on_description'] ) && $_POST['add_on_description'] != '' ) {
        update_post_meta( $post_id, 'add_on_description', sanitize_text_field( $_REQUEST['add_on_description'] ) );
    }else{ wp_die( 'Please enter a description for this amenity ', '' ) ; }

if ( isset( $_REQUEST['add_on_price_thousands'] ) && $_POST['add_on_price_thousands'] != '' ) {
        update_post_meta( $post_id, 'add_on_price_thousands', sanitize_text_field( $_REQUEST['add_on_price_thousands'] ) );
    }else{ wp_die( 'Please enter the amount for this room ', '' ) ; }

if ( isset( $_REQUEST['add_on_price_cents'] ) && $_POST['add_on_price_cents'] != '' ) {
        update_post_meta( $post_id, 'add_on_price_cents', sanitize_text_field( $_REQUEST['add_on_price_cents'] ) );
    }else{ wp_die( 'Please enter the pence / cents for this amenity', '' ) ; }
    

if ( isset( $_REQUEST['add_on_frequency'] ) && $_POST['add_on_frequency'] != '' ) {
        update_post_meta( $post_id, 'add_on_price_cents', sanitize_text_field( $_REQUEST['add_on_frequency'] ) );
    }else{ wp_die( 'Please enter the frequency  for this amenity', '' ) ; }


global $wpdb;

$table_name = $wpdb->prefix . 'cb_add_ons';



if($wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = '$post_id' " ) != 0 )

{
 
        $cb_add_on_price = $_REQUEST['add_on_price_thousands'].'.'.$_REQUEST['add_on_price_cents'];


  
        $wpdb->update( 
  $table_name, 
  array( 
            'name' => $_REQUEST['add_on_name'], 
      'description' => $_REQUEST['add_on_description'], 
      'frequency'=>$_REQUEST['add_on_frequency'],
                        'price' => $cb_add_on_price, 
                        'post_id' => $post_id, 
  ), 
  array( 'post_id' => $post_id )
  
        );



}
else
{


  
        $cb_add_on_price = $_REQUEST['add_on_price_thousands'].'.'.$_REQUEST['add_on_price_cents'];

 
  


  $wpdb->insert( 
    $table_name, 
    array( 
      'name' => $_REQUEST['add_on_name'], 
      'description' => $_REQUEST['add_on_description'], 
                        'frequency'=>$_REQUEST['add_on_frequency'],
                        'price' => $cb_add_on_price, 
                      
    ) 

  );


}
    

        }
    
}


if ( get_post_status($post_id) === 'publish' && $slug === $post->post_type )


{


        
if ( 
    ! isset( $_POST['clearbooking_post_security_check'] ) 
    || ! wp_verify_nonce( $_POST['clearbooking_post_security_check'], 'clearbooking_post_nonce' ) 
) {

   print 'Sorry, your nonce did not verify.';
   exit;

} else {



if ( isset( $_REQUEST['room_name'] ) && $_POST['room_name'] != '' ) {
        update_post_meta( $post_id, 'room_name', sanitize_text_field( $_REQUEST['room_name'] ) );
    }else{ wp_die( $wpdb->prefix . 'cb_rooms', '' ) ; }

if ( isset( $_REQUEST['room_description'] ) && $_POST['room_description'] != '' ) {
        update_post_meta( $post_id, 'room_description', sanitize_text_field( $_REQUEST['room_description'] ) );
    }else{ wp_die( 'Please enter a description for this room ', '' ) ; }

if ( isset( $_REQUEST['room_occupancy'] ) && $_POST['room_occupancy'] != '') {
        update_post_meta( $post_id, 'room_occupancy', sanitize_text_field( $_REQUEST['room_occupancy'] ) );
    }else{ wp_die( 'Please select the total adult occupancy for this room ', '' ) ; }

if ( isset( $_REQUEST['room_price_thousands'] ) && $_POST['room_price_thousands'] != '' ) {
        update_post_meta( $post_id, 'room_price_thousands', sanitize_text_field( $_REQUEST['room_price_thousands'] ) );
    }else{ wp_die( 'Please enter the amount for this room ', '' ) ; }

if ( isset( $_REQUEST['room_price_cents'] ) && $_POST['room_price_cents'] != '' ) {
        update_post_meta( $post_id, 'room_price_cents', sanitize_text_field( $_REQUEST['room_price_cents'] ) );
    }else{ wp_die( 'Please enter the pence for this room', '' ) ; }

$room_name= get_post_meta($post_id, 'room_name', true);

global $wpdb;

$table_name = $wpdb->prefix . 'cb_rooms';



if($wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = '$post_id' " ) != 0 )

{




      
 
  $cb_room_price = $_REQUEST['room_price_thousands'].'.'.$_REQUEST['room_price_cents'];


  
  $wpdb->update( $table_name, 
  array( 
      'name' => $_REQUEST['room_name'], 
      'description' => $_REQUEST['room_description'], 
      'occupancy' => $_REQUEST['room_occupancy'], 
      'price' => $cb_room_price, 
      'post_id' => $post_id, 
  ), 
  array( 'post_id' => $post_id )
  
        );



}
else
{

  
  $cb_room_price = $_REQUEST['room_price_thousands'].'.'.$_REQUEST['room_price_cents'];


  
  $wpdb->insert( $table_name,
      array( 
      'name' => $_REQUEST['room_name'], 
      'description' => $_REQUEST['room_description'], 
      'occupancy' => $_REQUEST['room_occupancy'], 
      'price' => $cb_room_price, 
      'post_id' => $post_id, 
      ) 

  );


}
    


    


}


}


}




}
 
?>