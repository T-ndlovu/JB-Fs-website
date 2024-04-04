<?php
require_once 'includes/config_session.inc.php';
require_once "includes/dbh.inc.php";
include 'functions.php';

$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
// Include and show the requested page
include $page . '.php';

?>