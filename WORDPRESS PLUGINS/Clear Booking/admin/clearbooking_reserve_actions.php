<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_reserve_actions

{
  
public function rooms_action() {


   $cont = array();

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;

   $date = str_replace('/', '-', $_REQUEST[from]);

   $from = date('Y-m-d', strtotime($date));



   $date1 = str_replace('/', '-', $_REQUEST[to]);

   $to = date('Y-m-d', strtotime($date1));

   $table_name = $wpdb->prefix . 'cb_bookings';

   $cont = $wpdb->get_results( "SELECT rid FROM $table_name WHERE ('$from' BETWEEN `fromdate` AND `todate`) AND  ('$to' BETWEEN `fromdate` AND `todate`) AND status = 'R' " );
   
   $table_name1 = $wpdb->prefix . 'cb_rooms';

   if(sizeof($cont) == 0)

   { 


    

     $cont = $wpdb->get_results( "SELECT * FROM $table_name1" ); 

   
   

   } else 

   { 


$cont = $wpdb->get_results( "SELECT * FROM $table_name1 WHERE rid NOT IN (SELECT rid FROM $table_name WHERE ('$from' BETWEEN `fromdate` AND `todate`) AND  ('$to' BETWEEN `fromdate` AND `todate`) AND status = 'R' )" ); 


   }
   

foreach ( $cont as $con ) 


{


         $html .='

         <div id="firstinnerrow" >
         <div class="row" >
         <div class="col-sm-10">'.$con->name.'</div>
         <div class="col-sm-2"></div>
         </div>

         <div class="row" id="innerfirstinnerrow">
         <div class="col-sm-10">'.$con->description.'</div>
         <div class="col-sm-2">
         <p id="roombtn" type="button" value="'.$con->rid.'">ADD</p>
         </div>

         </div>
         </div>';



}





   echo $html;

   wp_die();


}





public function rooms_action_booking() {


   $cont = array();

   $outercont = array();

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;

   $table_name = $wpdb->prefix . 'cb_rooms';


foreach ($_REQUEST[bkng] as $value)

{


$cont = $wpdb->get_row( "SELECT * FROM $table_name WHERE rid = '$value[id]' " ); 



 $html .= '<div id="firstinnerrow"> <div class="row" >

<div class="col-sm-2">

<p>'. $cont->name .' </p>

</div>
<div class="col-sm-2">

<p>'. $cont->occupancy .'</p>

</div>
<div class="col-sm-2">

<p> 


<select  class="form-control" name="adults" >


<option value="1">1</option>
<option value="2">2</option>

</select> 


</p>

</div>
<div class="col-sm-2">

<p> 

<select  class="form-control" name="children" >

<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>


</select> 


</p>

</div>
<div class="col-sm-2">

<p> 

<select  class="form-control" name="infants" >

<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>


</select>  


</p>

</div>

<div class="col-sm-2">

<p class="bkngrmrmv" data-id="'.$cont->rid.'">REMOVE </p> 

</div>


</div></div>';



}


   array_push($outercont,$html);



   $table_name = $wpdb->prefix . 'cb_coupons';


foreach ($_REQUEST[bkngcpn] as $cpnval)

{


$cpnt = $wpdb->get_row( "SELECT * FROM $table_name WHERE cid = '$cpnval[id]' " ); 


$cpthtml .= '<div id="firstinnerrow"><div class="row" >

          <div class="col-sm-10">

          <p>'. $cpnt->name .' </p>

          </div>

          <div class="col-sm-2">

          <p> </p>

          </div>

          </div>

          <div class="row" >

          <div class="col-sm-10">

          <p> '.$cpnt->description.' </p>

          </div>
          <div class="col-sm-2">

          <p class="cptrmrmv" data-id="'.$cpnt->cid.'">REMOVE </p> 

          </div>

          </div></div>



';



}


   array_push($outercont,$cpthtml);


$table_name = $wpdb->prefix . 'cb_add_ons';


$addOns = $wpdb->get_results( "SELECT * FROM $table_name  " ); 


foreach ( $addOns as $addOn ) 


{

     
$addonhtml .= '

 </br>

  <div id="firstinnerrow">

  <div class="row" >

  <div class="col-sm-6" >

  Would you like '.$addOn->name.'

  </div>
  
  <div class="col-sm-6" >

  <p>  </p>

  </div>


  </div>
  
 
  <div class="row" >

  <div class="col-sm-4" >

  <div class="row" >
  
  <div class="col-sm-6"> <label><input type="radio" name="'.$addOn->name.'"  value="yes" class="radioaddon" data-id="'.$addOn->aid.'">&nbsp;Yes&nbsp;</label></div>
  
  <div class="col-sm-6"> <label><input type="radio" name="'.$addOn->name.'"  value="no" class="radioaddon" >&nbsp;No&nbsp;</label></div>

   </div>

   </div>
  
   <div class="col-sm-8">

   <p>  </p>

   </div>

   </div>
   </div>


';

}


array_push($outercont,$addonhtml);

   echo json_encode($outercont);

   wp_die();


}



public function load_cal() {

       ob_clean();

       check_ajax_referer( 'clear_booking_secure', 'security' ,false);

       $json = file_get_contents('php://input');

$obj = json_decode($json);

$month = $_REQUEST[month] ;

$num = 1;

$month = $month + $num ; 

$today = getdate();

$calendar = array();

$date = array();

if($month < $today[mon])
{

$period = $today[year]+1 ;

}
else
{

$period = $today[year];

}

$number = cal_days_in_month(CAL_GREGORIAN,$month,$period);

$count = 0 ;

$day = 1;

$monthName = date('F', mktime(0, 0, 0,$month,'10')) ;

$html .='<table class="table table-bordered" >

<thead>

<tr>

<td colspan="2"> <p data-id="'.$month.'" class="frompre"> Previous </p>  </td>
<td colspan="3"><p>'.$monthName. '</td>
<td colspan="2"> <p data-id="'.$month.'" class="fromnxt"> Next </p>  </td>

</tr>

<tr>';

for ($y = 0 ; $y <= 6 ; $y++)

{


$html .='<td class="tableheading" style="width:5px;height:5px;">'.jddayofweek($y-1,2).'</td>';


}

$html .='</tr>';


for ($x = 0 ; $x < 6 ; $x++)

{


$html .='<tr>';

for ($y = 0 ; $y <= 6 ; $y++)

{


if(($x == 0 && $y < date("w",mktime(0, 0, 0,$month,1,$period))) || ( $day > $number  )  )

{




$html .='<td ></td>';

}
else
{



$day = date("d",mktime(0, 0, 0,$month,$day,$period));



$html .='<td class="daydiv" data-id="'.$month.'">'.$day.'</td>';



$day = $day +1;

$count = $count + 1;



}


}

$html .='</tr>';

}

$html .='</thead></table>';




  
       echo $html;

       wp_die();


}


public function offers_action() {


   $cont = array();

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;

   $table_name = $wpdb->prefix . 'cb_coupons';

   $date = str_replace('/', '-', $_REQUEST[fromdate]);

   $coupon_valid = date('Y-m-d', strtotime($date));



   $date1 = str_replace('/', '-', $_REQUEST[todate]);

   $coupon_expiry = date('Y-m-d', strtotime($date1));



   $cont = $wpdb->get_results( "SELECT * FROM $table_name WHERE (('$coupon_valid' BETWEEN `validdate` AND `exdate`) AND ('$coupon_expiry' BETWEEN `validdate` AND `exdate`)) OR token = '$_REQUEST[promo]' ");
   
   if(empty($cont)){ $html .=''; } else {  
   

foreach ( $cont as $con ) 


{

         $html .='<div id="firstinnerrow" ><div class="row" >
         <div class="col-sm-10">'.$con->name.'</div>
         <div class="col-sm-2"></div>
         </div>

         <div class="row">
         <div class="col-sm-10">'.$con->description.'</div>
         <div class="col-sm-2"><p   id="cpnbtn" type="button" value="'.$con->cid.'">ADD</p></div>
         </div></div>';

}


 }

   echo $html;

   wp_die();





}


public function resdetails() {

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;

   $table_name = $wpdb->prefix . 'cb_reservations';
   
   $wpdb->update( 
   $table_name, 
   array( 
              
                'firstname'=>$_REQUEST['firstname'],
                'lastname'=>$_REQUEST['lastname'],
                'phone'=>$_REQUEST['phone'],
                'email'=>$_REQUEST['email'],
           
  
  ),
    array('resid'=>$_REQUEST['reservationID']));




    wp_die();


}


public function reservationdetails() {

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;

   $table_name = $wpdb->prefix . 'cb_reservations';
   
   $resID = $wpdb->get_row( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[resID]' " );

   $html .= '<div class="row" >
  
             <div class="col-sm-6">  

             <div class="row" >

             <div class="col-sm-12" >

             <h4>'.$resID->fromdate.'-'.$resID->todate.'</h4>

             </div>

             </div>';


$table_name = $wpdb->prefix . 'cb_bookings';

$rms_results = $wpdb->get_results( "SELECT rid FROM $table_name WHERE resid = '$_REQUEST[resID]' " );

foreach ( $rms_results as $rms_result ) 
{

$table_name = $wpdb->prefix . 'cb_rooms';

$rms = $wpdb->get_row( "SELECT * FROM $table_name WHERE rid = '$rms_result->rid' " );


$html    .= '<div class="row" >

             <div class="col-sm-6">'.

             $rms->description

             .'</div>

             <div class="col-sm-3" >

             '.$resID->lengthofstay.'days @'.$rms->price.'per night

             </div>

             <div class="col-sm-3" >

             '.$rms->price*$resID->lengthofstay.'

             </div>

             </div>';

}


$html    .= '<h4>Personal Details </h4>

             <div class="row"  >

             <div class="col-sm-6">

             First Name :

             </div>

             <div class="col-sm-6">'.

             $resID->firstname

             .'</div>

             </div>';

$html    .= '<div class="row"  >

             <div class="col-sm-6">

             Last Name :

             </div>

             <div class="col-sm-6">'.

             $resID->lastname

             .'</div>

             </div>';

$html    .= '<div class="row"  >

             <div class="col-sm-6">

             Phone :

             </div>

             <div class="col-sm-6">'.

             $resID->phone 

             .'</div>

             </div>';

$html    .= '<div class="row"  >

             <div class="col-sm-6">

             Email :

             </div>

             <div class="col-sm-6">'.

             $resID->email

             .'</div>

             </div>';

$html    .= ' <h4>Dependents </h4>

              <div class="row" >

              <div class="col-sm-6" >

              Adults :

              </div>

              <div class="col-sm-6">'.

              $resID->adults

              .'</div>

              

              </div>';


$html    .= ' 
              <div class="row" >

              <div class="col-sm-6" >

              Children :

              </div>

              <div class="col-sm-6">'.

              $resID->children

              .'</div>

              

              </div>';


$html    .= ' 

              <div class="row" >

              <div class="col-sm-6" >

              Infants :

              </div>

              <div class="col-sm-6">'.

              $resID->infants

              .'</div>

              

              </div>';

$table_name = $wpdb->prefix . 'cb_reservation_coupons';

$cpnsID = $wpdb->get_results( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[resID]' " );

$total = $resID->total;

foreach ( $cpnsID as $cpnID ) 

{

$table_name = $wpdb->prefix . 'cb_coupons';

$cpnsDes = $wpdb->get_row( "SELECT * FROM $table_name WHERE cid = '$cpnID->cid' " );

$html    .= '<div class="row">

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

}

$html    .= '<div class="row" >
             <div class="col-sm-6">

             <p>  Tax </p>
             </div>

             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3">

             <p>'. $resID->tax .'</p>

             </div>

             </div>


             <div class="row" >
             <div class="col-sm-6" >

             <h4> TOTAL</h4> 

             </div>
             <div class="col-sm-3">

             <p> USD </p>

             </div>

             <div class="col-sm-3" >

             <p>'. $resID->total .'</p>

             </div>

             </div>';

$html    .= '</div>

             <div class="col-sm-6">  </div>

             </div>';

  

   echo $html;

   wp_die();


}


 public static function cb_reserve_class_total_()
  

  {


      add_action( 'wp_ajax_bkngtlt', array( __CLASS__, 'total_action' ) );
      add_action( 'wp_ajax_nopriv_bkngtlt', array( __CLASS__, 'total_action' ) );


  }


public function check_booking($para,$para1) {

foreach ($para as $rmvalue )


{


for ($x  = 0; $x < $para1.length; $x ++  )


{


if( $para1[$x] === $rmvalue )

{


return true;


}




}



}

return true;


}


public function total_action() {


   $cont = array();

   $rmcont = array();

   $rm_found = true;

   ob_clean();

   check_ajax_referer( 'clear_booking_secure', 'security' ,false);

   global $wpdb;


   $date = str_replace('/', '-',$_REQUEST[from]);

   $from = date('Y-m-d', strtotime($date));



   $date1 = str_replace('/', '-',$_REQUEST[to]);

   $to = date('Y-m-d', strtotime($date1));



   $diff = abs(strtotime($to) - strtotime($from));

   $years = floor($diff / (365*60*60*24));

   $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

   $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

   $timeheld = date("Y-m-d h:s:i");

   $table_name = $wpdb->prefix . 'cb_bookings';


   $cont = $wpdb->get_results( "SELECT rid FROM $table_name WHERE ('$from' BETWEEN `fromdate` AND `todate`) AND  ('$to' BETWEEN `fromdate` AND `todate`) AND status <> 'R' " );

foreach ($_REQUEST[bkng] as $rmvalue )


{



for ($x  = 0; $x < $cont.length; $x ++  )


{


if( $cont[$x] === $rmvalue )

{


$rm_found = false;


}





}



}



if($rm_found) {

  global $wpdb;
  $table_name = $wpdb->prefix . 'cb_reservations';
   
  $wpdb->insert( 
   
         $table_name, 

         array( 

                'fromdate' => $from,
                'todate' => $to,
                'dateheld'=>$timeheld,
                'lengthofstay'=>$days,
                'tripcode'=>$_REQUEST[token],
                

               ) 
  
    );


   $resID = $wpdb->get_row( "SELECT resid FROM $table_name WHERE dateheld = '$timeheld' " );

   $table_name = $wpdb->prefix . 'tl_trip';

   $wpdb->update( 

   $table_name, 

   array('resid'=>$resID->resid),

   array('token' => $_REQUEST[token])
  
    );


   $table_name = $wpdb->prefix . 'cb_bookings';

   $numrooms = 0;

   foreach ($_REQUEST[bkng] as $value)

   {

   $adults = $value[adults] + $adults;

   $children = $value[children] + $children;

   $infants = $value[infants] + $infants;

   $table_name = $wpdb->prefix . 'cb_rooms';
   
   $res = $wpdb->get_row( "SELECT * FROM  $table_name WHERE rid = '$value[id]' " );
   
   $total = ( $res->price * $days) + $total;

   $html .='<div class="row" id="firstinnerrow">

   <div class="col-sm-6"><p>'.

   $res->name
 
   .'</p>
   </div>
   <div class="col-sm-3">

   <p> USD </p>

   </div>

   <div class="col-sm-3" >

   <p>'.  number_format($res->price * $days, 2, '.', ',') .'</p>

   </div>

   </div>';



   $table_name = $wpdb->prefix . 'cb_bookings';

   $wpdb->insert( 
   $table_name, 
   array( 
    'rid' => $value[id], 
    'fromdate' => $from,
                'todate' => $to,
                'status'=>'H',
                'resid'=>$resID->resid
  ) 
  
   );

$numrooms = $numrooms + 1;
   }

  array_push($rmcont,$html);


$amt = 0;



$addons = array();

$addAmt = 0;

for ($x = 0; $x < sizeof($_REQUEST[addOns]); $x++  ) 

{

$table_name = $wpdb->prefix . 'cb_add_ons';

$nm = $_REQUEST[addOns][$x];


$addrow = $wpdb->get_row( "SELECT * FROM $table_name WHERE name = '$nm' " ); 

if(!empty($addrow->description)) {

$table_name = $wpdb->prefix . 'cb_reservation_add_ons';
   
if($addrow->frequency == 'night')

{

$amt = ($addrow->price * $days);

$addAmt = $addAmt + $amt;

}

else if ($addrow->frequency == 'person')

{

$amt = ($addrow->price * $adults);

$addAmt = $addAmt + $amt;

}

else if($addrow->frequency == 'room')

{

$amt = ($addrow->price * $numrooms);

$addAmt = $addAmt + $amt;

}

$wpdb->insert( 
   
         $table_name, 
  
         array( 

                'resid' => $resID->resid,
                'aid' => $addrow->aid,
                'amount'=> $amt,

              ) 
  
    );
}
else{


$amt = '0';

}

$htmlamt .='  <div class="row" id="firstinnerrow">

              <div class="col-sm-6"><p>'.

              $_REQUEST[addOns][$x]

              .'</p></div>

              <div class="col-sm-3">

              <p> USD </p>

              </div>

              <div class="col-sm-3" >

              <p>'. number_format( $amt, 2, '.', ',').'</p>

              </div>

              </div> ';



}


array_push($rmcont,$htmlamt);

  $roomtotal = $total;

  $tax =  (($total + $addAmt ) * get_option('cb_tax'))/100;

  $table_name = $wpdb->prefix . 'cb_coupons';

  foreach ($_REQUEST[bkngcpn] as $value1)

   {
   
   $resdSC = $wpdb->get_row( "SELECT * FROM $table_name WHERE cid = '$value1[id]' " );


   $table_name = $wpdb->prefix . 'cb_reservation_coupons';

   $wpdb->insert( 
   $table_name, 
   array( 
    'cid' => $value1[id], 
    'resid'=>$resID->resid
  ) 
  
   );



   $total_dsc = $resdSC->amount + $total_dsc;

   $html1 .=' <div class="row" id="firstinnerrow">
              <div class="col-sm-6"><p>'.

              $resdSC->name

              .'</p></div>
              <div class="col-sm-3">

              <p> USD </p>

              </div>

              <div class="col-sm-3" >

              <p>('. number_format(($total * $resdSC->amount)/100 , 2, '.', ',').')</p>

              </div>

              </div> ';

    $total = $total - (($total * $resdSC->amount)/100);


   }
  
   $dsc = (($total *  $total_dsc)/100);

   //$total = $total - (($total *  $total_dsc)/100);




   $table_name = $wpdb->prefix . 'cb_reservations';

   $total1 = $total + $addAmt;

   $total1 =  $total1 + $tax;

   $total = number_format($total1,2, '.', ',');

   $tax = number_format($tax,2, '.', ',');

   $wpdb->update( 

   $table_name, 

   array('adults'=>$adults,'children'=>$children,'infants'=>$infants,'roomtotal'=>$roomtotal,'total'=>$total1,'discount'=>$dsc,'addOnAmt' => $addAmt ,'tax' => $tax),

   array('resid' => $resID->resid)
  
    );

  


   array_push($cont,$html);

   array_push($cont,$html1);

   array_push($cont,$resID->resid);

   array_push($cont,$total);

   array_push($cont,$htmlamt);

   array_push($cont,$tax);



}
else {

array_push($cont,'One or more of those rooms is no longer available');

}




   echo json_encode($cont);

   wp_die();



}


public function load_to_cal() {

       ob_clean();

       check_ajax_referer( 'clear_booking_secure', 'security' ,false);

       $json = file_get_contents('php://input');

$obj = json_decode($json);

$month = $_REQUEST[month] ;

$num = 1;

$month = $month + $num ; 

$today = getdate();

$calendar = array();

$date = array();

if($month < $today[mon])
{

$period = $today[year]+1 ;

}
else
{

$period = $today[year];

}

$number = cal_days_in_month(CAL_GREGORIAN,$month,$period);

$count = 0 ;

$day = 1;

$monthName = date('F', mktime(0, 0, 0,$month,'10')) ;
$html .='<table class="table table-bordered" >

<thead>

<tr>

<td colspan="2"> <p data-id="'.$month.'" class="topre"> Previous </p>  </td>
<td colspan="3"> <p>'. $monthName .' </p> </td>
<td colspan="2"> <p data-id="'.$month.'" class="tonxt"> Next </p>  </td>

</tr>

<tr>';

for ($y = 0 ; $y <= 6 ; $y++)

{


$html .='<td class="tableheading" style="width:5px;height:5px;">'.jddayofweek($y-1,2).'</td>';


}

$html .='</tr>';


for ($x = 0 ; $x < 6 ; $x++)

{


$html .='<tr>';

for ($y = 0 ; $y <= 6 ; $y++)

{


if(($x == 0 && $y < date("w",mktime(0, 0, 0,$month,1,$period))) || ( $day > $number  )  )

{




$html .='<td ></td>';

}
else
{

$fd = date("Y-m-d",mktime(0, 0, 0,$month,$day,$period));

$day = date("d",mktime(0, 0, 0,$month,$day,$period));

$html .='<td class="todaydiv" data-id="'.$month.'" >'.$day.'</td>';



$day = $day +1;

$count = $count + 1;



}


}

$html .='</tr>';

}

$html .='</thead></table>';




  
       echo $html;

       wp_die();


}




}
?>