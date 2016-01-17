<?php
   	require 'autoload.php';
   	
   	date_default_timezone_set('America/New_York');
   	
   	use Parse\ParseObject;
   	use Parse\ParseQuery;
   	use Parse\ParseUser;
   	use Parse\ParseClient;
   	
   	ParseClient::initialize("9DivrJXQJ1vLWBpWu2iUUAh1btbRW7N8M8oZ8lPQ","zc1ErjpM6rJt25FWUgAn7F6FU8x7Vse1BWCLQxVo", "PbtSepU2zQOK8aF4PGNNNbMgjn2JlZNDRDqbzdnI");
   	
   	// Login
	try {
    	$user = ParseUser::logIn("blah", "blah");
	} catch(ParseException $ex) {
	// error in $ex->getMessage();
	}

	// Current user
	$user = ParseUser::getCurrentUser();
	echo 'Current User is: ' . $user->get("username") . '<br>';

   	//get the sensor arrays from URL
   	//$airTemp= array();
   	$airTemp=$_GET["airTemp"];
	$hum=$_GET["hum"];	
	$sun=$_GET["sun"];
	$waterTemp1=$_GET["watT1"];
	$waterTemp2=$_GET["watT2"];
	$waterPH=$_GET["PH"];
	$level=$_GET["level"];
	$wet=$_GET["wet"];
   	$gardenID=$_GET["id"];
   	
   	echo '<br> Garden ID = ' . $gardenID . '<br>';
   	echo $airTemp . '<br>';
   	echo $waterTemp1 . '<br>';
   	
   	//get garden ID
   	   	
   	$query = new ParseQuery("Garden");
   	$query->equalTo("objectId", $gardenID);
   	$results =  $query->find();

   	$result = $results[0]; 	
   	
   	$reading = new ParseObject("Reading");
   
   	$reading->set("gardenID", $result);
   	$reading->setArray("readings", [intval($airTemp), intval($hum), intval($sun), intval($waterTemp1), intval($waterTemp2),  floatval($waterPH), intval($level), intval($wet)]);
   	try {
   		$reading->save();
 echo '<br>New reading created with objectId: ' . $reading->getObjectId() . '<br>';
} catch (ParseException $ex) {  
  // Execute any logic that should take place if the save fails.
  // error is a ParseException object with an error code and message.
  echo 'Failed to create new object, with error message: ' . $ex->getMessage();
}
   		
   	
?>
