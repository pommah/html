<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Логин:</div>
    <div id="login" class="dataStudent"><?php echo $data['userData']['Login']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Имя:</div>
    <div class="dataStudent"><input id="name" class="input dataStudent" size="25" type="text" value="<?php echo $data['userData']['Name']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">E-mail:</div>
    <div class="dataStudent"><input id="email" class="input dataStudent" size="25" type="text" value="<?php echo $data['userData']['Email']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Старый пароль:</div>
    <div class="dataStudent"><input id="lastPassword" class="input dataStudent" type="text" size="25" placeholder="Необходим для изменения пароля или адреса почты"></div>
</div>
<div class="info">
    <div class="leftLabel">Новый пароль:</div>
    <div class="dataStudent"><input id="newPassword" class="input dataStudent" type="text" size="25" placeholder="Необходим для изменения пароля"></div>
</div>
<div class="info">
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataStudent"><?php echo UserTypes::ARRAY[$data['userData']['Permission']]; ?></div>
</div>
<button class="button saveButton" onclick="parseAndSendData()">Сохранить</button>
<div id="error"></div>

<script type="text/javascript" src="/js/UserEdit.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>