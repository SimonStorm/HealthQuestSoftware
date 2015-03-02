<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Health Quest Software</title>

<script language="javascript">
<!--
function statusMsg(txt) {
if (txt == '') txt = 'Health Quest Software';
window.status = txt;
return true;
}
function logaction(file) {
f = document.listForm;
alert(file);
f.downfile.value = file;
f.act.value = 'downfile';
f.submit();
}
//-->
</script>
</head>

<body>
<form action=../index.php method=post name=listForm>
<input name=act type=hidden value=''>
<input name=downfile type=hidden value=''>
<a target="_new" href=register.php onMouseOver='return statusMsg("Display file");' onMouseOut='return statusMsg("");' onClick='return logaction("SoftwareUpdate.zip");'>Software Documentation.mdb</a>
</form>
</body>
</html>