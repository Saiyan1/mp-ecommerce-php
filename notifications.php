<?php

$jsonString = file_get_contents("php://input");
$myFile = "testFile-". rand() .".txt";
file_put_contents($myFile,$jsonString, FILE_APPEND);
//echo '{ "success": true }';

http_response_code(200);