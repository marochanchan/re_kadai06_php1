<?php

$id = $_GET["id"];

$lines = file("data/data.txt");

$str = "";

foreach ($lines as $key => $line) {

    if ($key != $id) {

        $str .= $line;

    }

}

$file = fopen("data/data.txt","w");

fwrite($file, $str);

fclose($file);

header("Location: read.php");
exit();

?>