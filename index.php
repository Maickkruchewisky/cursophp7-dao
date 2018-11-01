<?php

require_once("config.php");

$maic = new Usuario();

$maic->loadById(21);

echo $maic;

?>