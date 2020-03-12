<?php

require_once("./lib/nusoap.php");
 
//Create a new soap server
$server = new soap_server();
$server->configureWSDL('server', 'urn:server');

$server->wsdl->schemaTargetNamespace = 'urn:server';

// SOAP complex type return type (an array/struct)
$server->wsdl->addComplexType(
   'Person',
   'complexType',
   'struct',
   'all',
   '',
   array('id_user' => array('name' => 'id_user',
         'type' => 'xsd:int'))
);

// Register the "hello" method to expose it
$server->register('getCustomer',
         array(
            'customerNumber' => 'xsd:string',   // parameter
            'customerName' => 'xsd:string'
            ),
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'mendapatkan 1 customer');           // description

// Implement the "hello" method as a PHP function
function getCustomer($customerNumber) {
    $sql = "SELECT customerName FROM customers WHERE customerNumber = ".$customerNumber."";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            return $row["customerName"];
        }
    } else {
        return "0 results";
    }

    mysqli_close($conn);
}

//register server
$server->register('deleteCustomer',
         array(
            'customerNumber' => 'xsd:string',   // parameter
            'customerName' => 'xsd:string',
            'contactLastName' => 'xsd:string' 
            ),
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'mendapatkan 1 customer');           // description

//new function create, update, delete
//register server
$server->register('updateCustomer',
         array(
            'customerNumber' => 'xsd:string',   // parameter
            'customerName' => 'xsd:string',
            'contactLastName' => 'xsd:string' 
            ),
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'mendapatkan 1 customer');           // description
         
//register server
$server->register('createCustomer',
         array(
            'customerNumber' => 'xsd:string',   // parameter
            'customerName' => 'xsd:string',
            'contactLastName' => 'xsd:string',
            'contactFirstName' => 'xsd:string',
            'phone' => 'xsd:string',
            'addressLine1' => 'xsd:string',
            'addressLine2' => 'xsd:string',
            'city' => 'xsd:string',
            'state' => 'xsd:string',
            'postalCode' => 'xsd:string',
            'country' => 'xsd:string',
            'salesRepEmployeeNumber' => 'xsd:string',
            'creditLimit' => 'xsd:string'
            ),
         array('return' => 'xsd:string'),     // output
         'urn:server',                        // namespace
         'urn:server#helloServer',            // soapaction
         'rpc',                               // style
         'encoded',                           // use
         'mendapatkan 1 customer');           // description

function createCustomer($customerNumber, $customerName, $contactLastName, $contactFirstName, $phone, $addressLine1, $addressLine2, $city, $state, $postalCode, $country, $salesRepEmployeeNumber, $creditLimit)
{
   require_once "./connect.php";
   $sql="INSERT INTO customers VALUES ('".$customerNumber."', '".$customerName."', '".$contactLastName."','".$contactFirstName."', '".$phone."', '".$addressLine1."', '".$addressLine2."', '".$city."', '".$state."', '".$postalCode."', '".$country."', '".$salesRepEmployeeNumber."', '".$creditLimit."')";

   if(mysqli_query($conn,$sql)){
      return "berhasil masuk nichhh : ".$customerNumber." nama : ".$customerName;
   }else{
      return "error updating record: ".mysqli_error($conn);
   }

}         
function updateCustomer($customerNumber, $customerName, $contactLastName)
{
   require_once "./connect.php";
   $sql="UPDATE customers SET customerName='".$customerName."' WHERE customerNumber=".$customerNumber."";

   if(mysqli_query($conn,$sql)){
      return "berhasil";
   }else{
      return "error updating record: ".mysqli_error($conn);
   }
}

function deleteCustomer($customerNumber, $customerName)
{  
   require_once "./connect.php";
   $sql="DELETE FROM customers WHERE customerNumber='.$customerNumber.'";

   if(mysqli_query($conn, $sql)){
      return "berhasil hapus : ".$customerName." dengan id :".$customerNumber;
   } else {
      return "ga berhasil dihapus nich".mysqli_error($conn);
   }
}


$GLOBALS['HTTP_RAW_POST_DATA'] = file_get_contents ('php://input');
$HTTP_RAW_POST_DATA = $GLOBALS['HTTP_RAW_POST_DATA'];

// Use the request to invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);