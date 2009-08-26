<?php
require_once "core.php";

$topic = mysql_real_escape_string($_REQUEST['last']);
$reply = mysql_real_escape_string($_REQUEST['new']);

if($reply){
  $num = mysql_numrows(mysql_query("SELECT * FROM replies WHERE topic='$topic' AND reply='$reply'"));
  if($num == 0){
    mysql_query("INSERT INTO replies (topic, reply) VALUES ('$topic', '$reply')");
  }
}
?>
