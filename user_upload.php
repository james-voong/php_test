<?php

echo "Script init\n";

$command = readline("Enter name of CSV file to be opened: ");
$file = fopen("$command", "r");
while (!feof($file)) {
    print_r(fgetcsv($file));
}
fclose($file);

echo "Script end\n";

/**
 * Created by PhpStorm.
 * User: James
 * Date: 7/08/17
 * Time: 4:15 PM
 */