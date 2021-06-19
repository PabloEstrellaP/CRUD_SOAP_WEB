<?php
$client = new SoapClient(null, array(
      'location' => "http://localhost/crud_SOAP/server.php",
      'uri'      => "http://localhost/crud_SOAP/server.php",
      'trace'    => 1 )
);
?>