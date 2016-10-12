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
    <div class="dataStudent"><select class='input' id='direction' size='10'>
            <?php
            foreach ($data['directions'] as $ugsnId => $ugsnInfo){
                printf("<optgroup id='%s' label='%s %s'>", $ugsnId, $ugsnId, $ugsnInfo['ugsnName']);
                foreach ($ugsnInfo['listDir'] as $id => $name){
                    if($data['student']['Direction'] == $name) $selected = "selected";
                    else $selected = null;
                    printf("<option %s id='%s'>%s.%s.%s %s</option>",$selected, $id, substr($id, 0, 2), substr($id, 2, 2), substr($id, 4, 2), $name);
                }
                print("</optgroup>");
            }
            ?>
        </select>
    </div>
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
        <?php
        $forms = ["Очная","Заочная"];
        $myform = $data['student']['Form'];
        print("<select class='input dataStudent'>");
        print("<option disabled>Выберите форму обучения</option>");
        foreach ($forms as $value) {
            if($myform == $value) $selected = 'selected';
            else $selected = null;
            printf("<option %s value='%s'>%s</option>", $selected,$value,$value);
        }
        print("</select>");
        ?>
    </div>
</div>
<div class="info last">
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataStudent"><a href="<?php echo $data['student']['File']; ?>">Программа обучения</a><button class="button changeButton">Изменить</button> </div>
</div>

<button class="button saveButton">Сохранить</button>

<div class="individualTrack">
    <div class="headTrack">Индивидуальная траектория студента</div>
    <?php
    print("<table id='trackTable' class='trackTable'><tr>");
    for($i=1; $i<=round($data['student']['Period']*2); $i++) {
        if(array_key_exists($i, $data['student']['Track'])) {
            $color = $data['student']['Track'][$i]['Color'];
            $text = null;
            foreach ($data['student']['Track'][$i]['Note'] as $key => $value) {
                $text = $text.' '.$key.'='.$value;
            }
            printf("<td bgcolor='%s' onmouseover=\"prompShow('%s','%s','%s')\">%s</td>",$color, $i, $data['student']['Track'][$i]['Status'],$text, $i);
        }
        else {
            printf("<td>%s</td>", $i);
        }
    }
    print("</tr></table>");
    ?>
    <div class="prompt" id="promt"></div>
</div>

