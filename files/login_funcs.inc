<?php

// A string used for md5 encryption.  You could move it to a file 
// outside the web tree for more security.
$supersecret_hash_padding = 'A string that is used to pad out short strings for md5 encryption.';

//echo "SESSION";
//echo "<pre>";
//print_r ($_SESSION);
//echo "</pre>";

//echo "POST";
//echo "<pre>";
//print_r ($_POST);
//echo "</pre>";



$LOGGED_IN = false;
unset($LOGGED_IN);


function user_isloggedin() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  global $supersecret_hash_padding, $LOGGED_IN;

  // Have we already run the hash checks? 
  // If so, return the pre-set var
  if (isSet($LOGGED_IN)) {
    return $LOGGED_IN;
  }
  if (isset($_SESSION['username']) && isset($_SESSION['id_hash'])) 
  {
	  if ($_SESSION['username'] && $_SESSION['id_hash']) {
		$hash = md5($_SESSION['username'].$supersecret_hash_padding);
		if ($hash == $_SESSION['id_hash']) {
		  return true;
		} else {
		  return false;
		}
	  } else {
		return false;
	  }
	}
	else 
	{
		return false;
	}
}


function user_login() {
  // This function will only work with superglobal arrays, because
  // I'm not passing in any values or declaring globals
  if (!$_POST['username'] || !$_POST['password']) {
    $feedback = 'ERROR - Missing username or password';
    return $feedback;
  } else {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    // Don't need to trim because extra spaces should fail for this
    // Don't need to addslashes because single quotes aren't allowed
    // Don't need to addslashes because we'll be hashing it
    $crypt_pwd = md5($password);
    $query = "SELECT user_id, user_name, is_confirmed, role, first_name, last_name, email
              FROM user
              WHERE user_name = '$username'
              AND password = '$crypt_pwd'";
    $result = mysql_query($query);
    if (!$result || mysql_num_rows($result) < 1){
      $feedback = 'ERROR - User not found or password incorrect';
      return $feedback;
    } else {
      if (mysql_result($result, 0, 'is_confirmed') == '1') {
	       $FirstName = mysql_result($result, 0, 'first_name');
	       $LastName = mysql_result($result, 0, 'last_name');	       
	       $Email = mysql_result($result, 0, 'email');	       	       
	       $role = mysql_result($result, 0, 'role');	       	       
	       $user_id = mysql_result($result, 0, 'user_id');	       	       
	       user_set_tokens($username, $role, $FirstName, $LastName, $Email, $user_id);
	       $user_ip = $_SERVER['REMOTE_ADDR'];
	       
			// INSERT INTO LOG
		    $LogQuery = "INSERT INTO userlog (user_name, role, remote_addr, action)
    					VALUES ('$username', $role, '$user_ip', 'Login')";
    					
			$result = mysql_query($LogQuery);
		    if (!$result) 
		    {
        		$feedback = 'ERROR - Database error';
				return $feedback;
        	}
        	// END INSERT INTO LOG  

	       return 1;
      } else {
	       $feedback = 'ERROR - You may not have confirmed your account yet';
	       return $feedback;
      }
    }
  }
}


function user_logout() {
	$_SESSION['FirstName'] = '';
	$_SESSION['LastName'] = '';
	$_SESSION['Email'] = '';
	$_SESSION['username'] = '';
	$_SESSION['id_hash'] = '';
	$_SESSION['Role'] = '';	
	$_SESSION['user_id'] = '';
	
	session_destroy();
}


function user_set_tokens($username_in, $role_in, $FirstName, $LastName, $Email, $user_id) {
  global $supersecret_hash_padding;
  if (!$username_in) {
    $feedback =  'ERROR - No username';
    return false;
  }
  $username = strtolower($username_in);
  $id_hash = md5($username.$supersecret_hash_padding);

//echo "SETTING SESISIONS";

//	session_start(); 
	
	
    $_SESSION['username'] = $username;
	$_SESSION['id_hash'] = $id_hash;
	$_SESSION['Role'] = $role_in;
	$_SESSION['FirstName'] = $FirstName;
	$_SESSION['LastName'] = $LastName;
	$_SESSION['Email'] = $Email;
	$_SESSION['user_id'] = $user_id;
}

?>
