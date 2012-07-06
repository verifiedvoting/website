<?php

$server = 'localhost';
$user = 'verified';
$pass = 'IW6pY8RenuRkvoBuaG3Hapjix';

$connection = mysql_connect($server, $user, $pass) or die(mysql_error());

mysql_select_db("verified_test") or die(mysql_error());