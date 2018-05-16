<?php
include(dirname(__FILE__,2)."/src/autoload.php");
use Mime\UserAgent\UserAgent;

$ua = new UserAgent(true);
var_dump($ua->random());
