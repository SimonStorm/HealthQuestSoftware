<?php

/* The below function will list all folders and files within a directory
It is a recursive function that uses a global array.  The global array was the easiest
way for me to work with an array in a recursive function
*This function has no limit on the number of levels down you can search.
*The array structure was one that worked for me.
ARGUMENTS:
$startdir => specify the directory to start from; format: must end in a "/"
$searchSubdirs => True/false; True if you want to search subdirectories
$directoriesonly => True/false; True if you want to only return directories
$maxlevel => "all" or a number; specifes the number of directories down that you want to search
$level => integer; directory level that the function is currently searching
*/
function filelist ($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) 
{
	//list the directory/file names that you want to ignore
	$ignoredDirectory[] = ".";
	$ignoredDirectory[] = "..";
	$ignoredDirectory[] = "_vti_cnf";
	$ignoredDirectory[] = ".DS_Store";
	global $directorylist;    //initialize global array
	if (is_dir($startdir))
	{
		if ($dh = opendir($startdir)) 
		{
			while (($file = readdir($dh)) !== false) 
			{
				if (!(array_search($file,$ignoredDirectory) > -1)) 
				{
					if (filetype($startdir . $file) == "dir") 
					{
						//build your directory array however you choose;
						//add other file details that you want.
						$directorylist[$startdir . $file]['level'] = $level;
						$directorylist[$startdir . $file]['dir'] = 1;
						$directorylist[$startdir . $file]['name'] = $file;
						$directorylist[$startdir . $file]['path'] = $startdir;
						$directorylist[$startdir . $file]['size'] = 0;
						$directorylist[$startdir . $file]['date'] = date("Y-m-d",filemtime($startdir.$file));
						$directorylist[$startdir . $file]['fullpath'] = "";
						$directorylist[$startdir . $file]['sort'] = 0;
						$directorylist[$startdir . $file]['filecount'] = 0;

						if ($searchSubdirs) 
						{
							if ((($maxlevel) == "all") or ($maxlevel > $level)) 
							{
								filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);
							}
						}
					} 
					else 
					{
						if (!$directoriesonly) 
						{
							//if you want to include files; build your file array 
							//however you choose; add other file details that you want.
							$directorylist[$startdir . $file]['level'] = $level;
							$directorylist[$startdir . $file]['dir'] = 0;
							$directorylist[$startdir . $file]['name'] = $file;
							$directorylist[$startdir . $file]['path'] = $startdir;
							$directorylist[$startdir . $file]['size'] = filesize($startdir.$file);
							$directorylist[$startdir . $file]['date'] = date("Y-m-d",filemtime($startdir.$file));
							$directorylist[$startdir . $file]['fullpath'] = "";
							$directorylist[$startdir . $file]['sort'] = 0;
							$directorylist[$startdir . $file]['filecount'] = 0;
						}
					}
				}
			}
		closedir($dh);
		}
	}
	return($directorylist);
}

?>