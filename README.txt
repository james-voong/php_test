Assumptions
---------------------------------
Runs through command line
Running PHP script – it will be executed on an Ubuntu 16.04 instance
PHP version is: 7.0.x
MySQL database server is already installed and is version 5.6 (higher versions are fine) – MySQL user details are be configurable.
PHP script will be called – user_upload.php
CSV file will be called users.csv

Script Command Line Directives
---------------------------------
The PHP script includes these command line options (directives):
--file [csv file name] – this is the name of the CSV to be parsed
--create_table – this will cause the MySQL users table to be built (and no further action will be taken)
--dry_run – this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.
-u – Prints MySQL username
-p – Prints MySQL password
-h – Prints MySQL host
--help – which will output the above list of directives with details.
--exit - ends the script

String sanitation
---------------------------------
String sanitation is only rudimentary, known issues:
  All hyphens and spaces are automatically removed.
  Dual names are not accounted for. e.g. Anna-Jane will return as Annajane
  Comma's are allowed, including double comma's
  Accented characters are not allowed even though some names may have them
  
