<?php
header('Content-Type: text/html; charset=utf-8');
include('./controller/controller.php');
$control = new Controller;
		session_start();
		if($_SESSION['user_data']['sign'] == true)
$control->{(isset($_GET['route']) ? (($_SESSION['user_data']['room'] !=0 AND $_GET['route'] == 'admin') ? $_GET['route'] : $_GET['route']) : 'main')}();
else
$control->index();
?>