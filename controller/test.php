<?php

include_once("../config.php");
 global $connection;

 ini_set('memory_limit', '256M');

 $query = $connection->prepare('SELECT * FROM basedatafeed b WHERE project_id = 66');
 // $query->execute();

 // $rows = $query->fetchAll();

 // var_dump($rows);

 // print_r($rows);

$newDataFeed = "sdfsd";
$removedData = "sdfsxxxd";

$ndf = file_put_contents("new_datafeedversion4.txt", $newDataFeed);
$rd  = file_put_contents("removedData.txt", $removedData);

$newDataFeed = 'new_datafeedversion4.txt';




?>