<?php
require_once "core.php";

$res = mysql_query("SELECT * FROM conversations WHERE id=".intval($_REQUEST['id']));
$num = mysql_numrows($res);

echo " Length: $num<hr>";

for($i = 0; $i < $num; $i++){
  $user = mysql_result($res, $i, "user");
  $time = mysql_result($res, $i, "time");
  $message = stripslashes(mysql_result($res, $i, "message"));
  echo "<font color='".($user=="Bot"?"Blue":"Red")."'>$user ($time):</font> $message<br>";
}

?>
