PS Upload Promo
=========================================================================

Use this ID to receive a $5 discount on any PerlServices Script: PS181074

PS Upload Mini FAQ
=========================================================================

Q. Does PS Upload send form data to me?
A. No, it only uploads files and notifies you of the file upload. If you 
   want other form data sent to you also, you need to look at either 
   FormMailer with Attachments, Dropbox, or Allform Pro.

Q. What is the $dir variable?
A. That is path to the folder you want files uploaded to. It must be the
   server's path, not a website address. If you're not sure what your 
   path is, leave it as is. PS Upload will tell you your path if you 
   enter it incorrectly.

Q. Why am I receiving a server 500 error?
A. Ninety eight percent of server 500 errors are caused by the following 
   two installation errors:
   
   1) You did not upload the cgi script in ASCII mode. You think you did,
      but are you absolutely certain?
   2) You did not CHMOD the script or the directory the script resides in
      to 755. If it's not 755, it's not alive.  

Q. Can you help me install the script?
A. Yes, you can purchase installation ($30) form this secure order form:
   https://www.perlscriptsjavascripts.com/psinstallation.html

Q. Why should I pay you to work for me?
A. The answer lies within the question. PS Upload has been downloaded 
   over 75,000 times since 1999. Think about it.


PS Upload Quick Installation
=========================================================================
Step 1
Open and set the correct path to Perl on your web server in 
upload.cgi file (i.e. #!/usr/bin/perl). This is the 
first line of code in upload.cgi. Most users will be 
able to ignore this step. Windows servers do not require it.

Edit the variables found on line 30 to 85. These are 
self-explanatory and contain instructions adjacent to each variable. 

Step 2
Upload the upload.cgi file to your cgi-bin or any cgi enabled 
directory and CHMOD it to 755. If you do NOT upload in ASCII
mode, expect a server 500 error.

Step 3
Open upload.html and make sure the form tag's action attribute 
points to the upload.cgi script you uploaded in Step 2.

Step 4
Upload the upload.html file to any publicly accessible directory.
Upload it in ASCII mode also.

Step 5
Load your Browser, point it to the upload.html file and test 
the script by submitting the form.

Please see User Guide
http://www.perlservices.net/en/programs/psupload/users_guide.shtml

or 

FAQ
http://www.perlservices.net/perlfaqs/psfreeupload_1.html

for further information.				
