<link rel="stylesheet" type="text/css" href="/css/student.css">
<link rel="stylesheet" type="text/css" href="/css/prompt.css">
<link rel="stylesheet" type="text/css" href="/css/promptEdit.css">
<div class="info">
    <div class="leftLabel">Идентификатор:</div>
    <div class="dataStudent"><input class="input dataStudent" type="text" value="<?php echo $data['student']['Name']; ?>"></div>
</div>

<div class='info'><div class='leftLabel'>Нозологическая группа:</div> <select class='input dataStudent' id='noz_group'>
        <?php
        foreach ($data['nozology'] as $row){
            $selected = $data['student']['Nozology'] == $row['Name'] ? 'selected' : '';
            printf("<option id='n%s' %s>%s</option>", $row['ID'], $selected, $row['Name']);
        }?>
    </select></div>

<div class="info">
    <div class="leftLabel">Дата начала обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateBegin']; ?>"></div>
</div>

<div class="info">
    <div class="leftLabel">Дата конца обучения:</div>
    <div class="dataStudent"><input class="input dataStudent" type="date" value="<?php echo $data['student']['DateEnd']; ?>"></div>
</div>


<div class="info">
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataStudent"><!--<a href="<?php echo $data['student']['File']; ?>">Программа обучения</a><input type="file" id="learProgram" class="button changeButton"> -->
        <input id="current_info" type="radio" name="progType" onclick="radioClicks(this)">Оставить текущую
        <input id="current_edit" type="radio" name="progType" onclick="radioClicks(this)">Изменить текущую
        <input id="current_change" type="radio" name="progType" onclick="radioClicks(this)">Изменить на существующую
        <input id="add_new" type="radio" name="progType" onclick="radioClicks(this)">Добавить новую
    </div>
</div>
<div id="div_current_info">
    <div class="info">
        <div class="leftLabel">Направление:</div>
        <div class="dataStudent"><?php echo $data['student']['Direction']; ?></div>
    </div>
    <div class="info">
        <div class="leftLabel">Уровень образования</div>
        <div class="dataStudent">
            <?php echo $data['student']['Level']; ?>
        </div>
    </div>

    <div class="info">
        <div class="leftLabel">Форма обучения:</div>
        <div class="dataStudent">
            <?php echo $data['student']['Form']; ?>
        </div>
    </div>
    <div class="info last">
        <div class="leftLabel">Программа обучения:</div>
        <div class="dataStudent"><a href="<?php echo $data['student']['File']; ?>">Программа обучения</a></div>
    </div>
</div>
<div id="div_current_edit" style="display: none">
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
</div>
<div id="div_current_change" style="display: none">
    <select class='input' id="program">
        <?php
        foreach ($data['programs'] as $id => $description){
            printf("<option id='p%s'>%s</option>", $id, $description);
        }
        ?>
    </select>
</div>
<div id="div_add_new" style="display: none">
    <span class='labelInputDirection'>Направление:</span><br><select class='input' id='direction' size='10'>
        <?php
        foreach ($data['directions'] as $ugsnId => $ugsnInfo){
            printf("<optgroup id='%s' label='%s %s'>", $ugsnId, $ugsnId, $ugsnInfo['ugsnName']);
            foreach ($ugsnInfo['listDir'] as $id => $name){
                printf("<option id='%s'>%s.%s.%s %s</option>", $id, substr($id, 0, 2), substr($id, 2, 2), substr($id, 4, 2), $name);
            }
            print("</optgroup>");
        }
        ?>
    </select>
    <div class='label_input'> <div class='left_label'><input type="checkbox" onclick="switchProfile(this)">Профиль:</div> <input class='input' type='text' id='profile' disabled></div>
    <div class='label_input'> <div class='left_label'>Уровень образования:</div>
        <select class="input" id='level'>
            <?php
            foreach (Utils::$levels as $level){
                printf("<option>%s</option>", $level);
            }
            ?>
        </select>
    </div>
    <div class='label_input'> <div class='left_label'>Период обучения:</div><input class='input' type='number' id='period'></div>
    <div class='label_input'> <div class='left_label'>Форма обучения:</div>
        <select class="input" id='form'>
            <?php
            foreach (Utils::$forms as $form){
                printf("<option>%s</option>", $form);
            }
            ?>
        </select>
    </div>
    <div class='label_input'> <div class='left_label'>Файл программы:</div><input class='input' type='file' id='fileNameProgram'></div>
    <div class='label_input'> <div class='left_label'><input type="checkbox" onclick="switchFilePlan(this)">Файл учебного плана:</div><input class='input' type='file' id='fileNamePlan' disabled></div>
    <div class='label_input'> <div class='left_label'><input type="checkbox" onclick="switchFileReability(this)">Файл реабилитационной программы:</div><input class='input' type='file' id='fileNameReability' disabled></div>

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
            printf("<td bgcolor='%s' id='module_%s' onclick=\"prompEdit('%s','%s','%s')\">%s</td>",$color, $i,$i, $data['student']['Track'][$i]['Status'],$text, $i);
        }
        else {
            printf("<td>%s</td>", $i);
        }
    }
    print("</tr></table>");
    ?>
    <div class="prompt" id="promt"></div>
</div>

<script type="text/javascript" src="/js/promptEdit.js"></script>

