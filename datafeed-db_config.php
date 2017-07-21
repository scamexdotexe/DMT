<?php

$host_datafeed_db = 'localhost';
$db_datafeed   = 'datafeed_db';
$user_datafeed_db = 'root';
$pass_dataffed_db = '';
$charset_datafeed_db = 'utf8';

$dsn_datafeed_db = "mysql:host=$host_datafeed_db;dbname=$db_datafeed;charset=$charset_datafeed_db";
$opt_datafeed_db = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$con_datafeed_db = new PDO($dsn_datafeed_db, $user_datafeed_db, $pass_dataffed_db, $opt_datafeed_db);

?>