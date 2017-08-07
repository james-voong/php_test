<?php

echo "Script init\n";

commandHandler();


//$print = file_exists($command);
//echo $print;

$handle = fopen($_FILES["users.csv"]["tmp_name"], 'r');
echo "$handle";

//$file = fopen("$command", "r");

//while (!feof($file)) {
//    if (feof == true) {
//        echo "Invalid file name.\n";
//        break;
//    }
//    print_r(fgetcsv($file));
//}
//fclose($file);

echo "Script end\n";

function commandHandler()           //Handles inputs from the command line
{
    $command = readline("Enter command (enter --help for full commands list): ");       //Asks for the filename to be opened and saves it
    if (strcmp($command, "--help") == 0) {
        printHelp();
    } else {
        echo "Invalid command. Please enter a valid command.\n";
        commandHandler();
    }
}

function printHelp()                //This function prints out the help menu
{
    echo "--file [csv file name] – this is the name of the CSV to be parsed\n"
    echo "--create_table – this will cause the MySQL users table to be built (and no further action will be taken)\n";
    echo "--dry_run – this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.\n";
    echo "-u – MySQL username\n";
    echo "-p – MySQL password\n";
    echo "-h – MySQL host\n";

    commandHandler();

}

/**
 * Created by PhpStorm.
 * User: James
 * Date: 7/08/17
 * Time: 4:15 PM
 */