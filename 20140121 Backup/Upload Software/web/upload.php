<?
/**
 * PHP file upload handler.
 * Copyright Thin File (Pvt) Ltd. 2005.
 * http://upload.thinfile.com
 */
?>
<html>
<head><title>Thin File Upload</title></head>


<body  bgcolor="FFFFFF">
<table border="0" cellpadding="5" width="100%" align="center" bgcolor="#F0F0FF">
<tr><td colspan="2" bgcolor="#6699CC" align="center"><font color="#FFFFFF" size="+1" align="center">Files Uploaded</font></td></tr>
<tr  bgcolor="#FCFCFF"><td><nobr>File Name</nobr></td>
	<td align="right"><nobr>File size</nobr></td></tr>
<?

/*
 * SET THE SAVE PATH by editing the line below. Make sure that the path
 * name ends with the correct file system path separator ('/' in linux and
 * '\\' in windows servers (eg "c:\\temp\\uploads\\" )
 */

$save_path="";    


$file = $_FILES['userfile'];
$k = count($file['name']);


for($i=0 ; $i < $k ; $i++)
{
	if($i %2)
	{
		echo '<tr bgcolor="#FAFAFA"> ';
	}
	else
	{	
		echo '<tr>';
	}
	
	echo '<td align="left">' . urldecode($file['name'][$i]) ."</td>\n";
	echo '<td align="right">' . $file['size'][$i] ."</td></tr>\n";

	if(isset($save_path) && $save_path!="")
	{
		$name = split('/',urldecode($file['name'][$i]));
		
		move_uploaded_file($file['tmp_name'][$i], $save_path . $name[count($name)-1]);
	}
	
}

if(! isset($save_path) || $save_path =="")
{
	echo '<tr style="color: #0066cc"  bgcolor="#FCFCFC" ><td colspan=2 align="left">Files have been uploaded but not saved because the destination folder has not been set. Please change the $save_path in upload.php</td></tr>';
}

if(isset($userfile_parent))
{
	echo "<tr bgcolor='#FCFCFC' style='color: #0066cc'><td colspan=2>Top level folder hint : $userfile_parent</td></tr>";
}

?>
</table>
<p>&nbsp;</p>

<p style="text-align:center;">PHP Upload handler provided by
 <a href="http://www.thinfile.com/?tiu">Thin File (Pvt) Ltd.</a></p>
 <p>&nbsp;</p>

</body>
</html>
