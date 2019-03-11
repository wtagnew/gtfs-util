<!DOCTYPE html>
<html>
<head>
  <title>Import GTFS</title>
</head>
<body>

<?php
ini_set('auto_detect_line_endings',TRUE);  // To deal with Mac line endings
$path = "gtfs/";
$files = array("feed_info.txt", "agency.txt", "calendar.txt", "calendar_dates.txt", "routes.txt", "stops.txt", 
  "transfers.txt", "shapes.txt", "trips.txt", "frequencies.txt", "stop_times.txt", 
  "fare_attributes.txt", "fare_rules.txt");

function sqlImport($files)
{
  $mysql_host = "localhost";
  $mysql_user = "gtfs";
  $mysql_password = "gtfs";
  $mysql_database = "gtfs";
  $sql_query = "";
  $sql_result = "";
  global $path, $files;
  
  try
  {
    // Connecting, selecting database
    $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;charset=utf8", "$mysql_user", "$mysql_password", 
      array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    echo "Connected to database $mysql_database successfully.<br/>\n";
    
    foreach($files as $file)
    {
      echo "Importing $file... ";
      if (($handle = @fopen($path . $file, "r")) !== FALSE)  // if file exists
      {
	// Prepare query
	$sql_table = (substr($file, 0, -4)); // Strip extension from file for table name
	$sql_tables = fgetcsv($handle);  // Get table names (and ignore first line with table headers)
	$sql_tables_str = implode(",", $sql_tables);
	$sql_query = "INSERT INTO $sql_table($sql_tables_str) VALUES(?";
	//echo "Count: " . count($sql_tables) . "\n";  // For debugging
	//echo "Tables: " . implode(" ", $sql_tables) . "\n";  // For debugging
	//echo "Tables: $sql_tables_str\n";  // For debugging
	for($i = 0; $i < count($sql_tables) - 1; $i++)
	{
	  $sql_query .= ", ?";  // Append the appropriate number of variables for statement
	}
	$sql_query .= ");";
	//echo "Query: $sql_query\n";  // For debugging
	
	// Insert values
	while (($line = fgetcsv($handle)) !== FALSE)
	{
	  //echo "Line: " . implode(" ", $line) . "\n";  // For debugging
	  $sql_statement = $db->prepare("$sql_query");
	  $sql_statement->execute($line);
	  //$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	fclose($handle);
	echo "imported successfully.<br/>\n";
      }
      else
      {
	echo "No file or permissions for $path" . $file . ".<br/>\n";
      }
    }
  }
  catch(PDOException $ex)
  {
    echo "<br/>\nA database error occured: ";
    echo $ex->getMessage();
  }
  catch(Exception $ex)
  {
    echo "<br/>\nAn error occured: ";
    echo $ex->getMessage();
  }
  
  // Free objects and close database connection
  $sql_statement = NULL;
  $db = NULL;
}

sqlImport($files);
?>
</body>
</html>
