        
                <img src="images/keys.png">
            <div class="information float-right">
                <section>
                    <h2>Личный кабинет</h2>
                    <p>Для авторизации введите номер квартиры и пароль.</p>
                </section>
                <section align=center>
					<form method="post">
					<p>Номер квартиры</p><input type="text" name="login">
					<p>Пароль</p><input type="password" name="password">
					<p><?php if(isset($this->warning)){?><font color="red"><?php echo $this->warning; ?></font><?php } ?><br><input name="submit" type="submit" value="Вход"></p>
					</form>
                </section>
            </div>
			<div style="background: #FEFEFE;padding:10px 10px;border:1px dashed #000000;width: 800px; height: 100%; margin: 0 auto; position: relative;" class="clear">
			<p>Для получения доступа к Личному кабинету, собственникам необходимо обратиться в ТСЖ «Сысоева» в часы приема, при себе иметь паспорт, либо свидетельство о регистрации прав собственности.<br>Для собственников, не имеющих возможности обратиться лично, отправить на электронный адрес <b>info@sysoeva12.ru</b> заявку с приложением:<br>
- ФИО собственника;<br>
- Адрес и площадь помещения;<br>
- скан документа, подтверждающий право собственности;<br>
- контактные данные.</p></div>