<?php
function showHelp() {
	/*
		The PHP script should include these command line options (directives):
			• --file [csv file name] – this is the name of the CSV to be parsed
			• --create_table – this will cause the MySQL users table to be built (and no further
			• action will be taken)
			• --dry_run – this will be used with the --file directive in case we want to run the script but not insert
			into the DB. All other functions will be executed, but the database won't be altered
			• -u – MySQL username
			• -p – MySQL password
			• -h – MySQL host
			• --help – which will output the above list of directives with details.
	*/
	$help = "";
	$help .= "Usage: php user_upload.php [options] \n\n";
	$help .= "--file [csv file name] – this is the name of the CSV to be parsed \n";
	$help .= "---create_table – this will cause the MySQL users table to be built (and no further action will be taken) \n";
	$help .= "--dry_run – this will be used with the --file directive in case we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered (I guess this is for you guys to test, so I will just print it out) \n";
	$help .= "-u – MySQL username \n";
	$help .= "-p – MySQL password \n";
	$help .= "-h – MySQL host \n";
	$help .= "--help – which will output the above list of directives with details.\n\n";

	echo $help;
}

?>