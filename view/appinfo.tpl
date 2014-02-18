        <div align="center" style="width: 100%; height: 100%; margin: 0 auto; position: relative; padding: 40px 0;" class="clear">

<form method="post">
<h2>Квартира № <b><?php echo $room; ?></b></h2><br>
Лицевой счет <b><?php echo $PA; ?></b><br>
e-mail <b><?php echo $email; ?></b><br>
Собственник: <input name="Name" type="text" value="<?php echo $Name; ?>"><br>
Количество комнат: <input name="NR" type="text" value="<?php echo $NR; ?>"><br>
Площадь: <input name="SQ" type="text" value="<?php echo $SQ; ?>"><br>
<input name="submit" type="submit" value="Сохранить"/>
</form>		
<?php if(isset($meters[0])) { ?>
<table><tr><td>Тип</td><td>Серийный номер</td><td>Место установки</td><td>Действия</td></tr>
<?php foreach($meters as $key=>$meter){ ?>
<tr><td><?php echo $meter['type']; ?></td><td><?php echo $meter['Number']; ?></td><td><?php echo $meter['Comment']; ?></td><td><a href="./?route=admin&room=<?php echo $room; ?>&edit=<?php echo $key; ?>">Редактировать</a> | <a href="./?route=admin&room=<?php echo $room; ?>&remove=<?php echo $meter['id']; ?>">Удалить</a></td></tr>
<?php } ?>
</table>
<?php } ?>
<a href="./?route=admin&room=<?php echo $room; ?>&edit=new">Добавить счетчик</a>

            </div>
