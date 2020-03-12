<?php
require_once('./lib/nusoap.php');
// This is your Web service server WSDL URL address
$wsdl = "http://localhost/latihannusoap/server.php?wsdl";
// $wsdl = "http://localhost/latihannusoap/server.php?wdsl"

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$err = $client->getError();
if ($err) {
   // Display the error
   echo '<h2>Constructor error</h2>' . $err;
   // At this point, you know the call that follows will fail
   exit();
}



// Call the hello method
$result1=$client->call('createCustomer', 
            array(
               'customerNumber'=>'1111',
               'customerName'=>'Aii',
               'contactLastName'=>'ER',
               'contactFirstName'=>'Mentari',
               'phone'=>'08180908090',
               'addressLine1'=>'Concat',
               'addressLine2'=>'',
               'city'=>'Sleman',
               'state'=>'DIY',
               'postalCode'=>'55283',
               'country'=>'Indonesia',
               'salesRepEmployeeNumber'=>'1370',
               'creditLimit'=>'5000000'
               )
            );
print_r($result1).'\n';
?>