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
  $filename = "./receipts/".date("Ym", (time()-60*60*24*30))."/".$data['PA'].".xls"; //��� ����� ��� ������������
  $to = $data['email']; //����
  $from = "noreply@sysoeva12.ru"; //�� ����
  $subject = "=?windows-1251?B?".base64_encode("��������� �� ".date("m.Y", (time()-60*60*24*30)))."?="; //����
  $message = "��� ������ ������������� �������������. ����������, �� ��������� �� ����.\n---\n� ���������� �����������!\n��� �����."; //����� ������
  $boundary = "------------".strtoupper(md5(uniqid(rand()))); //�����������
  /* ��������� */
  $headers = "From: $from\r\nReply-To: $from\r\n";
 //   $headers .= "X-Mailer: sirius27-robot\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
  $body = "--$boundary\r\n";
  /* ������������ ��������� ��������� */
  $body .= "Content-type: text/plain; charset=\"windows-1251\"\r\n";
  $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
  $body .= quoted_printable_encode($message)."\r\n\r\n";
  $body .= "--$boundary\r\n";
  $file = fopen($filename, "rb"); //��������� ����
  $text = fread($file, filesize($filename)); //��������� ���� ����
  fclose($file); //��������� ����
  /* ��������� ��� �����������, �������� ����� ����� � ��������� � ���� ������ */
  $body .= "Content-Type: application/octet-stream; charset=\"windows-1251\"; name=receipt_".date("m-Y", (time()-60*60*24*30)).".xls\r\n"; 
  $body .= "Content-Transfer-Encoding: base64\r\n";
  $body .= "Content-Disposition: attachment; filename=receipt_".date("m-Y", (time()-60*60*24*30)).".xls\r\n\r\n";
  $body .= chunk_split(base64_encode($text))."\r\n";
  $body .= "--".$boundary ."--\r\n";
  mail($to, $subject, $body, $headers); //���������� ������
  
  }
?>
