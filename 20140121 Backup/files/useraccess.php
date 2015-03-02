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
		<td colspan="4"><H1>User Administration</H1></td>
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


$status_message = "";
$userlist = "";
$JavaString = "";
//$username = $_SESSION['username'];


if (isset($_POST['HealthLeap'])) 
{
	$healthleap = "Y";
}
else
{
	$healthleap = "N";
}

if (isset($_POST['AutoAcct'])) 
{
	$autoaccount = "Y";
}
else
{
	$autoaccount = "N";
}

if (isset($_POST['LeapTo'])) 
{
	$leapto = "Y";
}
else
{
	$leapto = "N";
}

if (isset($_POST['MarketLeap'])) 
{
	$marketleap = "Y";
}
else
{
	$marketleap = "N";
}

if (isset($_POST['POLeap'])) 
{
	$poleap = "Y";
}
else
{
	$poleap = "N";
}

if (isset($_POST['Uploads'])) 
{
	$uploads = "Y";
}
else
{
	$uploads = "N";
}

include_once('login_funcs.inc');
include_once("Database.php");
include_once('register_funcs.inc');


if (isset($_POST['clientuser_id'])) {

	if ($_POST['submit'] == 'Add new user')
	{
		$status_message = user_register();
	}
	elseif ($_POST['submit'] == 'Delete user')
	{
		$query = "DELETE from user
				  WHERE user_id = ".$_POST['clientuser_id'];
	
		$result = mysql_query($query);
		if (!$result) {
		  $status_message = 'Problem deleting user';
		} else {
		$query = "DELETE from SoftwareAccess
					  WHERE ClientId = ".$_POST['clientuser_id'];
		
			$result = mysql_query($query);
			if (!$result) {
			  $status_message = 'Problem deleting Access Info';
			} else {
			  $status_message = 'Successfully delete user';
			}
		}
	}
	else
	{
		$PassReset = user_resend();

		if ($PassReset == 'User information has been updated.')
		{
			$query = "UPDATE user
					  SET user_name = '".$_POST['clientusername']."',
						first_name = '".$_POST['first_name']."',
						last_name = '".$_POST['last_name']."',
						role = 1,
						email = '".$_POST['clientemail']."'
					  WHERE user_id = ".$_POST['clientuser_id'];
		
			$result = mysql_query($query);
			if (!$result) {
			  $status_message = 'Problem with user data entry';
			} else {
				$query = "UPDATE SoftwareAccess
						  SET AutoAccount = '".$autoaccount."',
							HealthLeap = '".$healthleap."',
							LeapTo = '".$leapto."',
							MarketLeap = '".$marketleap."',
							POLeap = '".$poleap."',
							uploads = '".$uploads."'
						  WHERE ClientId = ".$_POST['clientuser_id'];
			
				$result = mysql_query($query);
				if (!$result) {
				  $status_message = 'Problem with user data entry';
				} else {
				  $status_message = 'Successfully edited user data';
				}
			}
		}
		else
		{
			 $status_message = $PassReset;
		}
	}
}
  // Get previously-existing data
$UserQuery = "SELECT u.user_id, u.user_name, u.first_name, u.last_name, u.email, AutoAccount, HealthLeap, LeapTo, MarketLeap, POLeap, uploads
            FROM user u, SoftwareAccess S
            WHERE u.role <> 0
            AND u.user_id = S.ClientID
			ORDER BY u.last_name, u.first_name, u.user_id";
$UserResults = mysql_query( $UserQuery );
if (!$UserResults)
{
	die ("Could not get Users from the database: <br />". mysql_error());
}
elseif (mysql_num_rows($UserResults) > 0)
{
	while ($UserResultsRow = mysql_fetch_array($UserResults, MYSQL_ASSOC)) 
	{
		$clientuser_id = $UserResultsRow['user_id'];
		$clientusername = $UserResultsRow['user_name'];
		$first_name = $UserResultsRow['first_name'];
		$last_name = $UserResultsRow['last_name'];
		$clientemail = $UserResultsRow['email'];
		if ($UserResultsRow['AutoAccount'] == 'Y') {
			$chk_autoaccount = 'true';
		} else {
			$chk_autoaccount = 'false';
		}
		if ($UserResultsRow['HealthLeap'] == 'Y') {
			$chk_healthleap = 'true';
		} else {
			$chk_healthleap = 'false';
		}
		if ($UserResultsRow['LeapTo'] == 'Y') {
			$chk_leapto = 'true';
		} else {
			$chk_leapto = 'false';
		}
		if ($UserResultsRow['MarketLeap'] == 'Y') {
			$chk_marketleap = 'true';
		} else {
			$chk_marketleap = 'false';
		}
		if ($UserResultsRow['POLeap'] == 'Y') {
			$chk_poleap = 'true';
		} else {
			$chk_poleap = 'false';
		}
		if ($UserResultsRow['uploads'] == 'Y') {
			$chk_uploads = 'true';
		} else {
			$chk_uploads = 'false';
		}

		$userlist .= "<option value=\"$clientuser_id\">$first_name $last_name</option>";
		
		$JavaString .= "if(inValue == ".$clientuser_id.") { 
							inForm.clientemail.value = \"".$clientemail."\";
							inForm.clientusername.value = \"".$clientusername."\";
							inForm.first_name.value = \"".$first_name."\";
							inForm.last_name.value = \"".$last_name."\";
							inForm.clientuser_id.value = \"".$clientuser_id."\"; 
							inForm.AutoAcct.checked = ".$chk_autoaccount.";
							inForm.HealthLeap.checked = ".$chk_healthleap.";
							inForm.LeapTo.checked = ".$chk_leapto.";
							inForm.MarketLeap.checked = ".$chk_marketleap.";
							inForm.POLeap.checked = ".$chk_poleap.";
							inForm.Uploads.checked = ".$chk_uploads.";
							}";
									
		$clientuser_id = $UserResultsRow['user_id'];
		$clientusername = "";
		$first_name = "";
		$last_name = "";
		$clientemail = "";
		$chk_autoaccount = 'false';
		$chk_healthleap = 'false';
		$chk_leapto = 'false';
		$chk_marketleap = 'false';
		$chk_poleap = 'false';
		$chk_uploads = 'false';

	}
	
	$SecurityInput = "";

	$SecurityInput = $SecurityInput."<option value=\"Owner\">Owner</option><option value=\"Guest\">Guest</option>";

}

?>

<SCRIPT LANGUAGE="JavaScript">

function Validate(inForm) {
	
	var radioLength = inForm.confirmed.length;
	for(var i = 0; i < radioLength; i++) {
		if(inForm.confirmed[i].checked == true) 
		{
			ConfirmVal = inForm.confirmed[i].value;
		}
	}

	if(ConfirmVal == 0 && (inForm.password1.value == '' || inForm.password1.value == null || inForm.password2 == '' || inForm.password2.value == null))
	{
		alert('Passwords must be populated if Confirmed is set to No');
		return false;
	}
	else if(inForm.username.value.length < 6)
	{
		alert('Username must be at least six characters');
		return false;
	}
	else if(inForm.password1.value.length > 0 && (inForm.password1.value.length < 8 || inForm.password2.value.length < 8 ))
	{
		alert('Password must be at least eight characters');
		return false;
	}
	else if(inForm.email.value.length < 5 || inForm.email.value.indexOf("@") == -1 || inForm.email.value.indexOf(".") == -1)
	{
		alert('Email must be a valid email address');
		return false;
	}
	else
	{
		return true;
	}

}

function ValidatePswd(inForm) {

	if(inForm.password1.value == '' || inForm.password1.value == null || inForm.password2 == '' || inForm.password2.value == null)
	{
		alert('Passwords must be populated for a new user');
		return false;
	}
	else
	{
		return true;
	}
}

function PopulateUser(inValue, inForm) {
	<?php echo $JavaString	?>
}

</SCRIPT>


<?php
  // --------------
  // Construct form
  // --------------

//  site_header('User data edit page');

  $userform_str = <<< EOUSERFORMSTR
<TABLE ALIGN=CENTER WIDTH=40%>
<TR>
  <TD ROWSPAN=10><IMG WIDTH=15 HEIGHT=1 SRC="../images/spacer.gif"></TD>
  <TD WIDTH=606></TD>
</TR>
<TR>
 <TD>

<FORM NAME=UserForm ACTION="useraccess.php" METHOD="POST" ONSUBMIT="return Validate(this);">

<TABLE>
	<TR ALIGN=CENTER>
		<TD COLSPAN=2>
			<a href="../index.php">[home]</a>
		</TD>
	</TR>
	<TR ALIGN=CENTER>
		<TD COLSPAN=2>
			<select SIZE=5 name=Users onclick="PopulateUser(this.value, this.form);">
				$userlist;
			</select>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=2 HEIGHT=25>
			&nbsp;
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=2>
			<FONT COLOR="#ff0000">$status_message</FONT>
		</TD>
	</TR>
	<TR>
		<TD>
			Username:
		</TD>
		<TD>
			Email:
		</TD>
	</TR>
	<TR>
		<TD>
			<INPUT TYPE="TEXT" NAME="clientusername" SIZE="40">
		</TD>
		<TD>
			<INPUT TYPE="TEXT" NAME="clientemail" SIZE="40">
		</TD>
	</TR>
	<TR>
		<TD>
			First Name:
		</TD>
		<TD>
			Last Name:
		</TD>
	</TR>
	<TR>
		<TD>
			<INPUT TYPE="TEXT" NAME="first_name" SIZE="40">
		</TD>
		<TD>
			<INPUT TYPE="TEXT" NAME="last_name" SIZE="40">
		</TD>
	</TR>
	<TR>
		<TD>
			Password:
		</TD>
		<TD>
			Password Again:
		</TD>
	</TR>
	<TR>
		<TD>
			<INPUT TYPE="PASSWORD" NAME="password1" SIZE="40">
		</TD>
		<TD>
			<INPUT TYPE="PASSWORD" NAME="password2" SIZE="40">
		</TD>
	</TR>
	<TR>
		<TD colspan="2">
			Send Email:
		</TD>
	</TR>
	<TR>
		<TD colspan="2">
			<INPUT TYPE="RADIO" NAME="sendemail" VALUE="1" CHECKED>Yes <INPUT TYPE="RADIO" NAME="sendemail" VALUE="0">No
		</TD>
	</TR>
	<INPUT TYPE="HIDDEN" NAME="clientuser_id" SIZE="40">
	<TR>
		<TD colspan="2">
			Select Folders to Display:
		</TD>
	</TR>
	<TR>
		<TD colspan="2">
			<INPUT TYPE="CHECKBOX" NAME="AutoAcct">Auto Account &nbsp;&nbsp;&nbsp;
			<INPUT TYPE="CHECKBOX" NAME="HealthLeap">Health Leap &nbsp;&nbsp;&nbsp;
			<INPUT TYPE="CHECKBOX" NAME="LeapTo">Leap To &nbsp;&nbsp;&nbsp;
			<INPUT TYPE="CHECKBOX" NAME="MarketLeap">Market Leap &nbsp;&nbsp;&nbsp;
			<INPUT TYPE="CHECKBOX" NAME="POLeap">PO Leap &nbsp;&nbsp;&nbsp;
			<INPUT TYPE="CHECKBOX" NAME="Uploads">Uploads &nbsp;&nbsp;&nbsp;
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=3 HEIGHT=25>
			&nbsp;
		</TD>
	</TR>
</TABLE>

 </TD>
</TR>
</TABLE>
EOUSERFORMSTR;

  echo $userform_str;

?>
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Edit user data">
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Add new user" onclick="return ValidatePswd(this.form);">
<INPUT TYPE="SUBMIT" NAME="submit" VALUE="Delete user">
</FORM>


<?php 
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
</body>
</html>
