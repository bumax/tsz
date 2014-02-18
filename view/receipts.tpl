        <div align="center" style="width: 100%; height: 100%; margin: 0 auto; position: relative; padding: 40px 0;" class="clear">

		<table  width="800"><tr bgcolor="#D2D2D2"><td width="20%"><b>Месяц</b></td><td width="30%"><b>Год</b></td><td width="20%"><b>Начислено</b></td><td width="20%"><b><font color="green">Переплата</font>/<font color="red">долг</font></b></td><td width="10%"><b>Квитанция</b></td></tr>
		<?php foreach($receipts as $key=>$receipt){ ?>
				

		<tr <?php if($key & 1) { ?>bgcolor="#EDEDED"<?php } ?>><td><?php echo $receipt['DateM']; ?></td><td><?php echo $receipt['DateY']; ?></td><td><?php echo $receipt['Payable']; ?></td><td><?php echo $receipt['Debt']; ?></td><td><?php echo $receipt['Link']; ?></td></tr>
		<?php } ?>
		
		</table>
		
            </div>
