<?php

require __DIR__ . '\vendor\autoload.php';

// Create a MongoDB client
$client = new MongoDB\Client("mongodb://localhost:27017");


echo "Connected to MongoDB successfully!";


// Check if the database exists
$listDatabases = $client->listDatabases();
$databaseExists = false;

foreach ($listDatabases as $databaseInfo) {
    if ($databaseInfo->getName() === 'mystore') {
        $databaseExists = true;
        break;
    }
}

// Display success message
if ($databaseExists) {
    echo "Database 'mystore' exists!";
} else {
    echo "Database 'mystore' does not exist!";
}
?>