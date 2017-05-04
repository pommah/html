<div class="title">Изменение данных ВУЗа</div>
<div>
    <div class='leftLabel'>Краткое наименование:</div>
    <div class="dataUser">
        <input id="short" type="text" class="input" value="<?php echo $data['university']['ShortName'] ?>">
    </div>
</div>
<div>
    <div class='leftLabel'>Полное наименование:</div>
    <div class="dataUser">
        <input id="full" type="text" size="60" class="input" value="<?php echo $data['university']['FullName'] ?>">
    </div>
</div>
<div>
    <div class='leftLabel'>Регион:</div>
    <div class="dataUser">
    <select id="region" class="input">
        <?php
        $selected = $data['university']['ID_Region'];
        foreach ($data['regions'] as $region) {
            $id = $region['ID'];
            $name = $region['Name'];
            if ($selected == $id) {
                printf("<option selected id='%s'>%s</option>", $id, $name);
            } else {
                printf("<option id='%s'>%s</option>", $id, $name);
            }
        }
        ?></select></div>
</div>
<div>
    <div class='leftLabel'>Статус:</div>
    <div class="dataUser">
    <select id="status" class='input'>
        <?php
        $private = $data['university']['Status'] == 'Частный' ? 'selected' : '';
        $state = $data['university']['Status'] == 'Государственный' ? 'selected' : '';
        printf("<option %s id='private'>Частный</option>", $private);
        printf("<option %s id='state'>Государственный</option>", $state);
        ?>
    </select></div>
</div>
<div>
    <div class='leftLabel'></div>
    <div class="dataUser">
        <button class="button control_button cancel_button" onclick="cancel()">Отменить</button>
        <button class="button control_button ok_button" onclick="saveChanges()">Сохранить</button>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<script type="text/javascript" src="/js/editUniversity.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>