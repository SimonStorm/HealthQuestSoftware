<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Picture Processor</title>
    <LINK href="../style.css" rel="stylesheet" type="text/css">
</HEAD>
<body>


<BR>
<BR>
<form action="index.php" method="post">
<p align="center">
Enter Client Number: <input name="ClientNum" type="text" size="3"> <input name="submit" type="submit" value="Submit">
</p>
</form>
<BR>
<BR>
<p align="center">
<?php
$db_host='localhost';
$db_database='Quest';
$db_username='root';
$db_password='root';
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

include('functions.php');

if(isset($_POST['ClientNum']))
{
	//$dir = 'SoftwareFiles';
	//chdir($dir);
	
	$files = filelist ('./', 1, 0, "all", 1);
	
	//$files = filelist("./",1,1); // call the function
	
	$AccessQuery = 'SELECT * FROM SoftwareAccess WHERE ClientId = '.$_POST['ClientNum'];
	$AccessResult = mysql_query( $AccessQuery );
	if (!$AccessResult)
	{
		die ("Could not get access rules from the database: <br />". mysql_error());
	}
	elseif (mysql_num_rows($AccessResult) > 0)
	{
		while ($AccessRow = mysql_fetch_array($AccessResult, MYSQL_ASSOC)) 
		{
			$Software1 = $AccessRow['Software1'];
			$Software2 = $AccessRow['Software2'];
			$Software3 = $AccessRow['Software3'];
			$Software4 = $AccessRow['Software4'];
			$Software5 = $AccessRow['Software5'];
		}
	}
	
	foreach ($files as $list) {//print array
		if ($list['dir'] == 1 &&  $list['level'] > 1)
		{
			if ($Software1 == 'Y' && $list['name'] == 'Software1')
			{
				echo "<br>".$list['name']."<br>";
			}
			if ($Software2 == 'Y' && $list['name'] == 'Software2')
			{
				echo "<br>".$list['name']."<br>";
			}
			if ($Software3 == 'Y' && $list['name'] == 'Software3')
			{
				echo "<br>".$list['name']."<br>";
			}
			if ($Software4 == 'Y' && $list['name'] == 'Software4')
			{
				echo "<br>".$list['name']."<br>";
			}
			if ($Software5 == 'Y' && $list['name'] == 'Software5')
			{
				echo "<br>".$list['name']."<br>";
			}
	
		}
		elseif ($list['level'] > 1)
		{
			if ($Software1 == 'Y' && strpos($list['path'], 'Software1'))
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$list['path'].$list['name']."\" target=\"_new\">".$list['name']."</a><br>";
			}
			if ($Software2 == 'Y' && strpos($list['path'], 'Software2'))
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$list['path'].$list['name']."\" target=\"_new\">".$list['name']."</a><br>";
			}
			if ($Software3 == 'Y' && strpos($list['path'], 'Software3'))
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$list['path'].$list['name']."\" target=\"_new\">".$list['name']."</a><br>";
			}
			if ($Software4 == 'Y' && strpos($list['path'], 'Software4'))
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$list['path'].$list['name']."\" target=\"_new\">".$list['name']."</a><br>";
			}
			if ($Software5 == 'Y' && strpos($list['path'], 'Software5'))
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$list['path'].$list['name']."\" target=\"_new\">".$list['name']."</a><br>";
			}
		}
	}
}
?>
</p>
</body>
</html>
