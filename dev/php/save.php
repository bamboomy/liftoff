<?php

$myfile = fopen($_POST["name"], "w+") or die("couldn't open file");

fwrite($myfile, $_POST["content"]) or die("couldn't write to file");

fclose($myfile) or die("couldn't close file");

echo "great succez :)";

?>
<br/><br/>
<a onclick="window.history.back();">back</a><br/><br/>