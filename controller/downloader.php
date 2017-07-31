<?php


$filename = $_GET['filename'];

$filename = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($filename)); 
$filename = html_entity_decode($filename,null,'UTF-8');


if (file_exists($filename)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    exit;
}



?>





