<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">

<div class="title">Учётные данные</div>
<div>
    <div class="leftLabel">Логин:</div>
    <div class="dataUser rightLabel"><?php echo $data['userData']['Login']; ?></div>
</div>
<div>
    <div class="leftLabel">Имя:</div>
    <div class="dataUser rightLabel"><?php echo $data['userData']['Name']; ?></div>
</div>
<div>
    <div class="leftLabel">E-mail:</div>
    <div class="dataUser rightLabel"><?php echo $data['userData']['Email']; ?></div>
</div>
<div>
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataUser rightLabel"><?php echo UserTypes::ARRAY[$data['userData']['Permission']]; ?></div>
</div>
<?php
    $info = $data['userData'];
    if ($info['Permission'] == '2'){
        print("<div class='info'>");
        print ("<div class=\"leftLabel\">Университет:</div>");
        printf("<div class=\"dataUser rightLabel\">%s</div></div>", $info['Univer']);
    }
?>
<div>
    <div class="leftLabel"></div>
    <div class="dataUser">
        <button class="button control_button ok_button" onclick="document.location.href='/user/edit'">Изменить</button>
    </div>
</div>
