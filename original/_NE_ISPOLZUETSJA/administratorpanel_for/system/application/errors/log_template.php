<?php
/*
 |-----------------------------------------------------------
 | Log Template
 |-----------------------------------------------------------
 |
 | This is the template used for logging when it is a PHP
 | error.
 |
 | NOTE: This will not be used on a user-called log 
 */

$log  = "\n\n";
$log .= " |-----------------------------------------------------------\n";
$log .= " | PHP ERROR\n";
$log .= " |-----------------------------------------------------------\n";
$log .= " |\n";
$log .= " | Error: $message\n";
$log .= " | Filepath: $filepath\n";
$log .= " | Line: $line\n ";
?>