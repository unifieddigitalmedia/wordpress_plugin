<?php


if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserve_filters 

{
 


 

public static function clearbooking_reservation_details_($content) {



 if( is_page(get_option("cb_cancel_page")))

{

  global $wpdb;

  $table_name = $wpdb->prefix . 'cb_reservations';
  
  $wpdb->delete( $table_name, array( 'resid' => $_REQUEST[reservationID] ) );


  $table_name = $wpdb->prefix . 'cb_bookings';

  $wpdb->delete( $table_name, array( 'resid' => $_REQUEST[reservationID] ) );

  return $content;

}

else if ( is_page(get_option("cb_checkout_page") ) ) {


return $content;

}

else if ( is_page( get_option('cb_details_page') ) ||  is_page(get_option("cb_confirmation_page") ) ) {
       
  
   global $wpdb;


   $table_name = $wpdb->prefix . 'cb_reservations';
   

   $resID = $wpdb->get_row( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[reservationID]' " );



$value =  $resID->fromdate ;
$day =  substr("$value",8,2);
$month = substr("$value",5,2);
$year =  substr("$value",0,4);
$date = $day."/".$month."/".$year;


$value =  $resID->todate ;
$day =  substr("$value",8,2);
$month = substr("$value",5,2);
$year =  substr("$value",0,4);
$date1 = $day."/".$month."/".$year;

$tax = $resID->tax ;
if(is_page( get_option('cb_confirmation_page')  ))
{

$tlt = 'Your Reservation Confirmation';


}
else if( is_page(get_option("cb_details_page")))
{

$tlt = 'Your Reservation Details';

}

  
$content  .= '<body >



                   <h1>'. $tlt .'</h1>

                   <div id="rescontent" role="main" class="container-fluid">

                   <div class="row" >
  
                   <div class="col-sm-5">  

                   <div class="row" >

                   <div class="col-sm-12" >

                   <h4 class="resDetails_header">'.'-'.$date.' - to - '.$date1.'</h4>

                   </div>

                   </div>';


                     $table_name = $wpdb->prefix . 'cb_bookings';

                   $rms_results = $wpdb->get_results( "SELECT rid FROM $table_name WHERE resid = '$_REQUEST[reservationID]' " );
$subtotal = 0;


                   foreach ( $rms_results as $rms_result ) 
                   
                   {


                   $table_name = $wpdb->prefix . 'cb_rooms';

                   $rms = $wpdb->get_row( "SELECT * FROM $table_name WHERE rid = '$rms_result->rid' " );


$content    .= '<div class="row" >

             <div class="col-sm-6">'.

             $rms->description

             .'</div>

             <div class="col-sm-3" >

             '.$resID->lengthofstay.' days @'.$rms->price.'/night

             </div>

             <div class="col-sm-3" >

             '.number_format($rms->price*$resID->lengthofstay, 2, '.', ',').'

             </div>

             </div>';

$subtotal = $subtotal + $rms->price*$resID->lengthofstay;

}

$content    .= '<h4 class="resDetails_header" >Amenities </h4>';


$table_name = $wpdb->prefix . 'cb_reservation_add_ons';

$addonsID = $wpdb->get_results( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[reservationID]' " );

$addons = 0;

foreach ( $addonsID as $addonID ) 

{

$table_name = $wpdb->prefix . 'cb_add_ons';

$addonsDes = $wpdb->get_row( "SELECT * FROM $table_name WHERE aid = '$addonID->aid' " );

$content    .= '<div class="row">

             <div class="col-sm-6">'.

             $addonsDes->name

             .'</div>

             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3" >'.number_format($addonID->amount,2, '.', ',')
              .'

             </div>

             </div>';


$addons  = $addons + $addonID->amount;


}

$content    .= '<h4 class="resDetails_header" >Offers </h4>';

$discount = 0;

$table_name = $wpdb->prefix . 'cb_reservation_coupons';

$cpnsID = $wpdb->get_results( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[reservationID]' " );

$total = $resID->roomtotal;

foreach ( $cpnsID as $cpnID ) 

{

$table_name = $wpdb->prefix . 'cb_coupons';

$cpnsDes = $wpdb->get_row( "SELECT * FROM $table_name WHERE cid = '$cpnID->cid' " );

$content    .= '


             <div class="row">

             <div class="col-sm-6">'.

             $cpnsDes->name

             .'</div>

             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3" >('.

             (($total * $cpnsDes->amount)/100).')

             </div>

             </div>';

$total = $total - (($total * $cpnsDes->amount)/100);

$discount = $discount + (($total * $cpnsDes->amount)/100);

}

$content    .= '<h4 class="resDetails_header" >Personal Details </h4>

             <div class="row"  >

             <div class="col-sm-6">

             First Name :

             </div>

             <div class="col-sm-6">'.

             $resID->firstname

             .'</div>

             </div>';

$content    .= '<div class="row"  >

             <div class="col-sm-6">

             Last Name :

             </div>

             <div class="col-sm-6">'.

             $resID->lastname

             .'</div>

             </div>';

$content    .= '<div class="row"  >

             <div class="col-sm-6">

             Phone :

             </div>

             <div class="col-sm-6">'.

             $resID->phone 

             .'</div>

             </div>';

$content    .= '<div class="row"  >

             <div class="col-sm-6">

             Email :

             </div>

             <div class="col-sm-6">'.

             $resID->email

             .'</div>

             </div>';

$content    .= ' <h4 class="resDetails_header">Dependents </h4>

              <div class="row" >

              <div class="col-sm-6" >

              Adults :

              </div>

              <div class="col-sm-6">'.

              $resID->adults

              .'</div>

              

              </div>';


$content    .= ' 
              <div class="row" >

              <div class="col-sm-6" >

              Children :

              </div>

              <div class="col-sm-6">'.

              $resID->children

              .'</div>

              

              </div>';


$content    .= ' 

              <div class="row" >

              <div class="col-sm-6" >

              Infants :

              </div>

              <div class="col-sm-6">'.

              $resID->infants

              .'</div>

              

              </div>';



$content    .= '<h4 class="resDetails_header"> TOTAL</h4> 

<div class="row" >
             <div class="col-sm-6">

             <p>  Tax </p>
             </div>

             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3">

             <p> '.number_format($tax, 2, '.', ',').'</p>

             </div>

             </div>

              <div class="row" >
             <div class="col-sm-6" >

            

             </div>
             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3" >

             <p>'. $resID->total .'</p>

             </div>

             </div>



';


$confirm_page = get_option("cb_confirmation_page");


$thank_you_page = get_option("cb_thankyou_page");


 if ( is_page(get_option("cb_confirmation_page") ) ) 

{


$content    .= '</div>
 <div class="col-sm-2"> 
</div>

             <div class="col-sm-5" style="vertical-align:middle;text-align:center;"> 

       <div class="row" >

                   <div class="col-sm-12" >

                

                   </div>

                   </div>




<h3> <a href="../thank-you/" > click here to continue </a> </h3>
</div>

             </div> </div>
      
                   </body>';

} else {




$table_name = $wpdb->prefix . 'cb_bookings';

$deposit = 0;

$rooms = $wpdb->get_results( "SELECT rid FROM $table_name WHERE resid = '$_REQUEST[reservationID]'");



$table_name = $wpdb->prefix . 'cb_rooms';

foreach ( $rooms as $room ) 

{



$room_price = $wpdb->get_row( "SELECT price FROM $table_name WHERE rid = '$room->rid'");


$deposit = $deposit + $room_price->price;


}



$d_policy = get_option('d_policy');

$c_policy = get_option('cb_cancel_policy');

$r_policy = get_option('cb_refund_policy');

$deposit_policy = cal_amt_to_pay($_REQUEST[reservationID],$deposit);

$checkout_page = get_option('cb_checkout_page');


 $content    .='</div>
              <div class="col-sm-2"> 
</div>

             <div class="col-sm-5" style="vertical-align:middle;"> 


<div class="row" >

                   <div class="col-sm-12" >

                  <h4 class="resDetails_header">Summary </h4>

                   </div>

                   </div>





<div class="row">
 
  <div class="col-sm-4">Period</div>
  <div class="col-sm-2">Sub Total</div>
  <div class="col-sm-2">Discount</div>
  <div class="col-sm-2">Amenities</div>
  <div class="col-sm-2">Tax</div>

</div>
<div class="row">
 
  <div class="col-sm-4">'.$date.' - '.$date1.'</div>
  <div class="col-sm-2">'.number_format($subtotal, 2, '.', ',').'</div>
  <div class="col-sm-2">('.number_format($discount, 2, '.', ',').')</div>
  <div class="col-sm-2">'.number_format($addons, 2, '.', ',').'</div>
  <div class="col-sm-2">'.number_format($tax, 2, '.', ',').'</div>

</div>
<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  <div class="col-sm-2">Total</div>
  <div class="col-sm-2">'.number_format($resID->total, 2, '.', ',').'</div>

</div>

<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  <div class="col-sm-2"></div>
  
  <div class="col-sm-4"> 



                <form   id="myContainer" method="GET" action="'.$checkout_page.'">
        
                <input  type="hidden" name="deposit" value="'.$deposit.'">

                 <input  type="hidden" name="fullamount" value="'.$resID->total.'">
  
                <input  type="hidden" name="reservationID" value="'.$_REQUEST[reservationID].'">

                <input  type="hidden" name="CHECKOUT" value="SUBMIT">

                <button type="subit" class="btn btn-default">Continue to checkout</button>
                
                </form>


  </div>

  </div>


&nbsp;


<h4>DEPOSIT POLICY:</h4>

&nbsp;
<p style="text-align:left;">$'.$deposit_policy.'</p>  

&nbsp;

<h4>CANCELLATION, NO-SHOW AND REFUND POLICIES:</h4>
&nbsp;
<p>'.$c_policy.'</p>  
&nbsp;
<p>'.$r_policy.'</p>      
               
    
&nbsp;
         
                </div>

                </div>
               

                </body>




';



}

 return $content;

      wp_die();

    }
else if(is_page( get_option('cb_reservation_page') ))

{


  
   global $wpdb;


$from = $_REQUEST[from];

 $content  .= '<body onload="checkavailability()">

  

<div class="row" ng-hide="availabilty">

<div class="col-sm-3" id="checkavaiabiltyrow" >

<div class="form-group has-success has-feedback" style="text-align:right;">

<h3> Reserve online </h3>


</div> 



</div>



<div class="col-sm-2" id="checkavaiabiltyrow">

<div class="form-group has-success has-feedback">

<input type="text" class="form-control"  id="fromdate" placeholder="'.$_REQUEST[from].'" data-id="'.$_REQUEST[from].'"> 

<span class="glyphicon glyphicon-th form-control-feedback"></span> 

</input> 

</div>

</div>

<div class="col-sm-2" id="checkavaiabiltyrow" >

<div class="form-group has-success has-feedback">

<input type="text" class="form-control" id="todate" placeholder="'.$_REQUEST[to].'" data-id="'.$_REQUEST[to].'"> 

<span class="glyphicon glyphicon-th form-control-feedback"></span>  

</input> 

</div>

</div>


<div class="col-sm-2" id="checkavaiabiltyrow" >

<div class="form-group has-success has-feedback">

<input id="promo" class="form-control" type="text" placeholder="PROMO CODE" name="promo"  data-id="'.$_REQUEST[promo].'"> 

<span class="glyphicon glyphicon-qrcode form-control-feedback"></span>

</div>

</div>

<div class="col-sm-3" id="checkavaiabiltyrow" >

<div class="form-group has-success has-feedback">
<button class="btn btn-default btn-block" type="button" id="checkavailability" >CHECK AVAILABILITY</button> 

<span ></span>
</div>

</div>

</div>

</div>

<div id="errormessage" class="checking"> <p id="error">  </p> </div>

<div class="row" id="calenderrow">
<div class="col-sm-6" id="frommonth">

</div>

<div class="col-sm-6" id="tomonth">

</div>


</div>

<div class="row" >


   <div class="col-sm-6"> 

   <div class="row" id="availablecol">

   <div class="col-sm-12" > 
  
   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Available rooms<p> </div>  </div>

   <div class="arooms" > </div>

   

   
   </div>
   
   </div>



   <div class="row" id="availablecoloffs">

   <div class="col-sm-12"> 
  
   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Offers <p> </div>  </div>
   
   <div class="acpns"> </div>


   </div>
   
   </div>



  </div>





  <div class="col-sm-6">


   <div class="row" id="bookingcol">

   <div class="col-sm-12"> 
  
   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Your booking<p> </div>  </div>

   <div class="bkng" >  </div> 

   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Discounts<p> </div>  </div>

   <div class="bkngcpt" >  </div>

   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Add ons<p> </div>  </div>
   <div class="bkngaddons"> </div>

  &nbsp;
  <div class="row" >
  <div class="col-sm-6" >

  Do you have a planned trip code 

  </div>
  <div class="col-sm-6" >

  <p>  </p>

  </div>


  </div>
  &nbsp;
  <div class="row" >
  <div class="col-sm-4" >

  <div class="row" >
  <div class="col-sm-6"> <label><input type="radio" name="plannedtrip" class="trip" value="yes" >&nbsp;Yes&nbsp;</label></div>
  <div class="col-sm-6"> <label><input type="radio" name="plannedtrip" class="trip" value="no">&nbsp;No&nbsp;</label></div>

   </div>

   </div>
   <div class="col-sm-8">

   <p>  </p>

   </div>

   </div>
&nbsp;

   <div class="row" id="plannedtripcodediv" >
   <div class="col-sm-6" >

   <div class="row"  >

   <div class="form-group">

   PLANNED TRIP CODE:

   <input type="text" class="form-control" id="plannedtrip" name="plannedtrip" value="'.$_REQUEST[token].'" >

   </div>

   </div>

   </div>

   <div class="col-sm-6">

   <p>  </p>

   </div>

   </div>
  <div class="row" id="toprow" > 

  <div class="col-sm-6"> <p><p> </div> 

  <div class="col-sm-3"> <p><p> </div>

  <div class="col-sm-3"> <p><button class="btn btn-default btn-block" type="button"  id="chkrates"> CONTINUE</button><p>     </div>  

  </div>

  </div>
  </div>




   <div class="row" id="ratescol">

   <div class="col-sm-12"> 
  
   <div class="row"id="toprow" > <div class="col-sm-12"> <p>Rates<p> </div>  </div>

   <div> </div>

   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Rooms<p> </div>  </div>

   <div class="rtsrms"> </div>

   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Add ons<p> </div>  </div>

   <div class="rtsaddons">  </div>

  

   <div class="row" id="toprow"> <div class="col-sm-12"> <p>Offer<p> </div>  </div>
   <div class="rtsoffs"> </div>
   <div class="row" id="firstinnerrow"> <div class="col-sm-6">  <p>Tax<p> </div> <div class="col-sm-3"> <p><p> </div><div class="col-sm-3"> <p class="taxamt" ><p> </div>  </div>
   <div> </div>
   <div class="row" id="toprow"> <div class="col-sm-6"> <p>Total<p> </div> <div class="col-sm-3"> <p><p> </div><div class="col-sm-3"> <p class="rtstlt"><p> </div>  </div>
   <div> </div>

   <div class="row" id="toprow"> <div class="col-sm-6"> <p><p> </div> <div class="col-sm-3"> <p><p> </div><div class="col-sm-3"> <p><button class="btn btn-default btn-block" type="button" id ="totalid" > CONTINUE</button><p> </div>  </div>
   </div>
   
   </div>';


 $r = get_option('cb_details_page');


$content    .= '   <form action="../'.$r .'/" method="post" id="detailsform" class="detailsform" name="detailsform">
   <div class="row" id="detailscol">

   <div class="col-sm-12"  > 
  
   <div class="row" id="firstinnerrow"> 

   <div class="col-sm-6"> <input type="text" class="form-control" id="resfirstname" placeholder="Enter first name" >  </div> 


   <div class="col-sm-6"> <input type="text" class="form-control" id="reslastname" placeholder="Enter last name" >  </div>  

   
   </div>


   <div class="row" id="firstinnerrow"> 

   <div class="col-sm-6"> <input type="text" class="form-control" id="resphone" placeholder="Enter phone" >  </div> 


   <div class="col-sm-6"> <input type="text" class="form-control" id="resemail" placeholder="Enter email" >  </div>  

   
   </div>

   <span id="detailserror">  </span>

  



   <div class="row" id="firstinnerrow"> ';


$r = get_option('cb_terms_page');




$content    .= '<div class="row" id="firstinnerrow"> 

   <div class="col-sm-12"> <label><input type="checkbox" id="ckhterms" > You must agree to the terms of our villa <a href="../'.$r.'/" > here</a> to stay with us </label> </div> 


  

   
   </div>

   

   <div class="row" id="toprow"> 

   <div class="col-sm-6">  </div> 


   <div class="col-sm-6"> <button type="button" class="btn btn-default btn-block" id="chkbtn" name="resID" >CONTINUE</button> </div>  

   
   </div>

   <input type="hidden" name="reservationID" id="chkbtn" class="chkbtn" >


</form>


   </div>
   
   </div>








   </div>





</div> </body>';

 return $content;

}
   else {

 
        return $content;

    }




}





}

function cal_amt_to_pay($resID,$deposit) {



global $wpdb;

$table_name = $wpdb->prefix . 'cb_reservations';

$res = $wpdb->get_row("SELECT * FROM $table_name WHERE resid = '$resID' " );

$value =  $res->fromdate ;

$month = substr("$value",5,2);

$day =  substr("$value",8,2);

$todaysdate = date('Y-m-d');

$d_policy = get_option('cb_deposit_policy');


 

    
    $arrivalDate =date('Y-m-d', strtotime($res->fromdate));;
    
   
    $RegularBegin = date('Y-m-d', strtotime("04/20/2016"));
    $RegularEnd = date('Y-m-d', strtotime("12/14/2016"));


    $HighBegin = date('Y-m-d', strtotime("01/01/2016"));
    $HighEnd = date('Y-m-d', strtotime("04/19/2016"));

    $SecondHighBegin = date('Y-m-d', strtotime("12/15/2016"));
    $SecondHighEnd = date('Y-m-d', strtotime("12/31/2016"));



if(($arrivalDate > $RegularBegin) && ($arrivalDate < $RegularEnd) )

{



$timeperiod = date('Y-m-d', strtotime('-21 days'));

$deadline = date('Y-m-d', strtotime('-14 days'));

if($todaysdate >= $timeperiod )

{

$days = caldifference($deadline,$todaysdate);


 if($days > 0)
{

$deposit_policy = $deposit.' USD '.$d_policy;


return $deposit_policy;


}
else 

{

$deposit_policy = $res->total.' USD will need to be paid to keep this booking as stated in our policy below';

return $deposit_policy;


}
 


}



}
else if(($arrivalDate > $HighBegin) && ($arrivalDate < $HighEnd) )

{


$timeperiod = date('Y-m-d', strtotime('-37 days'));



$deadline = date('Y-m-d', strtotime('-30 days'));




if(($todaysdate >= $timeperiod))

{


$days = caldifference($deadline,$todaysdate);


 if($days > 0)

{

$deposit_policy = $deposit.' USD '.$d_policy;


return $deposit_policy;


}
else 

{

$deposit_policy = $res->total.' USD will need to be paid to keep this booking as stated in our policy below';

return $deposit_policy;


}
 
 


}



}

else if(($arrivalDate > $SecondHighBegin) && ($arrivalDate < $SecondHighEnd))

{


    $timeperiod = date('Y-m-d', strtotime('-67 days'));
 
    $deadline = date('Y-m-d', strtotime('-60 days'));

if($todaysdate >= $timeperiod)

{

$days = caldifference($deadline,$todaysdate);

if($days > 0)
{

$deposit_policy = $deposit.' USD '.$d_policy;


return $deposit_policy;


}
else 

{

$deposit_policy = $res->total.' USD will need to be paid to keep this booking as stated in our policy below';

return $deposit_policy;


}
 



}



}




}

function caldifference ($deadline,$today) {


   $diff = abs(strtotime($deadline) - strtotime($today));

   $years = floor($diff / (365*60*60*24));

   $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

   $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));


   return $days;

}


function cal_deposit($resID) {


global $wpdb;

$table_name = $wpdb->prefix . 'cb_reservations';

$res = $wpdb->get_row("SELECT * FROM $table_name WHERE resid = '$resID' " );

$value =  $res->fromdate ;

$month = substr("$value",5,2);

$day =  substr("$value",8,2);

$todaysdate = date('Y-m-d');

$d_policy = get_option('cb_deposit_policy');


 

    
    $arrivalDate =date('Y-m-d', strtotime($res->fromdate));;
    
   
    $RegularBegin = date('Y-m-d', strtotime("04/20/2016"));
    $RegularEnd = date('Y-m-d', strtotime("12/14/2016"));


    $HighBegin = date('Y-m-d', strtotime("01/01/2016"));
    $HighEnd = date('Y-m-d', strtotime("04/19/2016"));

    $SecondHighBegin = date('Y-m-d', strtotime("12/15/2016"));
    $SecondHighEnd = date('Y-m-d', strtotime("12/31/2016"));



if(($arrivalDate > $RegularBegin) && ($arrivalDate < $RegularEnd) )

{


$table_name = $wpdb->prefix . 'cb_bookings';

$deposit = 0;

$rooms = $wpdb->get_results( "SELECT rid FROM $table_name WHERE resid = '$_REQUEST[reservationID]'");

$table_name = $wpdb->prefix . 'cb_rooms';

foreach ( $rooms as $room ) 

{

$room_price = $wpdb->get_row( "SELECT price FROM $table_name WHERE rid = '$room->rid'");


$deposit = $deposit + $room_price->price;


}


return $deposit;

}
else if(($arrivalDate > $HighBegin) && ($arrivalDate < $HighEnd)) {



return $res->total;

}

else if(($arrivalDate > $SecondHighBegin) && ($arrivalDate < $SecondHighEnd)) {


return $res->total;

}

}


?>