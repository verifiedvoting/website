<?php

$server = 'localhost';
$user = 'verified';
$pass = 'IW6pY8RenuRkvoBuaG3Hapjix';
$dbname = 'verified_test';

$GLOBALS['server'] = $server;
$GLOBALS['user'] = $user;
$GLOBALS['password'] = $pass;
$GLOBALS['dbname'] = $dbname;

$connection = mysql_connect($server, $user, $pass) or die(mysql_error());

mysql_select_db($dbname) or die(mysql_error());