<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<div class="title">Изменение данных пользователя</div>
<div">
<div class="leftLabel">Логин:</div>
<div class="dataUser rightLabel">
    <div id="login"><?php echo $data['userData']['Login']; ?></div>
</div>
</div>
<div>
    <div class="leftLabel">Имя:</div>
    <div class="dataUser">
        <div class="dataStudent"><input id="name" class="input" size="25" type="text"
                                        value="<?php echo $data['userData']['Name']; ?>"></div>
    </div>
</div>
<div>
    <div class="leftLabel">E-mail:</div>
    <div class="dataUser">
        <div class="dataStudent"><input id="email" class="input" size="25" type="text"
                                        value="<?php echo $data['userData']['Email']; ?>"></div>
    </div>
</div>
<div>
    <div class="leftLabel">Старый пароль:</div>
    <div class="dataUser">
        <div class="dataStudent"><input id="lastPassword" class="input" type="password" size="25"
                                        placeholder="Необходим для изменения пароля или адреса почты"></div>
    </div>
</div>
<div>
    <div class="leftLabel">Новый пароль:</div>
    <div class="dataUser">
        <div class="dataStudent"><input id="newPassword" class="input" type="password" size="25"
                                        placeholder="Необходим для изменения пароля"></div>
    </div>
</div>
<div>
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataUser rightLabel">
        <?php echo UserTypes::ARRAY[$data['userData']['Permission']]; ?>
    </div>
</div>
<div>
    <div class="leftLabel"></div>
    <div class="dataUser">
        <button class="button control_button cancel_button" onclick="window.history.back();">Отменить</button>
        <button class="button control_button ok_button" onclick="parseAndSendData()">Сохранить</button>
    </div>
</div>
<div id="error"></div>

<script type="text/javascript" src="/js/UserEdit.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>