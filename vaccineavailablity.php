<?php

// echo "This is php file";

$today =  date("d-m-Y");

$url = "https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByDistrict?district_id=145&date=".$today;
$url = "https://cdn-api.co-vin.in/api/v2/appointment/sessions/public/calendarByPin?pincode=201001&date=".$today;



//  Initiate curl
//
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
// var_dump(json_decode($result, true));

$listvaccine = json_decode($result, true);
$daysArray = array();

for($i=1; $i<8; $i++){
    $daysArray[$i] = $today =  date("d-m-Y", strtotime("+$i day"));
}

//  print_r($daysArray);


foreach($listvaccine["centers"] as $vlist){
    // echo "-------------------------------------";
    // print_r($vlist["center_id"]);
    $flist  = array("693761","693812","695280","702870","693891");
    // if(in_array($vlist["center_id"],$flist)){
            // print_r($vlist);
//$vlist["fee_type"] == "Free" and 
//$session["date"] == "19-06-2021" or $session["date"] == "20-06-2021"
    if($vlist["fee_type"] == "Free"){
        foreach($vlist["sessions"] as $session){
            if((in_array($session["date"],$daysArray)) and $session["vaccine"] == "COVISHIELD" and $session["min_age_limit"] == "18" ){
                // print_r($session);
                // echo "this is";
                if($session["available_capacity_dose1"] > 1 ){
                    echo "Vaccine available at  ".$vlist["center_id"]. "    ".$vlist["name"]."   ".$session["date"]."    ".$session["available_capacity_dose1"]. "\n";
                    $cmd = "play -q -n synth 0.1 sin 880 >& /dev/null";
                    shell_exec($cmd);
                    echo "<br>";
                }else{
                    echo "Not available \n";
                    echo "<br>";
                }
            }else{
                echo "No session avialable\n";   
                // $cmd = "play -q -n synth 0.1 sin 880 >& /dev/null";
                // shell_exec($cmd);             
                echo "<br>";
            }
        }

        
    }
    // }

}
// echo "this count of array". count($listvaccine);
// for($i=0; $i<count($listvaccine); $i++){
//     print_r($listvaccine[$i]);
// }

?>
