<?php

$number = @htmlspecialchars($_GET["n"]);


//checks if the GET content is a number

if (is_numeric($number)) {
    $sum_total = $number * $number;
    print ($sum_total);

//If the GET request does not contain a number say so    
} else {
    echo var_export($number, true) . " is NOT a number", PHP_EOL;
}


?>




