   <div style="padding:10px 10px;width: 900px; height: 100%; margin: 0 auto; position: relative;" class="clear">
 		<h2><?php echo $Name; ?></h2>  
   <table style="border-spacing: 40px 10px;">

		<tr><td>Номер квартиры: </td><td><b><?php echo $room; ?></b></td></tr>
		<tr><td>Количество комнат: </td><td><?php echo $NR; ?></td></tr>
		<tr><td>Общая площадь: </td><td><?php echo $SQ; ?> м<sup>2</sup></td></tr>
		<tr><td>Номер лицевого счета: </td><td><?php echo $PA; ?></td></tr>
		<form method="post">
		<tr><td>E-mail: </td><td><input value="<?php echo $email; ?>" name="email"><?php echo (isset($this->warning['email']) ? $this->warning['email'] : '' ); ?></td></tr>
		<tr><td>Телефон: </td><td><input value="<?php echo $phone; ?>" name="phone"></td></tr>
		<tr><td colspan=2><center><input name="submit" type="submit" value="Сохранить"/></center></td></tr>
		</form>
		
    </table>
	</div>
	
				<div style="background: #FEFEFE;padding:10px 10px;border:1px dashed #000000;width: 500px; height: 100%; margin: 0 auto; position: relative;" class="clear">
			<p>При обнаружении неточностей в полях Личного кабинета (ФИО, площадь, количество счетчиков), обращайтесь по телефону <br><b>+7-914-407-5444</b>, либо на электронный адрес <b>info@sysoeva12.ru</b> для корректировки данных.</p></div>
	
	
	
	
	
	
	
	