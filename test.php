<?php
//echo file_get_contents("omeglebot3.js");
function filter($text){
  $text = ' '.strtolower($text).' ';
  $words = explode(",",'wanna,are,a,my,you,they');
  $remove = array(' wanna '," are "," a "," my "," you ","they",
                "?","!","."," ","|",":",")","(");
  foreach($remove as $item){
    $text = str_replace($item, "", $text);
  }
  return $text;
}

echo filter("are you a real person?");
?>
