<html>
<head>
    <title><?php echo $data['user']['title']; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/head.css">
    <link rel="stylesheet" type="text/css" href="/css/add_student.css">
</head>
<body>
<div class="head">
    <div class="type leftMenu">Данные ВУЗа</div>
    <div class="exit rightMenu" onclick="document.location.href='/control/exit'">Выход</div>
    <div class="nameUser rightMenu"><?php echo $data['user']['name']; ?></div>
</div>

<div class="content">
    <div class='label_input'> <div class='left_label'>Краткое наименование:</div><input type="text" class="input"></div>
    <div class='label_input'> <div class='left_label'>Полное наименование:</div><input type="text" class="input"></div>
    <div class='label_input'> <div class='left_label'>Регион:</div><select class="input">
            <?php

            foreach ($data['regions'] as $region){
                printf ("<option>%s</option>", $region);
            }
            ?></select></div>
    <div class='label_input'> <div class='left_label'>Статус:</div><select class='input'>
            <option>Частный</option>
            <option>Государственный</option>
        </select></div>
    <button class="button">Отменить</button>
    <button class="button">Сохранить</button>
</div>
</body>
<script type="text/javascript" src="/js/directionEditor.js"></script>
</html>