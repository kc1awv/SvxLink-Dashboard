<?php

include "config/config.php";
include "include/tools.php";
include "include/functions.php";

$configs = getSvxConfig();
$txStatus = getSvxTXLines();

if (in_array("ON", $txStatus)) {
	echo "<tr><td class=\"table-danger\">ON</td></tr>";
} else {
	echo "<tr><td class=\"table-success\">OFF</td></tr>";
}

?>
