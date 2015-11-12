<?php

require_once "inc/config.inc.php";
session_start();

$g = Gestionnaire::getInstance();
echo $g->inscription($_POST);
