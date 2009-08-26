<?php
set_time_limit(0);

require_once "core.php";

$basic = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ '?%.0123456789:|!()-><`,\"_/@*[]=^~;#\\+";

$allowchr = str_split($basic);

$results = mysql_query("SELECT * FROM replies");
$num = mysql_numrows($results);
for($i = 0; $i < $num; $i++){
  $val = mysql_result($results, $i, "reply");
  for($x = 0; $x < strlen($val); $x++){
    if(!in_array(substr($val, $x, 1), $allowchr)){
      echo $val."<br>";
      mysql_query("DELETE FROM replies WHERE reply='".mysql_result($results, $i, "reply")."'");
      break;
    }
  }
  if(strlen($val) > 140){
    //echo $val."<br>";
    //mysql_query("DELETE FROM replies WHERE topic='".mysql_result($results, $i, "topic")."'");
  }
}
?>
