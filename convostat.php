<?php
require_once "core.php";

$results = mysql_query("SELECT DISTINCT id FROM conversations");
$num = mysql_numrows($results);
//echo "Number of Conversations: $num<hr>";
for($ix = 0; $ix < $num; $ix++){
  $val = mysql_result($results, $ix, "id");
  //echo 'ID: <a href="conversation?id='.$val.'">'.$val."</a>";
  /*
  $subres = mysql_query("SELECT * FROM conversations WHERE id='".$val."'");
  $subnum = mysql_numrows($subres);
  echo " Length: $subnum";
  */
  echo "wget http://192.168.1.149/chatbot/endlog.php?id=$val\n";
  //echo "<br>";
}
?>
