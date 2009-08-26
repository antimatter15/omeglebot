<?php
require_once "core.php";

set_time_limit(0);

$results = mysql_query("SELECT DISTINCT topic FROM replies");
$num = mysql_numrows($results);
echo "{";
for($i = 0; $i < $num; $i++){
  $val = mysql_result($results, $i, "topic");
  echo '"'.$val.'":[';
  $subres = mysql_query("SELECT * FROM replies WHERE topic='".$val."'");
  $subnum = mysql_numrows($subres);
  for($q = 0; $q < $subnum; $q++){
    $subval = mysql_result($subres, $q, "reply");
    echo '"'.str_replace("\r","",str_replace("\n","\\n",$subval)).'"';
    if($q+1 < $subnum){
      echo ",";
    }
  }
  echo "]";
  if($i+1 < $num){
    echo ",";
  }
}
echo "}";
?>
