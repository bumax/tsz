<?php
if($_GET['key']=="85F2EBD278D13443C2753712FD611422"){
		include('./model/model.php');
		$model = new Model;
		for($i=1;$i<261;$i++){
		$data = $model->getRoom($i);
		if(preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $data['email'])){ 

		send_msg($data);
		usleep(rand(1,2)*500000);

    }	
    }
}
	function send_msg($data){
  $filename = "./receipts/".date("Ym", (time()-60*60*24*30))."/".$data['PA'].".xls"; //Имя файла для прикрепления
  $to = $data['email']; //Кому
  $from = "noreply@sysoeva12.ru"; //От кого
  $subject = "=?windows-1251?B?".base64_encode("Квитанция за ".date("m.Y", (time()-60*60*24*30)))."?="; //Тема
  $message = "Это письмо сгенерировано автоматически. Пожалуйста, не отвечайте на него.\n---\nС наилучшими пожеланиями!\nВаш робот."; //Текст письма
  $boundary = "------------".strtoupper(md5(uniqid(rand()))); //Разделитель
  /* Заголовки */
  $headers = "From: $from\r\nReply-To: $from\r\n";
 //   $headers .= "X-Mailer: sirius27-robot\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
  $body = "--$boundary\r\n";
  /* Присоединяем текстовое сообщение */
  $body .= "Content-type: text/plain; charset=\"windows-1251\"\r\n";
  $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
  $body .= quoted_printable_encode($message)."\r\n\r\n";
  $body .= "--$boundary\r\n";
  $file = fopen($filename, "rb"); //Открываем файл
  $text = fread($file, filesize($filename)); //Считываем весь файл
  fclose($file); //Закрываем файл
  /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
  $body .= "Content-Type: application/octet-stream; charset=\"windows-1251\"; name=receipt_".date("m-Y", (time()-60*60*24*30)).".xls\r\n"; 
  $body .= "Content-Transfer-Encoding: base64\r\n";
  $body .= "Content-Disposition: attachment; filename=receipt_".date("m-Y", (time()-60*60*24*30)).".xls\r\n\r\n";
  $body .= chunk_split(base64_encode($text))."\r\n";
  $body .= "--".$boundary ."--\r\n";
  mail($to, $subject, $body, $headers); //Отправляем письмо
  
  }
?>
