        <div align="center" style="width: 100%; height: 100%; margin: 0 auto; position: relative; padding: 40px 0;" class="clear">
		<?PHP if(isset($_POST['submit'])){ ?>
		<font color=green><b>Данные обновлены!</b></font>	
		<?PHP } ?>
		
		<form method="post">
		<table  width="800"><tr bgcolor="#D2D2D2"><td width="20%"><b>Тип</b></td><td width="30%"><b>Место установки</b></td><td width="20%"><b>Предыдущее показание</b></td><td width="20%"><b>Текущее показание</b></td><td width="10%"><b>Разница</b></td></tr>
		
		
		
		<?php foreach($meters as $key=>$meter){ $last_update = date_parse($meter['meter_data'][(count($meter['meter_data'])-1)]['Date']." 00:00:00.0"); ?>
				

		<tr <?php if($key & 1) { ?>bgcolor="#EDEDED"<?php } ?>><td><?php echo $meter['type'].' (№'.$meter['Number'].')'; ?></td><td><?php echo $meter['Comment']; ?></td><td><?php echo (isset($meter['meter_data'][0]) ? ((($last_update['year'] == date("Y")) AND ($last_update['month'] == date("m"))) ? (isset($meter['meter_data'][(count($meter['meter_data'])-2)]['Data']) ? $meter['meter_data'][(count($meter['meter_data'])-2)]['Data'] : "Нет данных" ) : $meter['meter_data'][(count($meter['meter_data'])-1)]['Data']) : "Нет данных"); ?></td><td><input <?php echo((date(j) <= 19) ? 'disabled ' : ''); ?>value="<?php echo ((($last_update['year'] == date("Y")) AND ($last_update['month'] == date("m"))) ? $meter['meter_data'][(count($meter['meter_data'])-1)]['Data'] : ''); ?>" type="text" name="meter[<?php echo $key; ?>]"><p><?php echo $this->warning['field'][$key]; ?></p></td><td><?php echo (isset($meter['meter_data'][1]) ? ($meter['meter_data'][(count($meter['meter_data'])-1)]['Data']-$meter['meter_data'][(count($meter['meter_data'])-2)]['Data']).' '.$meter['unit'] : '-' ); ?></td></tr>
		<?php } ?>
		
		</table><br>
		
		<input name="submit" type="submit" <?php echo((date(j) <= 19) ? 'disabled ' : ''); ?>value="Отправить">
		</form>
		
            </div>
			<div style="width: 500px; height: 500; margin: 0 auto; position: relative;" class="clear">
			<p><b><i>Показания индивидуальных приборов учета горячего (ГВС) и холодного (ХВС) водоснабжения необходимо подавать в период с 20 по 30 число каждого месяца. Подаются показания только целых кубометров воды (черные цифры), смотрите рисунок:</i></b></p>
			<center><img src="http://sysoeva12.ru/wp-content/uploads/2013/03/99355a.png"></center></div><br><br>