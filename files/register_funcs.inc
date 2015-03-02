<?php


// A string used for md5 encryption.  You could move it to a file
// outside the web tree for more security.
$supersecret_hash_padding = 'A string that is used to pad out short strings for md5 encryption.';


function user_register() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding;

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


  // Are all vars present and passwords match?
  if (strlen($_POST['clientusername']) <= 25 && strlen($_POST['password1']) <= 25 && ($_POST['password1'] == $_POST['password2']) && strlen($_POST['clientemail']) <= 50 && validate_email($_POST['clientemail'])) {
    // Validate username and password
    if (account_namevalid($_POST['clientusername']) || strlen($_POST['password1'] >= 6)) {

      $username = strtolower($_POST['clientusername']);
      $username = trim($username);
      // Don't need to escape, because single quotes aren't allowed
      $email= $_POST['clientemail'];
      // Don't allow duplicate usernames or emails
      $query = "SELECT user_id
                FROM user
                WHERE user_name = '$username'
                OR email = '$email'";
      $result = mysql_query($query);
      if ($result && mysql_num_rows($result) > 0) {
        $feedback = 'ERROR - Username or email address already exists';
        return $feedback;
      } else {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$emailpassword = $_POST['password1'];
    $password = md5($_POST['password1']);
	$user_ip = $_SERVER['REMOTE_ADDR'];
		

        // Create a new hash to insert into the db and the confirmation email
        $hash = md5($email.$supersecret_hash_padding);

        $query = "INSERT INTO user (user_id, user_name, first_name, last_name, password, email, remote_addr, confirm_hash, is_confirmed, role, date_created)
                  VALUES (NULL, '$username', '$first_name', '$last_name', '$password', '$email', '$user_ip', '$hash', 1, 1, NOW())";
        $result = mysql_query($query);
        if (!$result) {
          $feedback = 'ERROR - Database error';
          return $feedback;
        } else {
              $query = "SELECT user_id
                FROM user
                WHERE user_name = '$username'";
                
			  $result = mysql_query($query);
			  if ($result && mysql_num_rows($result) <> 1) {
				$feedback = 'ERROR - Could not get User ID';
				return $feedback;
			  }
              else {
				  $user_id = mysql_result($result, 0, 'user_id');
	     
					$query = "INSERT INTO SoftwareAccess (ClientId, ClientName, AutoAccount, HealthLeap, LeapTo, MarketLeap, POLeap, uploads)
							  VALUES ($user_id, '$username', '$autoaccount', '$healthleap', '$leapto', '$marketleap', '$poleap', '$uploads')";
				
					$result = mysql_query($query);
					if (!$result) {
						$feedback = 'ERROR - Could not add privledges';
					}
				
  			}


			if ($_POST['sendemail'] == '1')
			{
        
			  // Send the confirmation email
			  $encoded_email = urlencode($_POST['clientemail']);
	
			  $mail_body = <<< EOMAILBODY
You have been registered for the Health Quest Software website.  


Your username is: $username
Your password is: $emailpassword


			 http://www.HealthQuestSoftware.com/index.php
EOMAILBODY;
			  mail ($email, 'Health Quest Software Registration', $mail_body, 'From: noreply@healthquestsoftware.com');
			}
	  // Give a successful registration message
          $feedback = 'YOU HAVE SUCCESSFULLY REGISTERED. A confirmation email has been sent.';
          return $feedback;
        }
      }
    } else {
      $feedback =  'ERROR - Username or password is invalid';
      return $feedback;
    }
  } else {
    $feedback = 'ERROR - Please fill in all fields correctly';
    return $feedback;
  }
}




function user_resend() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals	
  global $supersecret_hash_padding;

if (isset($_POST['clientuser_id'])) 
{
	if ($_POST['password1'] != $_POST['password2'])
	{
		$feedback = 'ERROR - Passwords do not match';
		return $feedback;
	}
	else
	{

		// Handle submission.  This is a one-time only form
		// so there will be no problems with handling errors.
		$query = "select 1 from user where user_id = ".$_POST['clientuser_id'];
		$result = mysql_query($query);
		if (!$result || mysql_num_rows($result) <> 1)
		{
			$feedback = 'ERROR - Unable to find user';
			return $feedback;
		} 
		else 
		{
			$as_email = $_POST['clientemail'];
			$password = $_POST['password1'];
			$as_username = $_POST['clientusername'];
			$as_email = addslashes($as_email);
			$is_user = mysql_num_rows($result);
		}	
		
		if ($is_user == 1) 
		{

			if ($_POST['password1'] == "")
			{
				$PassInfo = "";
			}
			else
			{
				$PassInfo = "Password: ".$password;

				// One-way encrypt password
				$crypt_pass = md5($_POST['password1']);
	
				// Create a new hash to insert into the db and the confirmation email
				$hash = md5($as_email.$supersecret_hash_padding);
	
				$query = "update user set password = '$crypt_pass', confirm_hash = '$hash' where user_id = ".$_POST['clientuser_id'];
	
			   // Put password in the db
				$result = mysql_query($query) or die('Cannot complete update'); 
			}
											
			if ($_POST['sendemail'] == '1')
			{

				// Send the confirmation email
				$encoded_email = urlencode($as_email);

				// Send the email
				$to      = $as_email;
				$from    = "noreply@healthquestsoftware.com";
				$subject = "Health Quest Software Profile Update";
				$msg     = <<< EOMSG

Your user information has been updated for the Health Quest Software website.  

			 Username: $as_username
			 
			 $PassInfo


			 http://www.HealthQuestSoftware.com


EOMSG;

				$mailsend = mail("$to","$subject","$msg","From: $from");

				return "User information has been updated.";
			}
			else
			{
				return "User information has been updated.";
			}
		} else {
		// The email address isn't good, they lose.
		}
	}
}
}


function account_namevalid() {

  // must have at least one character
  if (strspn($_POST['clientusername'],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-") == 0) {
    return false;
  }
 
  // must contain all legal characters
  if (strspn($_POST['clientusername'],"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_") != strlen($_POST['clientusername'])) {
    return false;
  }

  // min and max length
  if (strlen($_POST['clientusername']) < 5) {
    return false;
  }
  if (strlen($_POST['clientusername']) > 25) {
    return false;
  }

  // illegal names
  if (eregi("^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)|(halt)|(mail)|(news)|(uucp)|(operator)|(games)|(mysql)|(httpd)|(nobody)|(dummy)|(www)|(cvs)|(shell)|(ftp)|(irc)|(debian)|(ns)|(download))$", $_POST['username'])) {
    return false;
  }
  if (eregi("^(anoncvs_)", $_POST['clientusername'])) {
    return false;
  }

return true;
}


function validate_email($email) {
  return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email));
}


function user_confirm() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding;

  // Verify that they didn't tamper with the email address
  $new_hash = md5($_GET['email'].$supersecret_hash_padding);
  if ($new_hash && ($new_hash == $_GET['hash'])) {
    $query = "SELECT user_name
              FROM user
              WHERE confirm_hash = '$new_hash'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) < 1) {
      $feedback = 'ERROR - Hash not found';
      return $feedback;
    } else {
      // Confirm the email and set account to active
      $email = $_GET['email'];
      $hash = $_GET['hash'];
      $query = "UPDATE user SET email='$email', is_confirmed=1 WHERE confirm_hash='$hash'";
      $result = mysql_query($query);
      return 1;
    }
  } else {
    $feedback = 'ERROR - Values do not match';
    return $feedback;
  }
}

?>