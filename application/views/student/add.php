<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<div class="title">Добавление студента</div>
<div class="center">
    <div>
        <div class='leftLabel'>Идентификатор:</div>
        <div class="dataUser"><input class='input' type='text' id='fio'></div>
    </div>
    <div>
        <div class='leftLabel'>Нозологическая группа:</div>
        <div class="dataUser">
            <select class='input' id='noz_group'>
                <?php
                foreach ($data['nozology'] as $row){
                    printf("<option id='n%s'>%s</option>", $row['ID'], $row['Name']);
                }?>
            </select>
        </div>
    </div>
    <div>
        <div class='leftLabel'>Дата поступления:</div>
        <div class="dataUser"><input class='input' type='date' id='begin'></div>
    </div>
    <div>
        <div class='leftLabel'>Дата окончания:</div>
        <div class="dataUser"><input class='input' type='date' id='end'></div>
    </div>
    <?php
    function print_file_option($name, $id)
    {
        print ("<div><div class='leftLabel'>");
        printf("<input type=\"checkbox\" onclick=\"switchByCheckbox(this.checked, '%s')\">%s:</div>", $id, $name);
        printf("<div class='dataUser'><input class='input' type='file' accept='application/pdf,.doc, .docx' id='%s' disabled></div></div>", $id);
    }

    print_file_option("Файл реабилитационной программы", "fileNameReability");
    print_file_option("Психолого-педагогическое сопровождение", "fileNamePsycho");
    print_file_option("Профориентация", "fileNameCareer");
    print_file_option("Трудоустройство", "fileNameEmployment");
    print_file_option("Дистанционная образовательная технология", "fileNameDistance");
    print_file_option("Электронное портфолио", "fileNamePortfolio");
    ?>
    <div>
        <div class='leftLabel'>Программа:
        </div>
        <div class="dataUser"><input class='input' type='radio' name="progType" id="radio_exist" value="existing"
                                        onclick="radioClicks(this)" checked>Существующая
            <input class='input' type='radio' name="progType" id="radio_new" value="new" onclick="radioClicks(this)">Новая
        </div>
    </div>

    <div id="div_exist">
        <div class='leftLabel'>Выбор программы:</div>
        <div class="dataUser"><select class='input' id="program">
                <?php
                foreach ($data['programs'] as $id => $description) {
                    printf("<option id='p%s'>%s</option>", $id, $description);
                }
                ?>
            </select></div>
    </div>

    <div id="div_new" style="display: none">
        <div>
            <div class="leftLabel"><span class='labelInputDirection'>Направление:</span></div>
            <div class="dataUser"><select class='input' id='direction' size='10'>
                    <?php
                    foreach ($data['directions'] as $ugsnId => $ugsnInfo) {
                        printf("<optgroup id='%s' label='%s %s'>", $ugsnId, $ugsnId, $ugsnInfo['ugsnName']);
                        foreach ($ugsnInfo['listDir'] as $id => $name) {
                            printf("<option id='%s'>%s.%s.%s %s</option>", $id, substr($id, 0, 2), substr($id, 2, 2), substr($id, 4, 2), $name);
                        }
                        print("</optgroup>");
                    }
                    ?>
                </select></div>
        </div>
        <div>
            <div class='leftLabel'><input type="checkbox" onclick="switchByCheckbox(this.checked, 'profile')">Профиль:
            </div>
            <div class="dataUser"><input class='input' type='text' id='profile' disabled></div>
        </div>
        <div>
            <div class='leftLabel'>Уровень образования:</div>
            <div class="dataUser">
                <select class="input" id='level'>
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
            <div class="dataUser"><input class='input' type='number' id='period'></div>
        </div>
        <div>
            <div class='leftLabel'>Форма обучения:</div>
            <div class="dataUser">
                <select class="input" id='form'>
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
            <div class="dataUser"><input class='input' type='file' accept='application/pdf,.doc, .docx'
                                            id='fileNameProgram'></div>
        </div>
        <div>
            <div class='leftLabel'><input type="checkbox" onclick="switchByCheckbox(this.checked, 'fileNamePlan')">Файл
                учебного плана:
            </div>
            <div class="dataUser"><input class='input' type='file' accept='application/pdf,.doc, .docx'
                                            id='fileNamePlan' disabled></div>
        </div>
    </div>

    <div>
        <div class='leftLabel'></div>
        <div class="dataUser">
            <button class='button control_button cancel_button' onclick="cancel()">Отменить</button>
            <button class='button control_button ok_button' onclick="save()">Добавить</button>
        </div>
    </div>

    <script type="text/javascript" src="/js/ajax.js"></script>
    <script type="text/javascript" src="/js/addStudent.js"></script>
</div>