<?php
  $mysql_host = "localhost";
  $mysql_database = "gtfs";
  $mysql_user = "gtfs";
  $mysql_password = "gtfs";
  //agency();
  
  function agency()
  {
  	global $mysql_host, $mysql_database, $mysql_user, $mysql_password;
  	try
  	{
    // Connecting, selecting database
    $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database;charset=utf8", "$mysql_user", "$mysql_password",
      array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    //echo "Connected to database $mysql_database successfully.<br/>\n";
    
    echo '<table><tr><td>';
    
    echo getTable($db, 'agency') . '<br>';
    echo '</td><td><td width="100px"> </td><td>';
    echo getTable($db, 'feed_info') . '<br>';
    echo '</td></tr><tr><td>';
    echo getTable($db, 'calendar') . '<br>';
    echo '</td></tr></table><br><br><br>';
    echo getTable($db, 'routes') . '<br>';
    echo getTable($db, 'shapes') . '<br>';
    echo getTable($db, 'stop_times') . '<br>';
    echo getTable($db, 'stops') . '<br>';
    echo getTable($db, 'trips') . '<br>';
    
    
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
  }
  
  function getTable($db, $table)
  {
  	$html = '<table><th>' . $table . '</th>';
  	
  	// Get table headers
  	$statement = $db->query("DESCRIBE " . $table);
  	$rows = $statement->fetchAll(PDO::FETCH_COLUMN);
  	
  	// Get results
  	$statement = $db->query('SELECT * FROM ' . $table);
  	$results = $statement->fetchAll(PDO::FETCH_ASSOC);
  	
  	foreach($rows as $row)
  	{
	  	$name = $table . "_" . $row;
	  	$html .= '<tr><td>' . $row . '</td><td>';
	  	$html .= '<input type="text" name="' . $name . '" value="' . $results[0][$row] . '">' . '</td></tr>';
  	}
  	
  	$html .= '</table>';
  	return $html;
  }
?>