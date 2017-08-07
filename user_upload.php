<?php

echo "Script init\n";

commandHandler();

//$handle = fopen($_FILES["users.csv"]["tmp_name"], 'r');
//echo "$handle";

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
    //Reads the input from the command line
    $command = readline("Enter command (enter --help for full commands list): ");
    $command = trim($command);

    /* These are to delimit the command if --file [csv file name] was used.
    Used in this method to verify the given file name exists
    */
    $delimitedFileCommand = explode(" ", $command);
    $delimitedFileCommand[0] = trim($delimitedFileCommand[0]);
    $delimitedFileCommand[1] = trim($delimitedFileCommand[1]);


    if (strcmp($command, "--help") == 0) {
        printHelp();
    } //users.csv is hardcoded as the filename because the assumptions state the csv file will be named as such
    else if (strcmp($delimitedFileCommand[0], "--file") == 0) {
        //--file was used. Checks if the given file exists and handles it.
        if ((strcmp($delimitedFileCommand[1], "users.csv") == 0) && (file_exists(realpath($delimitedFileCommand[1])) == 1)) {
            fileCommand();
        } else
            if (strcmp($delimitedFileCommand[1], "users.csv") && file_exists(realpath("users.csv") == false)) {
                echo "users.csv does not exist.\n";
                commandHandler();
            } else {
                echo "Invalid filename entered. Please try again\n";
                commandHandler();
            }
    } else {
        echo "Invalid command. Please enter a valid command.\n";
        commandHandler();
    }
}

function fileCommand()              //--file was input as the command
{
    echo "success";
}

function printHelp()                //This function prints out the help menu
{
    echo "--file [csv file name] – this is the name of the CSV to be parsed\n";
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