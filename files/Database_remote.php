<?php
$db_host='localhost';
$db_database='storm_Quest';
$db_username='storm_quest';
$db_password='hqsoft';
$connection = mysql_connect($db_host, $db_username, $db_password);

if (!$connection)
{
	die ("Could not connect to the database: <br />". mysql_error());
}

$db_select = mysql_select_db($db_database);
if (!$db_select)
{
	die ("Could not select the database: <br />". mysql_error());
}
?>