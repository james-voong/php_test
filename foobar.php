<?php
echo "script start\n";

for ($i = 1; $i <= 100; $i++) {

    if ($i % 3 == 0 && $i % 5 == 0) {                   //checks if number is divisible by 3 and 5
        echo "foobar\n";                                //print foobar if it is
    } else if ($i % 3 == 0) {                           //otherwise check if number is divisible by 3
        echo "foo\n";                                   //print foo if it is
    } else if ($i % 5 == 0) {                           //otherwise check if number is divisible by 5
        echo "bar\n";                                   //print bar if it is
    } else echo "$i\n";                                 //otherwise echo the number

}

echo "script end\n";
/**
 * Created by PhpStorm.
 * User: James
 * Date: 7/08/17
 * Time: 4:38 PM
 */