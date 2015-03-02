<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Thin Upload Enterprise Edition</title>
</head>
	<body>
	 <table border="0" valign="middle" align="center" cellpadding="15">
	 <tr><td colspan='2'><h2 align="center">Thin Upload Pro</h2></td></tr>
	  <tr>
   	   <td width="340" valign="top">
		  <p>Thank you for downloading Thin Upload Pro</p>
		
		  <p>Thin Upload Pro is an advanced file upload solution. It uses compression to increase the transfer speed. Images can be resized at the client side and thumbnails generated. Very large files (hundreds of Giga bytes) can be uploaded over HTTP connections.
		   </p>

		   <p>The applet supports both the PUT and POST methods of the Hyper Text Transport Protocol (HTTP). FTP support is also available. Entire folder trees can be uploaded with both HTTP and FTP.
		   </p>

		   <p>These are just some of the features available in Thin Upload Pro please refer to the <a href="http://upload.thinfile.com/docs/?pro">documentation</a> for more information and usage.
		   </p>
	   </td>
	   <td>
	    <div  style='border: 1px solid #006699; padding:2px'>
	   

<?	
		$useApplet=0;
		
		$user_agent =$_SERVER['HTTP_USER_AGENT'];

	   
		if(stristr($user_agent,"konqueror") || stristr($user_agent,"macintosh") || stristr($user_agent,"opera"))
		{ 		
			$useApplet=1;
			echo '<applet name="Thin Upload Enterprise"
					archive="ThinProDemo.jar"
					code="com.thinfile.upload.ThinProDemo"
					width="300" MAYSCRIPT="yes"
					height="312">';
			
		}
		else
		{			   
			if(strstr($user_agent,"MSIE")) { 
                echo '<script language="javascript" src="embed.js" type="text/javascript"></script>';
                echo '<script>IELoader()</script>';
			} else {
				echo '<object type="application/x-java-applet;version=1.4.1"
					width= "300" height= "309"  id="rup" name="rup">';
                echo '  <param name="archive" value="ThinProDemo.jar">
                    <param name="code" value="com.thinfile.upload.ThinProDemo">
                    <param name="MAYSCRIPT" value="yes">
                    <param name="name" value="Thin Upload Demo">';
			} 
		}
		if(isset($_SERVER['PHP_AUTH_USER']))
		{
			printf('<param name="chap" value="%s">',
				base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']));
		}
		
		if($useApplet == 1)
		{
			echo '</applet>';
		}
		else
		{
			echo '</object>';
		}
?>
		</div>
   	  </td>
   </tr>

   
  </table>
  <p>&nbsp;</p>
  <p align="center">A product of <a href="http://upload.thinfile.com/?pro">Thin File</a></p>
 </body>
</html>

