<?php
require_once "core.php";

if(!isset($_REQUEST["noadd"]))
include "addreply.php";

if(!isset($_REQUEST["nolog"]))
include "logmsg.php";

if(!isset($_REQUEST["norep"]))
include "getreply.php";

if(isset($_REQUEST["endlog"]))
include "endlog.php";
?>
