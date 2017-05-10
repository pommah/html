<link rel="stylesheet" type="text/css" href="/css/student.css">
<link rel="stylesheet" type="text/css" href="/css/prompt.css">
<link rel="stylesheet" type="text/css" href="/css/promptEdit.css">

<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<div class="title">Изменение данных студента</div>
<div>
    <div class="leftLabel">Идентификатор:</div>
    <div class="dataUser">
        <input class="input" type="text" id="name" value="<?php echo $data['student']['Name']; ?>">
    </div>
</div>

<div>
    <div class='leftLabel'>Нозологическая группа:</div>
    <div class="dataUser">
        <select class='input' id='noz_group'>
            <?php
            foreach ($data['nozology'] as $row) {
                $selected = $data['student']['Nozology'] == $row['Name'] ? 'selected' : '';
                printf("<option id='n%s' %s>%s</option>", $row['ID'], $selected, $row['Name']);
            } ?>
        </select>
    </div>
</div>

<div>
    <div class="leftLabel">Дата начала обучения:</div>
    <div class="dataUser"><input class="input" type="date" id="dateBegin"
                                    value="<?php echo $data['student']['DateBegin']; ?>"></div>
</div>

<div>
    <div class="leftLabel">Дата конца обучения:</div>
    <div class="dataUser"><input class="input dataStudent" type="date" id="dateEnd"
                                    value="<?php echo $data['student']['DateEnd']; ?>"></div>
</div>
<?php
function print_file_picker($id, $text, $current, $folder)
{
    print("<div> <div class='leftLabel'>");
    printf("%s:</div><div class=\"dataUser\">", $text);
    printf("<select id='select_%s' onchange='processSelect(this, \"%s\", \"%s\")' class='input'>", $folder, $folder, $id);
    if ($current != null) {
        printf("<option id='%s'>Оставить текущий файл</option>", $current);
        print ("<option>Удалить файл</option>");
    } else {
        print ("<option>Отсутствует</option>");
    }
    print ("<option>Загрузить новый файл</option>");
    print ("</select>");
    printf("<input class='input dataStudent' type='file' id='%s' style='display: none;'>", $id);
    if ($current != null) {
        printf("<a id='%s' href='/files/%s/%s'>Текущий файл</a>", $folder, $folder, $current);
    }
    print(" </div></div>");
}

print_file_picker("fileNameReability", "Файл реабилитационной программы", $data['student']['Rehabilitation'], 'rehabilitation');
print_file_picker("fileNamePsycho", "Психолого-педагогическое сопровождение", $data['student']['Psychology'], 'psychology');
print_file_picker("fileNameCareer", "Профориентация", $data['student']['Career'], 'career');
print_file_picker("fileNameEmployment", "Трудоустройство", $data['student']['Employment'], 'employment');
print_file_picker("fileNameDistance", "Дистанционная образовательная технология", $data['student']['Distance'], 'distance');
print_file_picker("fileNamePortfolio", "Электронное портфолио", $data['student']['Portfolio'], 'portfolio');
?>

<div>
    <div class="leftLabel">Программа обучения:</div>
    <div class="dataUser rightLabel">
        <!--<a href="<?php echo $data['student']['File']; ?>">Программа обучения</a><input type="file" id="learProgram" class="button changeButton"> -->
        <input id="current_info" type="radio" name="progType" onclick="radioClicks(this)">Оставить текущую
        <input id="current_edit" type="radio" name="progType" onclick="radioClicks(this)">Изменить текущую
        <input id="current_change" type="radio" name="progType" onclick="radioClicks(this)">Изменить на существующую
        <input id="add_new" type="radio" name="progType" onclick="radioClicks(this)">Добавить новую
    </div>
</div>
<div id="div_current_info">
    <div>
        <div class="leftLabel">Направление:</div>
        <div class="dataUser rightLabel"><?php echo $data['student']['Direction']; ?></div>
    </div>
    <div>
        <div class="leftLabel">Профиль:</div>
        <div
            class="dataUser rightLabel"><?php echo $data['student']['Profile'] == '' ? $data['student']['Direction'] : $data['student']['Profile']; ?></div>
    </div>
    <div>
        <div class="leftLabel">Уровень образования:</div>
        <div class="dataUser rightLabel">
            <?php echo $data['student']['Level']; ?>
        </div>
    </div>
    <div>
        <div class="leftLabel">Период обучения:</div>
        <div class="dataUser rightLabel"><?php echo $data['student']['Period']; ?></div>
    </div>
    <div>
        <div class="leftLabel">Форма обучения:</div>
        <div class="dataUser rightLabel">
            <?php echo $data['student']['Form']; ?>
        </div>
    </div>
    <div>
        <div class="leftLabel">Программа обучения:</div>
        <div class="dataUser rightLabel"><a href="<?php echo $data['student']['File']; ?>">Программа обучения</a></div>
    </div>
    <div class="info last">
        <div class="leftLabel">Учебный план:</div>
        <div class="dataUser rightLabel"><a href="<?php echo $data['student']['Plan']; ?>">Учебный план</a></div>
    </div>
</div>
<div id="div_current_edit" style="display: none">
    <?php printf("<div id='programId' style='display: none'>%s</div>", $data['student']['ProgramId']) ?>
    <div class='leftLabel'>Направление:</div><div class="dataUser"><select class='input' id='ce_direction' size='10'>
        <?php
        $direction = $data['student']['Direction'];
        foreach ($data['directions'] as $ugsnId => $ugsnInfo) {
            printf("<optgroup id='%s' label='%s %s'>", $ugsnId, $ugsnId, $ugsnInfo['ugsnName']);
            foreach ($ugsnInfo['listDir'] as $id => $name) {
                $selected = $name == $direction ? "selected" : "";
                printf("<option %s id='%s'>%s.%s.%s %s</option>", $selected, $id, substr($id, 0, 2), substr($id, 2, 2), substr($id, 4, 2), $name);
            }
            print("</optgroup>");
        }
        ?>
    </select>
    </div>
    <div>
        <div class='leftLabel'><input type="checkbox" onclick="switchByCheckbox(checked, 'ce_profile')">Профиль:</div>
        <div class="dataUser"><input class='input' type='text' id='ce_profile' disabled></div></div>
    <div class='info'>
        <div class='leftLabel'>Уровень образования:</div>
        <div class="dataUser"><select class="input" id='ce_level'>
            <?php
            $currLevel = $data['student']['Level'];
            foreach (Utils::$levels as $level) {
                $selected = $level == $currLevel ? "selected" : "";
                printf("<option %s>%s</option>", $selected, $level);
            }
            ?>
        </select>
        </div>
    </div>
    <div>
        <div class='leftLabel'>Период обучения:</div>
        <div class="dataUser"><input class='input' type='number' id='ce_period' value="<?php echo $data['student']['Period']; ?>"></div>
    </div>
    <div>
        <div class='leftLabel'>Форма обучения:</div>
        <div class="dataUser"><select class="input" id='ce_form'>
                <?php
                $currForm = $data['student']['Form'];
                foreach (Utils::$forms as $form) {
                    $selected = $form == $currForm ? "selected" : "";
                    printf("<option>%s</option>", $form);
                }
                ?>
            </select>
        </div>
    </div>
    <div>
        <div class='leftLabel'>Файл программы:</div>
        <div class="dataUser"><input class='input' type='file' id='ce_fileNameProgram'></div></div>
    <?php print_file_picker("ce_fileNamePlan", "Файл учебного плана", $data['student']['Plan'], 'plans'); ?>
</div>
<div id="div_current_change" style="display: none">
    <div class="leftLabel">Программа:</div>
    <div class="dataUser"><select class='input' id="program">
        <?php
        foreach ($data['programs'] as $id => $description) {
            printf("<option id='p%s'>%s</option>", $id, $description);
        }
        ?>
    </select>
    </div>
</div>
<div id="div_add_new" style="display: none">
    <div>
    <div class='leftLabel'>Направление:</div><div class="dataUser"><select class='input' id='an_direction' size='10'>
        <?php
        foreach ($data['directions'] as $ugsnId => $ugsnInfo) {
            printf("<optgroup id='%s' label='%s %s'>", $ugsnId, $ugsnId, $ugsnInfo['ugsnName']);
            foreach ($ugsnInfo['listDir'] as $id => $name) {
                printf("<option id='%s'>%s.%s.%s %s</option>", $id, substr($id, 0, 2), substr($id, 2, 2), substr($id, 4, 2), $name);
            }
            print("</optgroup>");
        }
        ?>
    </select>
    </div>
    </div>
    <div>
        <div class='leftLabel'>
            <input type="checkbox" onclick="switchByCheckbox(checked, 'an_profile')">Профиль:</div>
        <div class="dataUser"><input class='input' type='text' id='an_profile' disabled></div>
        </div>
    <div class='info'>
        <div class='leftLabel'>Уровень образования:</div>
        <div class="dataUser">
        <select class="input" id='an_level'>
            <?php
            foreach (Utils::$levels as $level) {
                printf("<option>%s</option>", $level);
            }
            ?>
        </select>
        </div>
    </div>
    <div>
        <div class='leftLabel'>Период обучения:</div>
        <div class="dataUser">
        <input class='input' type='number' id='an_period'></div>
    </div>
    <div>
        <div class='leftLabel'>Форма обучения:</div>
        <div class="dataUser">
        <select class="input" id='an_form'>
            <?php
            foreach (Utils::$forms as $form) {
                printf("<option>%s</option>", $form);
            }
            ?>
        </select>
        </div>
    </div>
    <div>
        <div class='leftLabel'>Файл программы:</div>
        <div class="dataUser">
        <input class='input' type='file' id='an_fileNameProgram'></div>
        </div>
    <?php
    print_file_picker("an_fileNamePlan", "Файл учебного плана", null, "an_plans");
    ?>
</div>

<div>
    <div class='leftLabel'></div>
    <div class="dataUser">
        <button class="button control_button cancel_button" onclick="cancel()">Отменить</button>
        <button class="button control_button ok_button" onclick="saveStudentChanges()">Сохранить</button>
    </div>
</div>

<div class="individualTrack">
    <div class="headTrack">Индивидуальная траектория студента</div>
    <?php
    function image_file($name)
    {
        $name = explode(".", $name);
        $image = '';
        switch ($name[1]) {
            case "pdf":
                $image = "/images/pdf_file.png";
                break;
            case "doc":
            case "docx":
                $image = "/images/doc_file.png";
                break;
        }
        return $image;
    }

    $dopcolumnH = '';
    $dopcolumnL = '';
    //<td>Психолого педагогическое сопровождени</td><td>Профориетация</td><td>ДОТ</td><td>Портфолио</td>
    if ($data['student']['Psychology']) {
        $image = image_file($data['student']['Psychology']);
        $dopcolumnL = $dopcolumnL . "<td><a href='/files/psychology/" . $data['student']['Psychology'] . "'><img width='50' src='" . $image . "'></a></td>";
        $dopcolumnH = $dopcolumnH . "<td>Психолого педагогическое сопровождение</td>";
    }
    if ($data['student']['Career']) {
        $image = image_file($data['student']['Career']);
        $dopcolumnL = $dopcolumnL . "<td><a href='/files/career/" . $data['student']['Career'] . "'><img width='50' src='" . $image . "'></a></td>";
        $dopcolumnH = $dopcolumnH . "<td>Профориентация</td>";
    }
    if ($data['student']['Distance']) {
        $image = image_file($data['student']['Distance']);
        $dopcolumnL = $dopcolumnL . "<td><a href='/files/distance/" . $data['student']['Distance'] . "'><img width='50' src='" . $image . "'></a></td>";
        $dopcolumnH = $dopcolumnH . "<td>ДОТ</td>";
    }
    if ($data['student']['Portfolio']) {
        $image = image_file($data['student']['Portfolio']);
        $dopcolumnL = $dopcolumnL . "<td><a href='/files/portfolio/" . $data['student']['Portfolio'] . "'><img width='50' src='" . $image . "'></a></td>";
        $dopcolumnH = $dopcolumnH . "<td>Портфолио</td>";
    }
    printf("<table id='trackTable' class='trackTable'><tr class='headTrackTable'><td class='firstColumn'>%s</td> <td colspan='%s'>Учебная работа</td>%s
     </tr><tr><td class='firstColumn'>Общеобразовательные/адаптивные дисциплины</td>", $data['student']['Name'], count($data['student']['Track']) + 1, $dopcolumnH);
    for ($i = 1; $i <= sizeof($data['student']['Track']); $i++) {
        if (array_key_exists($i, $data['student']['Track'])) {
            $color = $data['student']['Track'][$i]['Color'];
            $text = null;
            foreach ($data['student']['Track'][$i]['Note'] as $key => $value) {
                $text = $text . '&' . $key . '=' . $value;
            }
            $adaptive = '';
            $adaptiveData = null;
            if (count($data['student']['Track'][$i]['Adaptive'])) {
                $adaptive = "<div class='adaptiveBlock' >" . count($data['student']['Track'][$i]['Adaptive']) . "</div>";
                foreach ($data['student']['Track'][$i]['Adaptive'] as $key => $value) {
                    $adaptiveData = $adaptiveData . ';' . $value;
                }
            }
            printf("<td style='background-color: %s' id='module_%s' onclick=\"prompEdit('%s', '%s','%s','%s','%s','%s')\">%s%s</td>", $color, $i, $data['student']['Track'][$i]['ID'], $i, $data['student']['Track'][$i]['Status'], $text, $data['student']['Track'][$i]['File'], $adaptiveData, $i, $adaptive);
        } else {
            printf("<td>%s</td>", $i);
        }
    }
    printf("<td onclick='addModule()' class='plus icon'></td>%s</tr></table>", $dopcolumnL);
    ?>
    <div class="prompt" id="promt"></div>
</div>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript">
    var learnID = '<?php echo $data['student']['LearnID']; ?>';
</script>
<script type="text/javascript" src="/js/promptEdit.js"></script>
