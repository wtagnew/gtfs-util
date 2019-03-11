Created by William Agnew for the MyMetro Senior Capstone at Miami University.

Prerequisites:
* SQL Database called gtfs with password gtfs (with necessary privileges).

Files:
* import.php:  Import GTFS files from directory named gtfs into the database.
  Usage:  php import.php
* export.php:  Export from the database to a GTFS file name gtfs.zip
	       (and extracted directory gtfs).
  Usage:  php export.php
  WARNING:  Will overwrite gtfs file and directory in current directory.




