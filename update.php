<?php

$id = $_POST["id"];

$item_name = $_POST["item_name"];
$season = $_POST["season"];
$category = $_POST["category"];
$brand = $_POST["brand"];
$purchase_date = $_POST["purchase_date"];
$comment = $_POST["comment"];
$image_name = $_POST["image_name"] ?? "";

$c = ",";

$new_line = date("Y-m-d H:i:s");
$new_line .= $c.$item_name;
$new_line .= $c.$season;
$new_line .= $c.$category;
$new_line .= $c.$brand;
$new_line .= $c.$purchase_date;
$new_line .= $c.$comment;
$new_line .= $c.$image_name;
$new_line .= "\n";

$lines = file("data/data.txt");

$str = "";

foreach ($lines as $key => $line) {

    if ($key == $id) {

        $str .= $new_line;

    } else {

        $str .= $line;

    }

}

$file = fopen("data/data.txt", "w");

fwrite($file, $str);

fclose($file);

header("Location: read.php");
exit();

?>