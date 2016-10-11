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