<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Логин:</div>
    <div class="dataStudent"><?php echo $data['userData']['Login']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Имя:</div>
    <div class="dataStudent"><?php echo $data['userData']['Name']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">E-mail:</div>
    <div class="dataStudent"><?php echo $data['userData']['Email']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Уровень доступа:</div>
    <div class="dataStudent"><?php echo UserTypes::ARRAY[$data['userData']['Permission']]; ?></div>
</div>
<?php
    $info = $data['userData'];
    if ($info['Permission'] == '2'){
        print("<div class='info'>");
        print ("<div class=\"leftLabel\">Университет:</div>");
        printf("<div class=\"dataStudent\">%s</div></div>", $info['Univer']);
    }
?>
<button class="button saveButton" onclick="document.location.href='/user/edit'">Изменить</button>