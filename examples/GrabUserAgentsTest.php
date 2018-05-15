<?php
include(dirname(__FILE__,2)."/src/autoload.php");
use Mime\Helper;

$ua = Helper::GrabUserAgents(true);
var_dump( array_slice($ua,0,1));
