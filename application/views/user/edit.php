<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Логин:</div>
    <div class="dataStudent"><?php echo $data['userData']['login']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Имя:</div>
    <div class="dataStudent"><input id="name" class="input dataStudent" type="text" value="<?php echo $data['userData']['name']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">E-mail:</div>
    <div class="dataStudent"><input id="email" class="input dataStudent" type="text" value="<?php echo $data['userData']['e-mail']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Старый пароль:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" placeholder="Необходим для изменения пароля или адреса почты"></div>
</div>
<div class="info">
    <div class="leftLabel">Новый пароль:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" placeholder="Необходим для изменения пароля"></div>
</div>
<div class="info">
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataStudent"><?php echo $data['userData']['permission']; ?></div>
</div>
<button class="button saveButton" onclick="parseAndSendData()">Сохранить</button>
<script type="text/javascript" src="/js/UserEdit.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>