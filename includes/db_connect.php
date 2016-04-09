<?php
include_once 'psl-config.php';   // As functions.php is not included
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
//mysqli_report(MYSQLI_REPORT_ALL); uncomment to debug database jankness, note: this will throw exceptions for low priority warnings