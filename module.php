<?php

$mod = '';
if (isset($_GET['mod'])) {
    $mod = $_GET['mod'];
}

$act = '';
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}


if ($mod == '') {
    $_module = 'home';
} elseif ($mod == 'invoice') {
    $_module = 'invoice';
} elseif ($mod == 'api') {
    $_module = 'api';
}

require('template.php');
