<?php
session_start();
if($_SESSION['user_data']['sign'] == true){
if(isset($_GET['f'])){
$file = unserialize(base64_decode($_GET['f']));

	$f=fopen('./receipts/'.$file[1].'/'.$file[0].'.xls',"rb");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Квитанция за ".substr($file[1], 4, 2).".".substr($file[1], 0, 4).".xls");
header("Content-Length: " . filesize('./receipts/'.$file['1'].'/'.$_SESSION['user_data']['PA'].'.xls'));
	echo fread($f,filesize('./receipts/'.$file['1'].'/'.$_SESSION['user_data']['PA'].'.xls'));
	fclose($f);
	}
elseif(isset($_GET['v'])){	
			include('./model/model.php');
		$model = new Model;
		
		$data = $model->getEcho($_GET['v']);
	$echo = "Квартира;Тип ПУ;Расположение ПУ;Показание;Дата снятия показания\r\n";
	foreach($data as $col){
	$echo .= $col['room'].";".$col['type'].";".$col['Comment'].";".$col['Data'].";".$col['Date']."\r\n";
	}
	$echo = iconv('utf-8', 'windows-1251', $echo);
	header("Content-type: application/CSV");
	header("Content-Disposition: attachment; filename=Показания за ".$_GET['v'].".csv");
	header("Content-Length: " . strlen($echo));
	echo $echo;
	}
	
}
else{
}
?>