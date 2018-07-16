<?php

$mysql_host = "guerra.year4000.net";
$mysql_database = "year4000";
$mysql_user = "year4000";
$mysql_password = "Y3@r4000";

$link = mysql_connect($mysql_host,$mysql_user,$mysql_password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

?>
