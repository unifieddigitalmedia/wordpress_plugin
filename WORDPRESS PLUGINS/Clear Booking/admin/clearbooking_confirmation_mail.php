<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class clearbooking_confirmation_mail

{
  




 public static function clearbooking_confirmation_mail_()
  

  {
    

    

if (isset($_GET['CHECKOUT'])) { 



global $wpdb;

$table_name = $wpdb->prefix . 'cb_reservations';
   
$res_ID = $wpdb->get_row( "SELECT * FROM $table_name WHERE resid = '$_REQUEST[reservationID]' " );

$total = $res_ID->total;

$table_name = $wpdb->prefix . 'cb_bookings';
 
$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE `resid` = '$_REQUEST[reservationID]' " );

$value =  $res_ID->fromdate ;

$day =  substr("$value",8,2);

$month = substr("$value",5,2);

$year =  substr("$value",0,4);

$jd=gregoriantojd($month,$day,$year);

$monthName = date('F', mktime(0, 0, 0,$month, 10)); 

$date = jddayofweek($jd,1).' , '. $monthName .' '. $day .' '. $year;

$to = $res_ID->email;


if(get_option('cb_customerconfirmationemail')  ) {


$subject = "Booking Confirmation Slip";

$message = "

<html>

<head>

<title></title>

</head>

<body>

<table>

<tr> <td colspan='4'></td> </tr>

<tr> <td colspan='4'> <p> NAME: $res_ID->firstname  $res_ID->lastname</p> </td></tr>

<tr> <td colspan='2'> <p> DAY & DATE OF ARRIVAL: $date </p></td> <td colspan='2'> NO. OF NIGHTS: $res_ID->lengthofstay </td>  </tr>

<tr> <td> <p> ROOM(S):</p></td> <td> <p> $user_count  </p></td> <td colspan='2'> </td> </tr>

<tr> <td colspan='4'> <p> Please check that the above room(s) and date(s) are correct. We acknowledge receipt of a deposit on the above </p> </td></tr>

<tr> <td colspan='4'> <p>rooms of $ $res_ID->deposit. The balance will be $res_ID->balance. </p> </td></tr>

<tr> <td colspan='4'> <p> get_option('cb_cancel_policy'). </p> </td></tr>

<tr> <td colspan='4'> <p> get_option('cb_refund_policy'). </p> </td></tr>

<tr> <td colspan='4'> <p> Please feel free to contact us if we can be of further service. We look forward to your visit. </p> </td></tr>

<tr> <td colspan='4'> <p> Sincerely,</p> </td> </tr>

<tr> <td> </td> </tr>

<tr> <td colspan='4'> <p> get_option('cb_business_name')</p></td> </tr>

<tr> <td colspan='4'> <p> get_option('cb_business_address')</p></td> </tr>

<tr> <td colspan='4'> <p> get_option('cb_business_phone')</p> </td> </tr>

<tr> <td colspan='4'> <p> get_option('cb_email')</p> </td> </tr>

<tr> </tr>


</table>

</body>

</html>
";



$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

wp_mail($to,$subject,$message,$headers);



}


$table_name = $wpdb->prefix . 'cb_bookings';
   
$wpdb->update( 

   $table_name, 

   array('status' => 'R'),

   array('resid' => $_REQUEST[reservationID])
  
    );



if(get_option('cb_businessconfirmationemail')  ){



$newto = get_option("cb_email");

$newsubject = "Booking Confirmation Slip";

$newmessage .="<html>

<head>

<title></title>

</head>

<body>

<table>

<tr> <td colspan='4'> </td> </tr>

<tr> <td colspan='2'> <p> CALL DATE: date('l') , date('F', mktime(0, 0, 0,date('m'), 10))  date('d') date('Y')  </p></td> <td colspan='2'> <p> DATE OF ARRIVAL: $date </p> </td>  </tr>

<tr> <td colspan='2'> <p> CALLER: $res_ID->firstname  $res_ID->lastname </p></td> <td colspan='2'> <p>DAY OF ARRIVAL: jddayofweek($jd,1) </p> </td>  </tr>

<tr> <td colspan='2'>  </td> <td> <p> ROOM(S):$user_count </p> </td> <td> <p> TIME OF ARRIVAL: </p> </td> </tr>

<tr> <td > </td> <td> <p> ADULTS: $res_ID->adults </p></td> <td > <p> CHILDREN: $res_ID->children </p></td> <td > <p> INFANTS: $res_ID->infants </p></td></tr>

<tr> <td colspan='2'> <p> TOTAL: $res_ID->total </p></td> <td colspan='2'> <p> NUMBER OF NIGHTS: $res_ID->lengthofstay </p> </td>  </tr>

<tr> <td colspan='2'> <p> DEPOSIT: $res_ID->deposit </p></td> <td colspan='2'> <p></p> </td>  </tr>

<tr> <td colspan='2'> <p> REMIND:  </p></td> <td colspan='2'> <p>ADDRESS BOOK: </p> </td>  </tr>

<tr> <td colspan='2'> <p> CONFIRM:  </p></td> <td colspan='2'> <p>LEDGER ENTRY: </p> </td>  </tr>

<tr> <td colspan='4'> <p> NAME: $res_ID->firstname  $res_ID->lastname </p></td> </tr>

<tr> <td colspan='4'> <p> PHONE: $res_ID->phone </p></td> </tr>

<tr> <td colspan='4'> <p> EMAIL: $res_ID->email </p></td> </tr>

<tr> <td colspan='4'> <p> TYPE OF ID:  $res_ID->idtype</p></td> </tr>

<tr> <td colspan='4'> <p> ID NUMBER:  $res_ID->idnumber</p></td> </tr>

<tr> <td colspan='4'> <p> EXPIRY DATE:  $res_ID->idexpiry</p></td> </tr>

<tr> </tr>";




if ($res_ID->token) {

$newmessage .= "<tr> <td colspan='4' > Places to visit </td>  </tr>";

$table_name = $wpdb->prefix . 'tl_trip';
   
$places = $wpdb->get_results( "SELECT * FROM $table_name WHERE token = '$res_ID->token' " );

foreach ( $places as $place ) 


{

$s = get_post_meta($place->place );

$newmessage .= "<tr> <td> $s[company][0] </td> <td>Contact:$s[fullname][0] </td> <td>Phone:$s[phone][0]</td> <td>Email:$s[email][0] </td>  </tr>";


}




}




$newmessage .="</table>

</body>

</html>";


$newheaders = "MIME-Version: 1.0" . "\r\n";

$newheaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";

wp_mail($newto,$newsubject,$newmessage,$newheaders);




}


}




  }






}

?>