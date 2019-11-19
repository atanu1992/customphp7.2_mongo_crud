<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = 'localhost';
$dbname = 'test';
 
// Connect to test database
$connection = new \MongoDB\Driver\Manager("mongodb://localhost:27017/$dbname");

/*	FETCH DATA  */

$filter = [];
$option = [];
$read = new MongoDB\Driver\Query($filter, $option);

$all_users = $connection->executeQuery("$dbname.users", $read);
foreach ($all_users as $user) {
	echo "<pre>"; print_r($user);
	echo "\n";
}


/*	UPDATE 	*/
$single_update = new MongoDB\Driver\BulkWrite();

$to_get_mongo_id = new MongoDB\BSON\ObjectID('5dd3a33e0da1b325a125cdc7');
$single_update->update(
    ['_id' => $to_get_mongo_id],
    ['$set' => ['first_name' => 'Liton', 'last_name' => 'Atanu']],
    ['multi' => false, 'upsert' => false]
);
$result = $connection->executeBulkWrite("$dbname.users", $single_update);

if($result) {
	echo nl2br("Record updated successfully \n");
}

/*	TO DELETE RECORD */

// $to_get_mongo_id = new MongoDB\BSON\ObjectID('5dd3a33e0da1b325a125cdc7');
$deletes = new MongoDB\Driver\BulkWrite();
$deletes->delete(
    ['_id' => $to_get_mongo_id]
);
$result1 = $connection->executeBulkWrite("$dbname.users", $deletes);

if($result1) {
	echo nl2br("Record deleted successfully \n");
}

?>
