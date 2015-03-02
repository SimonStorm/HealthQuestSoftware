#!/usr/bin/perl -w

#
# Perl file upload handler script.
# you need to have the CGI module installed.
#
# Copyright Thin File (Pvt) Ltd. 2005
# http://upload.thinfile.com

use CGI;

sub bye_bye {
	$mes = shift;
	print "<br>$mes<br>\n";

	exit;
}


#
# save_path defines the folder where uploaded files will be saved.
# The folder that you choose should be writable by the webserver.
#

my $save_path="/dev/shm/uploaded/";


print "Content-type: text/html\n\n ";
my $cg = new CGI();


print <<__TABLE__;
<html>
<body  bgcolor="FFFFFF">

<table border="1" cellpadding="5" width="100%" align="center" bgcolor="#F0F0FF">
<tr><td colspan="2" bgcolor="#6699CC" align="center"><font color="#FFFFFF" size="+1" align="center">Files Uploaded</font></td></tr>
<tr  bgcolor="#FCFCFF"><td style="font-size: 110%;"><nobr>File Name</nobr></td>
	<td style="font-size: 110%"  align="right"><nobr>File size</nobr></td></tr>
__TABLE__

my $size = $cg->param;
for($i=0 ; $i < $size ; $i++)
{
	$file_upload 	= $cg->param("userfile[$i]");

	if($file_upload) {
		my $fh = $cg->upload("userfile[$i]");
		$fsize =(-s $fh);
		if($i % 2)
		{
			print '<tr bgcolor="#FAFAFA">';
		}
		else
		{
			print '<tr>';
		}
		print "<td>$fh </td>\n";
		print "<td>$fsize</td></tr>";

		my @name = split('/',$fh);
		my $filename = $name[$#name];

		if(defined($save_path))
		{
			open (OUTFILE,">>$save_path/$filename");
			while(<$fh>) {
				print OUTFILE $_;
			}
			close(OUTFILE);
		}
		else
		{
			# not being saved.
		}
	}
}


print <<__TABLE__;
</table>

<p style="text-align:center; font-size: 80%"> Perl Upload handler script provided by
 <a href="http://www.thinfile.com/?tiu">Thin File (Pvt) Ltd.</a></p>
 

__TABLE__


