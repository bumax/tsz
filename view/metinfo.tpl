        <div align="center" style="width: 100%; height: 100%; margin: 0 auto; position: relative; padding: 40px 0;" class="clear">
<?php
if($_GET['edit'] == 'new')
$meters['new'] = array(
'type' => '',
'Number' => '',
'Comment' => '',
'id' => $room
);
?>
<form method="post">
Тип <select name="type"><?php $model->printOptions($meters[$_GET['edit']]['type']); ?></select><br>
Серийный номер <input name="Number" type="text" value="<?php echo $meters[$_GET['edit']]['Number']; ?>"><br>
Место установки <input name="Comment" type="text" value="<?php echo $meters[$_GET['edit']]['Comment']; ?>"><br>
<input type="hidden" name="id" value="<?php echo $meters[$_GET['edit']]['id']; ?>"> 
<input name="submit" type="submit" value="Сохранить"/>
</form>		
            </div>
