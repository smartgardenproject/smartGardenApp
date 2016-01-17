<?php
   	//include("connect.php");
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
	$waterTemp=$_GET["waterTemp"];
	$sun=$_GET["sun"];
	$wet=$_GET["wet"];
	$waterPH=$_GET["waterPH"];
   	$gardenID=$_GET["id"];
   	
   	echo '<br> Garden ID = ' . $gardenID . '<br>';
   	echo $airTemp . '<br>';
   	echo $waterTemp . '<br>';
   	
   	//get garden ID
   	   	
   	$query = new ParseQuery("Garden");
   	$query->equalTo("objectId", $gardenID);
   	$results =  $query->find();

   	$result = $results[0]; 	
   	
   	//get garden sensors list
   	$sensors = $result->get("pName");
   	echo "<br>We are expecting these sensors: " . $sensors; 	
   	
   	
   	/* assign sensor values based on above sensor list
   	
   	for ($i = 0; $i < count($sensors); $i++) {
  		$object = $sensors[$i];
 	 	echo $object;
 	 	
	}
   	
   	*/
   	
   	//assemble sensor array
   	
   	function arrayize($input) 
   	{
   		return array_map('floatval', array_filter( explode(",",$input), 'is_numeric'));
   	}
   	//$currentReadings = preg_split("\"",

   	
   	$reading = new ParseObject("Reading");
   
   	$reading->set("gardenID", $result);
   	$reading->setArray("readings", [arrayize($airTemp), arrayize($hum), arrayize($waterTemp), arrayize($sun), arrayize($wet), arrayize($waterPH)]);
   	try {
   		$reading->save();
 echo '<br>New reading created with objectId: ' . $reading->getObjectId() . '<br>';
} catch (ParseException $ex) {  
  // Execute any logic that should take place if the save fails.
  // error is a ParseException object with an error code and message.
  echo 'Failed to create new object, with error message: ' . $ex->getMessage();
}
   		
   	
?>
