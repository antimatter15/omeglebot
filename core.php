<?php
$username = "root";
$password = "hello4";
$database = "botchat";


$omeglebot = file_get_contents("omeglebot3.js");
define("VERSION", intval(substr($omeglebot,9,3)));

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

function jsonpify($buffer){
  $prepend = "";
  if(intval($_REQUEST['version']) < VERSION){
    global $omeglebot;
    $prepend = "/*Real-Time OmegleBot Upgrade System v1.6 (New Version ".VERSION.")*/\n\n";
    $prepend .= $omeglebot."\n\n;;window.codeversion=".VERSION.";;\n\n";
  }
  return $prepend.$_REQUEST["callback"]."({text:'".addslashes(str_replace("\n","",str_replace("\r","",$buffer)))."'});";
  
}

if(isset($_REQUEST["callback"])){
  ob_start("jsonpify");
}

function filter($text){

}

?>
