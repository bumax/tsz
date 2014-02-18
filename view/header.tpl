<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->


<head>

    		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Личный кабинет</title>
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=1210">
</head>
<body>

<div class="global-wrapper">

    <header id="header">
    <nav class="primary links">
		
		<a href="." class="">Главная</a>
		<?php if (isset($_SESSION['user_data'])) { if($_SESSION['user_data']['room'] == 0) { ?>
		<a href="./?route=admin" class="">Админка</a>
        <?php }} ?>
        <a href="./?route=meters" class="">Подача показаний</a>
        <a href="./?route=receipts" class="">Квитанции</a>
		<a href="./?route=feedback" class="">Оставить заявку</a>
		
    </nav>
    <div class="float-right secondary-links">
        <?php if (isset($_SESSION['user_data']['Name'])) { echo $_SESSION['user_data']['Name'];?><a href="./?route=logout" class="profile"> (выход)</a><?php } ?>
    </div>

</header>

    <div class="grid product harrys-blades" id="product_page">
    <div class="col-1-1 hero clear">