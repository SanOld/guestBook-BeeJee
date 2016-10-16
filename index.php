<?php
session_start();
$_SESSION["test"] = "Сессия - тест";
require(__DIR__ . '/cfg.php');
require( BASE_PATH . 'db_config.php');
require( CLASS_PATH . 'db.php' );
require( CLASS_PATH . 'utils.php' );
require(__DIR__ . '/route.php');
?>