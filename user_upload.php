<?php
//details for MySQL go here
$server = "127.0.0.1";
$user = "root";
$password = "password";
$conn;

echo "Script init\n";

//Opens a connection to the MySQL server
$conn = new mysqli($server, $user, $password);
if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
        . $conn->connect_error);
} else echo "Successfully connected to MySQL server.\n";

commandHandler();


echo "Script end\n";

function commandHandler()           //Handles inputs from the command line
{
    global $conn;
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
    } //if --create_table was used
    else if (strcmp($command, "--create_table") == 0) {
        create_table();
    } //if -u was used
    else if (strcmp($command, "-u") == 0) {
        global $user;
        echo "MySQL username is $user\n";
        commandHandler();
    } //if -p was used
    else if (strcmp($command, "-p") == 0) {
        global $password;
        echo "MySQL password is $password\n";
        commandHandler();
    }//if -h was used
    else if (strcmp($command, "-h") == 0) {
        global $server;
        echo "MySQL server is $server";
        commandHandler();
    }//if --exit was used
    else if (strcmp($command, "--exit") == 0) {
        //Closes the connection
        $conn->close();
        echo "Goodbye";
    }//if anything other than a valid command was entered
    else {
        echo "Invalid command. Please enter a valid command.\n";
        commandHandler();
    }
}

function fileCommand()              //--file was input as the command
{

    create_table();
    //users.csv is hardcoded as the filename because the assumptions state that the .csv file will be named as such.
    $file = fopen("users.csv", "r");

    while (!feof($file)) {
        $array = fgetcsv($file);
        $firstName = sanitiseString($array[0]);
        $lastName = sanitiseString($array[1]);
        if (validateEmail($array[2]) == true) {
            $email = trim(strtolower($array[2]));
            $sql = "INSERT INTO userTable (firstname, lastname, email)
            VALUES ($firstName, $lastName, $email)";
        }
    }

    fclose($file);
}

function create_table()             //this function opens a MySQL connection and creates a table
{
    global $conn;

    // Create database
    $query = "CREATE DATABASE IF NOT EXISTS myDB";
    if (mysqli_query($conn, $query)) {
        echo "Success creating database\n";
    } else {
        echo "Failure creating database\n";
    }

    //Checks that the database exists
    //echo mysqli_select_db($conn, myDB);

    //Selects the database
    mysqli_select_db($conn, myDB);

    //Create the table
    $sql = "CREATE TABLE IF NOT EXISTS userTable (
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    UNIQUE (email)
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table userTable created successfully\n";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "\n";
    }

}

function printHelp()                //This function prints out the help menu
{
    echo "--file [csv file name] – this is the name of the CSV to be parsed\n";
    echo "--create_table – this will cause the MySQL users table to be built (and no further action will be taken)\n";
    echo "--dry_run – this will be used with the --file directive in the instance that we want to run the script but not insert into the DB. All other functions will be executed, but the database won't be altered.\n";
    echo "-u – MySQL username\n";
    echo "-p – MySQL password\n";
    echo "-h – MySQL host\n";
    echo "--exit - this will end the script";
    commandHandler();
}


function sanitiseString($string)      //This function sanitises strings by removing special characters for placement into a table
{
    $string = preg_replace("/[^A-Za-z']/", "", $string);
    $string = trim(ucfirst(strtolower($string)));
    return $string;
}

function validateEmail($string)        //Sanitises and validates email addresses
{

    //Checks for the presence of invalid characters, displays an error message and then returns false
    if (preg_match("/[^A-Za-z0-9@.]/", $string)) {
        echo($string . " is an invalid email address.\n");
        return false;
    }
    //Checks for correct email formatting and returns false if invalid
    if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
        echo($string . " is an invalid email address.\n");
        return false;
    }
    //Return true is email format is accepted
    return true;
}

/**
 * Created by PhpStorm.
 * User: James
 * Date: 7/08/17
 * Time: 4:15 PM
 */