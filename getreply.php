<?php
require_once "core.php";

$topic = mysql_real_escape_string($_REQUEST['new']);
$type = $_REQUEST['type'];

$num = 0;

if($topic){
  $results = mysql_query("SELECT * FROM replies WHERE topic='$topic'");
  $num = mysql_numrows($results);
}

if($num > 0){
  $reply = mysql_result($results, rand(0, $num - 1), "reply");
}
if($num == 0 || $reply == $topic){
  $results = mysql_query("SELECT * FROM replies");
  $num = mysql_numrows($results);
  if($num == 0){
    $reply = "";
  }elseif($type == "topic"){ //if last was you
    $reply = mysql_result($results, rand(0, $num - 1), "topic");
  }else{ //schwappy if not worky as well as it could
    $reply = mysql_result($results, rand(0, $num - 1), "reply");
  }
}

echo stripslashes($reply);

?>
