<?php
require_once "core.php";

$message = mysql_real_escape_string($_REQUEST['new']);
$user = mysql_real_escape_string($_REQUEST['user']);
$chatid = intval($_REQUEST['id']);

mysql_query("INSERT INTO conversations (id, user, message) VALUES ($chatid, '$user', '$message')");
?>
