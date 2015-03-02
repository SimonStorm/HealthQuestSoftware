<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Health Quest Software</title>
</HEAD>
<body>

<?php 

//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";


if (isset($_SESSION['Role']))
{
	if ($_SESSION['Role'] == "0")
	{
?>

<table border="0" align="center" width="100%">
	<tr align="center">
		<td colspan="4"><H1>Application Usage Logs</H1></td>
	</tr>
	<tr align="center">
		<td colspan="4">
			<table align="center" width="70%">
				<TR>
					<td align="center">

<?php

/**********************************************
* This file displays the change non-sensitive *
* user data form.  It submits to itself, and  *
* displays a message each time you submit.    *
***********************************************/



include_once('login_funcs.inc');
include_once("Database.php");
include_once('register_funcs.inc');



?>


<TABLE WIDTH="80%">
	<TR ALIGN=CENTER>
		<TD COLSPAN=5>
			<a href="../index.php">[home]</a>
		</TD>
	</TR>
	<TR ALIGN=CENTER>
		<TD>
			Date
		</TD>
		<TD>
			Username
		</TD>
		<TD>
			Action
		</TD>
		<TD>
			File
		</TD>
		<TD>
			IP Address
		</TD>
	</TR>

<?php 
  // Get previously-existing data
$UserQuery = "SELECT *
            FROM userlog u
            WHERE role <> 0
			ORDER BY u.timestamp DESC";
$UserResults = mysql_query( $UserQuery );
if (!$UserResults)
{
	die ("Could not get Users from the database: <br />". mysql_error());
}
elseif (mysql_num_rows($UserResults) > 0)
{
	while ($UserResultsRow = mysql_fetch_array($UserResults, MYSQL_ASSOC)) 
	{
		echo "<TR>";
		echo "<TD>".$UserResultsRow['timestamp']."</TD>";
		echo "<TD>".$UserResultsRow['user_name']."</TD>";
		echo "<TD>".$UserResultsRow['action']."</TD>";
		echo "<TD>".$UserResultsRow['details']."</TD>";
		echo "<TD>".$UserResultsRow['remote_addr']."</TD>";
		echo "</TR>";
	}
}	
	
	
	
	
	
	}
	else
	{
		echo "You do not have access to this page";
	}
}
else
{
	echo "You are not logged in or do not have access to this site";
}
?>

</TABLE>

</body>
</html>