var typeofb = [];

var typeofc ;

var typeofs = [];

var typeofIntin = [] ;

var mapmarkers = [] ;

var fin = [] ;

var marker;

jQuery(document).ready(function($) {


var rString = randomString(5, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

$( ".trpcode" ).html(rString);

$( ".chktoken" ).val(rString);


$(function() {

    $( document ).tooltip();

  });

$( ".trpcfm" ).hide();

$( ".findiv" ).hide();

$("#tripconfirmform").hide();


$( window ).load(function() {
 



var myDropdownList = document.shortcode.country;


rndm = makeid();

$( ".tkn" ).html(rndm);


typeofc  = document.getElementById("frontendmapframe").getAttribute("data-id") ;



setupMap(typeofc,'frontendmapframe');


    for (iLoop = 0; iLoop< myDropdownList.options.length; iLoop++)
  
  {    
      

        if (myDropdownList.options[iLoop].value == document.getElementById("frontendmapframe").getAttribute("data-id"))

      {

        myDropdownList.options[iLoop].selected = true;
       
        break;

      }


    }


});



$(document).on("click","#placetag",function(event){

var data = {

    'action': 'filter_plcbrd_action',
              'typeofb':this.innerHTML,
              'typeofc':typeofc,
              'dataType':'json',
                
  };


jQuery.getJSON(ajax_object.ajax_url, data, function(response) {

drop(response);



});




});


$("#place").keydown(function(){



var data = {

    'action': 'filter_actionfilter',
                'typeofb':$(".target").val(),
'typeofc':typeofc,
                
  };


jQuery.post(ajax_object.ajax_url, data, function(response) {

$(".brandservice").html(response);

});



});

$(document).on("click","#discover",function(event){


jQuery.grep(mapmarkers, function( a,i ) { 


if(a.metadata.set === 'true')

{


 fin.push(a.title);



}


return a; 


});


fin = jQuery.unique( fin );

var data = {

    'action': 'filter_actionfin',
                'typeofc':typeofc,
                'fin[]': fin,
                
  };


jQuery.post(ajax_object.ajax_url, data, function(response) {



$(".panelb1").html(response);


$("html,body").animate({scrollTop:$('#rightmain').offset().top }, "slow");

$("#panelb1").slideDown();


  });


$("#discover").hide();

$("#tripconfirmform").show();

});


$(document).on("click","#tripconfirm",function(event){



for (x in fin) {
  

var para = document.createElement("input");
para.setAttribute("type", "hidden");
para.setAttribute("value", fin[x]);
para.setAttribute("name", "trpPlace[]");
var trpPlcs = document.getElementById("trpPlcs");
trpPlcs.appendChild(para);

}

document.getElementById("tripconfirmform").submit();

});

$(document).on("click",".dbserchk",function(event){

$("#tripconfirmform").hide();

$("#discover").show();




 var action = (event.target.checked ? 'add' : 'remove');



  if (action === 'add' && typeofs.indexOf(this.value) === -1) {

    typeofs.push(this.value);



var data = {
    'action': 'filter_placehldersactionfe',
                'typeofs[]': typeofs,
                'typeofc':typeofc,
                'dataType':'json',
               

  };




jQuery.getJSON(ajax_object.ajax_url, data, function(response) {


drop(response);


});



  }

  if (action === 'remove' && typeofs.indexOf(this.value) !== -1) {

   
var ser = typeofs[typeofs.indexOf(this.value)]





mapmarkers = jQuery.grep(mapmarkers, function( a,i ) { 




if((a.metadata.service === ser) && (a.metadata.set === 'false'))

{



 
 a.setMap(null);


}


return a;


});




typeofs.splice(typeofs.indexOf(this.value), 1);






  }





});




$(document).on("click",".dbtob",function(event){

$("#tripconfirmform").hide();

$("#discover").show();

 var action = (event.target.checked ? 'add' : 'remove');


 updateSelected(action,event.target.value,typeofb);



});


var updateSelected = function(action,id,para) {


  if (action === 'add' && para.indexOf(id) === -1) {

    para.push(id);

  }


  if (action === 'remove' && para.indexOf(id) !== -1) {

    para.splice(para.indexOf(id), 1);

  }


var data = {
    

                'action': 'filter_serviceactionfe',
                'typeofb[]': para,
               

  };


jQuery.post(ajax_object.ajax_url, data, function(response) {


$(".typeofservice").html(response);


});




}
 






});



function geTcORDS (para)

{


var latlng = para.latlng.replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

var myCenter = new google.maps.LatLng(latlng[0],latlng[1]);

return myCenter;


}


function geTcORDSPlc (para)

{

var latlng = String(para).replace("(","");


latlng = String(latlng).replace(")","");


return latlng;


}



function setValued(value) {

  return ( value.metadata.set === 'true');

}



function calcRoute() {




var directionsService = new google.maps.DirectionsService();

var points = [];

var waypoints = mapmarkers.filter(setValued);

for (var i = 0; i < waypoints.length; i++) {



    var address = waypoints[i].position;

    if (address !== "") {


        points.push({
            location: address,
            stopover: false

        });

    }

}

 var length = waypoints.length - 1; 

    var request = {
        origin: waypoints[0].position,
        destination:waypoints[length].position,
        waypoints:points,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.WALKING
    };


setupMap(geTcORDSPlc(waypoints[0].position),'trpcfmmap');

    directionsDisplay.setMap(map);

    directionsService.route(request, function(response, status) {
    
      if (status == google.maps.DirectionsStatus.OK) {

        directionsDisplay.setOptions( { suppressMarkers: true } );

        directionsDisplay.setDirections(response);
        
      } else {

        alert("directions response "+status);

      }

    });


  }



function myFunction() {



calcRoute();


}


function setDst(totalmeters) {  


totalKmeters = ((Number(totalmeters)*2) * 0.001).toFixed(2);

miles = Number( totalKmeters) * Number(0.621371192);


return miles.toFixed(2);

}


function pathdistance (lat,long) {

var R = 6378137;

var dLat = ((lat - 18.166673)* Math.PI )/180;

var dLong = ((long - (-76.381451))* Math.PI )/180;

var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos((lat * Math.PI )/180) * Math.cos((18.166673 * Math.PI )/180) * Math.sin(dLong / 2) * Math.sin(dLong / 2);

var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

var d = R * c;

return d;

}




document.getElementById('country').addEventListener('change', function() {

typeofc = this.value ;

setupMap(this.value,'frontendmapframe');

}, false);


function setupMap(para,para1) {


var geocoder;

geocoder = new google.maps.Geocoder();


geocoder.geocode( { 'address': para}, function(results, status) {


if (status == google.maps.GeocoderStatus.OK) {


var x = document.getElementById(para1);

var y = (x.contentWindow || x.contentDocument);

if (y.document)y = y.document;

map = new google.maps.Map(y.getElementById('map'), {

center:results[0].geometry.location,

zoom:9,

mapTypeId:google.maps.MapTypeId.ROADMAP

  });


}

 });




}


function removeMarkers() {

    for(i=0; i < mapmarkers.length; i++){

        mapmarkers[i].setMap(null);

    }

}



function drop (response) {



  for (var i = 0; i < response.length; i++) {


    var myCenter = geTcORDS(response[i]);


    addMarkerWithTimeout(myCenter, i * 200,response[i]);


  }




}



function geTlat (para)

{


var latlng = String(para).replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

return latlng[0];


}


function geTlng (para)

{

var latlng = String(para).replace("(","");

latlng = latlng.replace(")","");

latlng = latlng.split(",");

return latlng[1];


}



function addMarkerWithTimeout(position,timeout,para) {


window.setTimeout(function() {

var infowindow = new google.maps.InfoWindow();


var marker = new google.maps.Marker({

      position: position,

      draggable: true,

      map: map,

      title:para.company,

icon:para.icon,

      metadata: {


            service:para.service,

            set:'false',

            lat:geTlat(position) , 
 
            lng:geTlng(position),

   },

      animation: google.maps.Animation.DROP

    });


    mapmarkers.push(marker);

var content = document.createElement('div');

setContent(para,content);

button = content.appendChild(document.createElement('P'));
                      
                      button.innerHTML =  (chkB(para) == -1) ? 'Add to itinerary!' : 'Delete from itinerary';

                                         button.setAttribute("style","float:right;padding:2px;cursor:pointer;");
                      
                      google.maps.event.addDomListener(button, 'click', function () {

                           showMore(para,this,marker,infowindow);

                      });

  google.maps.event.addListener(marker, 'click', function () {

                           infowindow.setOptions({

                              content:content ,

                              map: map,

                              position:position

                          });



});

google.maps.event.addListener(marker, 'dragstart', function() {


     marker.setPosition(position);


  });

google.maps.event.addListener(marker, 'drag', function() {


    marker.setPosition(position);


  });

  }, timeout);



}

var distance;

function showMore(para,button,marker,infowindow) 

{

if (typeofIntin.indexOf(para.company) === -1) 

{


if(typeofIntin.length == 8)


{
  

alert('sorry , we can only accept 8 waypoints');


}

else

{
  
typeofIntin.push(para.company);

button.innerHTML =  (chkB(para) === -1) ? 'Add to itinerary!' : 'Delete from itinerary';

mapmarkers = jQuery.grep(mapmarkers, function( a ) { 

if(a.title === para.company )

{


a.metadata.set = 'true';


}


return a; 


});

dst = caldst(mapmarkers);

distance = setDst(dst);

$(".trpcfmdst").html(distance);

$(".distance").val(distance);

}





}

else

{

typeofIntin.splice(typeofIntin.indexOf(para.company), 1);

button.innerHTML =  (chkB(para) === -1) ? 'Add to itinerary!' : 'Delete from itinerary';

infowindow.close();

mapmarkers = jQuery.grep(mapmarkers, function( a , i) { 

idx = i ;

if(a.title === para.company && a.metadata.set === 'true')

{




 
 a.setMap(null);
 a.metadata.set = 'false';

}


return a; 


});


//mapmarkers.splice(idx, 1);


dst = caldst(mapmarkers);


distance = setDst(dst);

$(".trpcfmdst").html(distance);

$(".distance").val(distance);


}



}


function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}




function setContent (para,content) 


{
  
logo = content.appendChild(document.createElement('img'));

logo.src= para.image;

logo.setAttribute("style","width:100%;padding:10px;height:50%");

logo.setAttribute("class","img-responsive");

title = content.appendChild(document.createElement('h3'));

title.innerHTML = para.company;

address = content.appendChild(document.createElement('h4'));

address.innerHTML = para.address;

phone = content.appendChild(document.createElement('h5'));

phone.innerHTML = para.phone;

email = content.appendChild(document.createElement('h5'));

email.innerHTML = para.email;

url = content.appendChild(document.createElement('h5'));

url.innerHTML = para.website;

return  content;


}


function chkB(para) {


return typeofIntin.indexOf(para.company);


              }



function makeid()
{
    var text = "";

    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;

}



function caldst(mapmarkers) {

totalmeters = 0;

jQuery.grep(mapmarkers, function( a,i ) { 

if(a.metadata.set === 'true')

{



 totalmeters = Number(pathdistance(a.metadata.lat,a.metadata.lng)) + Number(totalmeters);



}


return a; 


});


return totalmeters;

}

function removemapmarkers(idx) {


 mapmarkers.splice(idx, 1);

}
