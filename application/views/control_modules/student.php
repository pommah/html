<link rel="stylesheet" type="text/css" href="/css/student.css">
<div class="info">
    <div class="leftLabel">Идентификатор:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" value="<?php echo $data['student']['Name']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Нозологическая группа:</div>
    <div class="dataStudent"><?php echo $data['student']['Nozology']; ?></div>
</div>
<div class="info">
    <div class="leftLabel">Дата начала обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateBegin']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Дата конца обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateEnd']; ?>"></div>
</div>
<div class="info">
    <div class="leftLabel">Направление:</div>
    <div class="dataStudent"><?php echo $data['student']['Direction']; ?><button class="button changeButton">Изменить</button> </div>
</div>
<div class="info">
    <div class="leftLabel">Уровень образования</div>
    <div class="dataStudent">
        <?php
        $levels = ["Бакалавр","Магистратура","Специалитет"];
        $mylevel = $data['student']['Level'];
        print("<select class='input dataStudent'>");
        print("<option disabled>Выберите уровень образования</option>");
        foreach ($levels as $value) {
            if($mylevel == $value) $selected = 'selected';
            else $selected = null;
            printf("<option %s value='%s'>%s</option>", $selected,$value,$value);
        }
        print("</select>");
        ?>
    </div>
</div>

<div class="info">
    <div class="leftLabel">Форма обучения:</div>
    <div class="dataStudent">
        <select class="input dataStudent">
            <option>Очная</option>
            <option>Заочная</option>
        </select>
    </div>
</div>
<div class="info">
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataStudent"><a href="<?php echo $data['student']['File']; ?>"><?php echo $data['student']['File']; ?></a><button class="button changeButton">Изменить</button> </div>
</div>

<button class="button saveButton">Сохранить</button>

