<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//ADD_PARSING_TO_DB('{"Phone":"996770535050","CANCELLATION_FEE":"","STATUS":"ISSUED","DOCUMENT_TYPE":"TICKET","SERVICE_FEE":"0","TYPE":"ПЕГАСУС","FLIGHT_NUMBERS":"PC194","MARKETING_CARRIER":"PC","OPERATING_CARRIER":"PC","BOOKING_CLASSES":"Y;A","DEPARTURE_DATE":"2016-08-14 09:10:00","DEPARTURE_DATES":"14082016","DEPARTURE_TIMES":"0910","ROUTE":"OSS-FRU;FRU-DME","BOARD_CITY":"OSS","DESTINATION_CITY":"DME","FARE_BASISES":"TKGAGT/D","ARRIVAL_DATES":"14082016","ARRIVAL_TIMES":"0955","TAXES":"","TAXES_TOTAL_CURRENCY":"USD","TAXES_TOTAL":"0.00","FORM_OF_PAYMENT":"INVOICE","FO_NUMBER":"","PAX_TYPE":"","TOTAL_TST":"0.00","DOCUMENT_ISSUED":"2016-08-13 13:23:02","DOCUMENT_NUMBER":"624-2147305555","LAST_NAME":"ATTOKUROV","FIRST_NAME":"NURMUKHAMED","TITLE":"MR","RECORD_LOCATOR":"9W3GF9","TICKETING_OFFICEID":"Sarbanov","TICKETING_SINE":"A738FL56","VALIDATING_CARRIER":"PC","FARE":"0","CURRENCY":"KGS","TOTAL":"0.00","TOTAL_CAR":"0.00","REMARK1":"","DB_NAME":"joomart","RESPONSIBLE":"ZHUMA","DISCOUNT":"2.23","DISCOUNT_AMOUNT":"2.23"}');
if ($_POST != null && $_POST['key'] === md5key()) {
    
    if ($_POST['q'] === 'getCompany')
            echo json_encode(getCompany());
    if ($_POST['q'] === 'mytickets')
            ADD_PARSING_TO_DB();
  }
  else
  {
    echo "<h1>Object not found!</h1>
<p>The requested URL was not found on this server.
    If you entered the URL manually please check your
    spelling and try again.
</p>
<p>
If you think this is a server error, please contact
the <a href='mailto:%5bno%20adress%20given%5d'>webmaster</a>.
</p>
<h2>Error 404</h2>
<style type='text/css'><!--/*--><![CDATA[/*><!--*/ 
    body { color: #000000; background-color: #FFFFFF; }
    a:link { color: #0000CC; }
    p, address {margin-left: 3em;}
    span {font-size: smaller;}
/*]]>*/--></style>";
  }
  
function test()
{
     $conn = DB_connect();
     $result =  mysqli_query($conn,"SELECT `id_agent` FROM `bm_joomart_agents` WHERE `sine` like '%osh%'");
     $companys = array();
      while ($row = mysqli_fetch_assoc($result)) {               
                array_push($companys, $row);                   
            }
          echo   $companys[0]['id_agent'];
       //print_r($companys);     
}  
function ADD_PARSING_TO_DB()
{
  $conn = DB_connect();  
  $obj = json_decode(str_replace('\\"', '"', $_POST['text']), true);
  //$obj = json_decode(str_replace('\\"', '"', $text), true);
  $TICKET_NUMBER = $obj['DOCUMENT_NUMBER'];
  $db_name=$obj["DB_NAME"];   
  $STATUS=$obj['STATUS'];
  //echo "SELECT DOCUMENT_NUMBER FROM bm_".$db_name." WHERE DOCUMENT_NUMBER LIKE '%$TICKET_NUMBER%' and STATUS like '%$STATUS%' limit 1";
  $result =  mysqli_query($conn,"SELECT DOCUMENT_NUMBER FROM bm_".$db_name." WHERE DOCUMENT_NUMBER LIKE '%$TICKET_NUMBER%' and STATUS like '%$STATUS%' limit 1");
      if ($result && mysqli_num_rows($result) > 0) {
			echo "already added"; 
			return;
			}   
            
   $TICKETING_SINE=$obj['TICKETING_SINE'];
   $RESPONSIBLE=($obj['RESPONSIBLE']=="")?"admin":strtoupper($obj['RESPONSIBLE']);
   $result =  mysqli_query($conn,"SELECT `id_agent` FROM `bm_agents` WHERE `sine` like '%".$TICKETING_SINE."%'and db_name='".$db_name."' and is_deleted='0' limit 1");
   if ($result && mysqli_num_rows($result) > 0) {
      $agent = array();
      while ($row = mysqli_fetch_assoc($result)) {               
                array_push($agent, $row);                   
            }
          $obj['RESPONSIBLE']=$agent[0]['id_agent'];
          
    }
   else
    {
        $result =  mysqli_query($conn,"SELECT `id_agent` FROM `bm_agents` WHERE `sine` like '%".$RESPONSIBLE."%'and db_name='".$db_name."' and is_deleted='0' limit 1"); 
        if ($result && mysqli_num_rows($result) > 0) {
             $agent = array();
             while ($row = mysqli_fetch_assoc($result)) {               
                array_push($agent, $row);                   
            }
          $obj['RESPONSIBLE']= $agent[0]['id_agent'];
         }
         else{
         $obj['REMARK1']=strtoupper($obj['RESPONSIBLE']);
         $obj['RESPONSIBLE']="admin";
         }
    }
    
    $local_cur=""; 
    $COUNTRY_CODE="";
    $result =  mysqli_query($conn,"SELECT bm_user.local_cur,bm_user.location from bm_user where bm_user.db_name='".$db_name."' limit 1"); 
        if ($result && mysqli_num_rows($result) > 0) {
             while ($row = mysqli_fetch_assoc($result)) {               
                $local_cur=$row['local_cur'];  
                $COUNTRY_CODE=$row['location'];              
            }                             
         }
    
    $ROUTE_COUNTRIES="";
    $ROUTE=$obj["ROUTE"];     
    $cnts = explode(";", $ROUTE);
    $DOMINT = 'DOM';
    foreach ($cnts as $cntskey => $cntsvalue) {
                $cnts2 = explode("-", $cntsvalue);
                foreach ($cnts2 as $cnts2key2 => $cnts2value2) {
                    $tempCountry = getCountryByCity($cnts2value2);                  
                    $ROUTE_COUNTRIES .= $tempCountry;
                    $ROUTE_COUNTRIES .= '-';
                    if($COUNTRY_CODE=="") $COUNTRY_CODE=$tempCountry;
                    if($COUNTRY_CODE!=$tempCountry)
                    $DOMINT="INT";
                }
                $ROUTE_COUNTRIES = substr($ROUTE_COUNTRIES, 0, -1);
                $ROUTE_COUNTRIES .= ';';
            }
    $ROUTE_COUNTRIES = substr($ROUTE_COUNTRIES, 0, -1); 
    $obj["ROU_CNT"]=$ROUTE_COUNTRIES;
    $obj["DOM_INT"]=$DOMINT;
    
    $id_carrier="";
    $result =  mysqli_query($conn,"SELECT bm_carriers.id from bm_carriers where bm_carriers.name='".$obj["TYPE"]."' and bm_carriers.db_name='".$db_name."'  limit 1"); 
        if ($result && mysqli_num_rows($result) > 0) {
             while ($row = mysqli_fetch_assoc($result)) {               
                $id_carrier=$row['id'];                 
            }                             
         } 
    if($id_carrier=="")
      $obj["ID_CARRIER"]="-1";
     else
      $obj["ID_CARRIER"]=$id_carrier; 
    	
   
   $ser_fee=0;
   $obj['FARE_PEGASUS']='0';
   if($obj["TYPE"]=="ПЕГАСУС")
   {   
     $obj['FARE_PEGASUS']=$obj["FARE"];
    if($obj["STATUS"]!="REISSUED" && ["STATUS"]!="REFUNDED")
    {    
         if($obj["TITLE"]!="INF")
          {
            if($obj["DOM_INT"]=="DOM")
             $ser_fee=4;
             else
             { 
               if(count($cnts)>1)
               {
                  $class = explode(";", $obj["BOOKING_CLASSES"]);
                  if(strpos('I A E',$class[0]) !== false ) 
                  {
                    $ser_fee=20; 
                  }
                  else
                  $ser_fee=24;
               }
               else 
               $ser_fee=20; 
             }  
           if($obj["BOARD_CITY"]==$obj["DESTINATION_CITY"])
             $ser_fee=$ser_fee*2;
                 
          }
         $obj["COMMISSION"]=$ser_fee;
         $obj["COMMISSION_AMOUNT"]=$ser_fee;
         $obj["FARE"]=$obj["FARE"]+$ser_fee;
         $obj["TOTAL"]=$obj["TOTAL"]+$ser_fee;
     }
   } 
  // CurrencyRate
 
    $ticket_cur= $obj['CURRENCY'];    
    if($local_cur!== '' && $local_cur!==$ticket_cur)   
    {
       $cur_rate="";
       $result =  mysqli_query($conn,"SELECT bm_currency_rate.rate from bm_currency_rate where bm_currency_rate.from_cur='".$ticket_cur."' and bm_currency_rate.db_name='".$db_name."'  ORDER by bm_currency_rate.id DESC limit 1"); 
        if ($result && mysqli_num_rows($result) > 0) {
             while ($row = mysqli_fetch_assoc($result)) {               
                $cur_rate=$row['rate'];                 
            }                             
         } 
      if($cur_rate!== '')
      {
         if( strpos($obj["COMMISSION"], '%') == false ){
          $obj["COMMISSION"]=round($obj["COMMISSION"]*$cur_rate,2);
        }
        $obj["COMMISSION_AMOUNT"]=round($obj["COMMISSION_AMOUNT"]*$cur_rate,2);       
         if( strpos($obj["DISCOUNT"], '%') == false ){
          $obj["DISCOUNT"]=round($obj["DISCOUNT"]*$cur_rate,2);
        }
        $obj["DISCOUNT_AMOUNT"]=round($obj["DISCOUNT_AMOUNT"]*$cur_rate,2);
        $obj["SERVICE_FEE"]=round($obj["SERVICE_FEE"]*$cur_rate,2);        
        $obj["FARE"]=round($obj["FARE"]*$cur_rate,2);
        $obj['FARE_PEGASUS']=round($obj["FARE_PEGASUS"]*$cur_rate,2);
        $obj["TAXES_TOTAL"]=round($obj["TAXES_TOTAL"]*$cur_rate,2);
        $obj["TOTAL"]=round($obj["TOTAL"]*$cur_rate,2);
        $obj["TOTAL_CAR"]=round($obj["TOTAL_CAR"]*$cur_rate,2);
        $obj["TOTAL_TST"]=round($obj["TOTAL_TST"]*$cur_rate,2);
        $obj["CANCELLATION_FEE"]=round($obj["CANCELLATION_FEE"]*$cur_rate,2);
        $obj["CURRENCY_RATE"]=$cur_rate;
        $obj["CURRENCY"]=$local_cur;
      }  
        
        
    }  
  //
   $sql_query_pass="";
   $sql_value_pass="";
   $sql_query="";
   $sql_value="";
   foreach($obj as $objKey => $objValue){
			//	if (strtolower($objKey) == 'first_name' || strtolower($objKey) == 'last_name' ||strtolower($objKey) == 'passport' ||strtolower($objKey) == 'phone' ||strtolower($objKey) == 'email')
               // {
              //       $sql_query_pass .= $objKey.",";
              //       $sql_value_pass .= "'$objValue',";
             //   }
                if (strtolower($objKey) == 'DB_NAME') continue;
                if($sql_query=="")
                {
                     $sql_query .= $objKey;
                     $sql_value .= "'$objValue'";
                }
                else
                {
                    $sql_query .= ",".$objKey;
                    $sql_value .= ",'$objValue'";
                }
            }         
  $result =  mysqli_query($conn,"insert into bm_".$db_name." ($sql_query) values ($sql_value)");
  if($result)
    echo 'success';
  else
    echo 'error';  
}
function getCountryByCity($airport)
{
    $conn = DB_connect();
    $result = mysqli_query($conn,"SELECT `country_code` FROM `bm_airports` WHERE `airport_code`='$airport'");  
    if ($result && mysqli_num_rows($result) > 0) 
    {
      $country = array();
      while ($row = mysqli_fetch_assoc($result)) {               
                array_push($country, $row);                   
            }
     return $country[0]['country_code'];  
    }
    else return $airport;
}  
  
function getCompany()
{
   $conn = DB_connect();
   $type=$_POST['type'];
   $query="SELECT u.db_name as agency_name,d.login_".$type." as login,d.pass_".$type." as pass FROM `bm_user` u JOIN bm_access_data d ON u.id= d.id_user WHERE u.gds like '%".$type."%'";
   $result = mysqli_query($conn,$query); 
   if ($result && mysqli_num_rows($result) > 0) 
   {
      $companys = array();
      while ($row = mysqli_fetch_assoc($result)) {               
                array_push($companys, $row);                   
            }
     return $companys;
   }
   else
   return "empty";
                    
}

function md5key()
{
    return md5("putinbytefru!)");
}
$db_connection = null;
function DB_connect() {
    global $db_connection;
    if (!isset($db_connection)) {    
        $db_connection = SqlConnect();
		return $db_connection;
    }
    else {
        return $db_connection;
    }
}
function DB_close() {
    global $db_connection;
    if (isset($db_connection))
        mysqli_close($db_connection);
}

function SqlConnect() {
     //$link = mysqli_connect('localhost', 'admin', '556677', 'bm_mytickets');
    $link = mysqli_connect('localhost', 'cy13907_myticket', 'mersc200', 'cy13907_myticket');
    $result = mysqli_query($link, "SET NAMES 'utf8'");
    return $link;
}
function CloseSqlConnect($link) {
    mysqli_close($link);
}
register_shutdown_function('DB_close');
?>