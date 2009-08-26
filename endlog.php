<?php
require_once "core.php";

$id = intval($_REQUEST['id']);

if($id > 0){

$res = mysql_query("SELECT * FROM conversations WHERE id=".$id);
$num = mysql_numrows($res);

$html = "Length: $num<hr>";
$start = "";
$text = "";
$notime = "";
for($i = 0; $i < $num; $i++){
  $user = mysql_result($res, $i, "user");
  $time = mysql_result($res, $i, "time");
  if($i == 0){
    $start = $time;
  }
  $message = stripslashes(mysql_result($res, $i, "message"));
  $html.= "<font color='".($user=="Bot"?"Blue":"Red")."'>$user ($time):</font> $message<br>";
  $text.="$user ($time): $message\n";
  $notime.="$user: $message\n";
}

file_put_contents("logs/html/$start ID$id ($num lines).html",$html);
file_put_contents("logs/text/$start ID$id ($num lines).txt",$text);


$ch = curl_init("http://botbash.antimatter15.com/?adminadd");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,array("quote"=>$notime));
$result = curl_exec ($ch);
curl_close ($ch);


}
?>

