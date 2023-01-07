<?php

// Apps
$_title             = "My Invoice ";
$_from_name         = "Discovery Design";
$_from_address_1    = "41 St Vincent Place";
$_from_address_2    = "Glasgow G1 2ER";
$_from_country      = "Scotland";

// Database
$_servername = "localhost";
$_username   = "root";
$_password   = "samarinda123";
$_database     = "test_esb";

// URL
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
$part = rtrim($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_NAME']));
$base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $part;
