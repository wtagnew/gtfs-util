<!DOCTYPE html>
<html>
<head>
  <title>Export GTFS</title>
</head>
<body>

<?php
$path = "gtfs";
$files = array();
$zipfile_name = "gtfs.zip";

function sqlExport()
{
  $mysql_host = "localhost";
  $mysql_user = "gtfs";
  $mysql_password = "gtfs";
  $mysql_database = "gtfs";
  $sql_query = "";
  $sql_result = "";
  $sql_tables = array("agency", "calendar", "calendar_dates", "fare_attributes", "fare_rules", "feed_info", 
    "frequencies", "routes", "shapes", "stop_times", "stops", "transfers", "trips");
  global $path, $files, $zipfile_name;
  
  try
  {
    // Connecting, selecting database
    $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;charset=utf8", "$mysql_user", "$mysql_password", 
      array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    echo "Connected to database $mysql_database successfully.<br/>\n";
    
    // Make temporary directory to hold the text files
    if (!is_dir($path))
    {
      mkdir($path);
      $path .= "/";
    }
    // Otherwise delete any remaining files
    else
    {
      $path .= "/";
      $files = glob($path . "*");  // Get all file names
      foreach($files as $file)  // Iterate files
      {
	if(is_file($file))
	  unlink($file);  // Delete file
      }
    }
    // Also delete zip file if it exists
    if(is_file($zipfile_name))
	  unlink($zipfile_name);  // Delete file
    
    foreach($sql_tables as $sql_table)
    {
      echo "Exporting $sql_table... ";
      
      // Get column names
      $sql_columns = "";
      $sql_statement = $db->query("SHOW COLUMNS FROM $sql_table");
      while($row = $sql_statement->fetch(PDO::FETCH_NUM))
      {
	$sql_columns .= $row[0] . ",";
      }
      $sql_columns = substr($sql_columns, 0, -1);  // Delete last comma
      //echo $sql_columns;  // For debugging
      
      // Get data from table
      $sql_statement = $db->query("SELECT * FROM $sql_table");
      $row_count = $sql_statement->rowCount();
      //echo "Row count:  $row_count\n";  // For debugging
      
      if ($row_count > 0)  // if there's data in the table
      {
	$filename = $path . $sql_table . ".txt";
	if (($handle = @fopen($filename, "w")) !== FALSE)  // if file writable
	{
	  // Output column names to line 1
	  @fwrite($handle, $sql_columns . "\n");
	  
	  // Output data
	  while($row = $sql_statement->fetch(PDO::FETCH_NUM))
	  {
	    $data = implode(",", $row);
	    @fwrite($handle, $data . "\n");
	  }
	  
	  fclose($handle);
	  echo "exported successfully.<br/>\n";
	}
	else
	{
	  echo "Cannot open file for writing.<br/>\n";
	  die();
	}
      }
      else
      {
	echo "No data in $sql_table" . ".<br/>\n";
      }
    }
    // Ceate zip file
    /*$zip = new ZipArchive;
    if ($zip->open($zipfile_name, ZIPARCHIVE::OVERWRITE) === TRUE)
    {
      foreach($files as $file)  // Iterate files
      {
	 $new_file = substr($file, strlen($path) - 1);  // Remove path from filename
	 $zip->addFile($file, $new_file);
      }
      $zip->close();
      echo "$zipfile_name created.<br/>\n";
    }
    else
    {
      echo "Could not save zip archive.<br/>\n";
    }*/
    
    // Create zip file from command (the built-in doesn't preserve execute permissions, a probelem for GTFS)
    $return_var = 0;
    $status = @exec("zip -j $zipfile_name $path*", $output, $return_var);
    if($return_var == 0)
    {
      echo "$zipfile_name created.<br/>\n";
    }
    else
    {
      echo "Could not save zip archive.<br/>\n";
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

sqlExport();
?>
</body>
</html>
