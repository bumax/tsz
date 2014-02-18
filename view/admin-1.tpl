        <div align="center" style="width: 100%; height: 100%; margin: 0 auto; position: relative; padding: 40px 0;" class="clear">

		<p>Очистка квитанций</p>
		<form method = "post">
			<select name="month">
			<?php for($i=1;$i<13;$i++){ ?>
				<option <?php if($i == date('n')) echo 'selected'; ?> value="<?php echo sprintf("%02d",$i); ?>"><?php echo $model->rusMonth($i); ?></option>
			<?php } ?>
			</select>
			<select name="year">
						<?php for($i=2013;$i<=date('Y');$i++){ ?>
				<option <?php if($i == date('Y')) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
			</select>
			<input name="submit" type="submit" value="Очистить">
		</form><br>
		
		<p>Экспорт показаний</p>
		<form method = "post">
			<select name="month">
			<?php for($i=1;$i<13;$i++){ ?>
				<option <?php if($i == date('n')) echo 'selected'; ?> value="<?php echo sprintf("%02d",$i); ?>"><?php echo $model->rusMonth($i); ?></option>
			<?php } ?>
			</select>
			<select name="year">
						<?php for($i=2013;$i<=date('Y');$i++){ ?>
				<option <?php if($i == date('Y')) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
			</select>
			<input name="submit" type="submit" value="Скачать">
		</form><br>
			
		<table  width="800"><tr><td width="20%"><b>№ квартиры</b></td><td width="30%"><b>Собственник</b></td><td width="20%"><b>Кол-во комнат</b></td><td width="20%"><b>Площадь</b></td><td width="10%"><b>Действия</b></td></tr>
		<?php foreach($rooms as $key=>$room){ ?>
				

		<tr><td><?php echo $room['room']; ?></td><td><?php echo $room['Name']; ?></td><td><?php echo $room['NR']; ?></td><td><?php echo $room['SQ']; ?></td><td><a href="./?route=admin&room=<?php echo $room['room']; ?>">Редактировать</a></td></tr>
		<?php } ?>
		
		</table>

		
            </div>
			