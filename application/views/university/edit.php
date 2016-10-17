<div class='info'> <div class='leftLabel'>Краткое наименование:</div><input id="short" type="text" class="input" value="<?php echo $data['university']['ShortName']?>"></div>
<div class='info'> <div class='leftLabel'>Полное наименование:</div><input id="full" type="text" size="60" class="input" value="<?php echo $data['university']['FullName']?>"></div>
<div class='info'> <div class='leftLabel'>Регион:</div><select id="region" class="input">
        <?php
        $selected = $data['university']['ID_Region'];
        foreach ($data['regions'] as $region){
            $id = $region['ID'];
            $name = $region['Name'];
            if ($selected == $id){
                printf ("<option selected id='%s'>%s</option>", $id, $name);
            }
            else{
                printf ("<option id='%s'>%s</option>", $id, $name);
            }
        }
        ?></select></div>
<div class='info'> <div class='leftLabel'>Статус:</div><select id="status" class='input'>
        <?php
            $private = $data['university']['Status']=='Частный'?'selected':'';
            $state = $data['university']['Status']=='Государственный'?'selected':'';
            printf("<option %s id='private'>Частный</option>", $private);
            printf("<option %s id='state'>Государственный</option>", $state);
        ?>
    </select></div>
<button class="button">Отменить</button>
<button class="button" onclick="saveChanges()">Сохранить</button>
<link rel="stylesheet" type="text/css" href="/css/student.css">
<script type="text/javascript" src="/js/editUniversity.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>