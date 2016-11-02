<link rel="stylesheet" type="text/css" href="/css/add_student.css">
<div class="center">
    <div class='label_input'> <div class='left_label'>Идентификатор:</div> <input class='input' type='text' id='fio'></div>
    <div class='label_input'><div class='left_label'>Нозологическая группа:</div> <select class='input' id='noz_group'>
            <?php
            foreach ($data['nozology'] as $row){
                printf("<option id='n%s'>%s</option>", $row['ID'], $row['Name']);
            }?>
        </select></div>
    <div class='label_input'><div class='left_label'>Дата поступления:</div> <input class='input' type='date' id='begin'></div>
    <div class='label_input'><div class='left_label'>Дата окончания:</div> <input class='input' type='date' id='end'></div>
    <?php
    function print_file_option($name, $id){
        print ("<div class='label_input'><div class='left_label'>");
        printf("<input type=\"checkbox\" onclick=\"switchByCheckbox(this.checked, '%s')\">%s:</div>", $id, $name);
        printf("<input class='input' type='file' accept='application/pdf,.doc, .docx' id='%s' disabled></div>", $id);
    }
    print_file_option("Файл реабилитационной программы", "fileNameReability");
    print_file_option("Психолого-педагогическое сопровождение", "fileNamePsycho");
    print_file_option("Профориентация", "fileNameCareer");
    print_file_option("Трудоустройство", "fileNameEmployment");
    print_file_option("Дистанционная образовательная технология", "fileNameDistance");
    print_file_option("Электронное портфолио", "fileNamePortfolio");
    ?>
    <div class='label_input'><div class='left_label'>Программа:
        </div><input class='input' type='radio' name="progType" id="radio_exist" value="existing" onclick="radioClicks(this)" checked>Существующая
        <input class='input' type='radio' name="progType" id="radio_new" value="new" onclick="radioClicks(this)">Новая</div>
    <div id="div_exist" class='label_input'><div class='left_label'>Выбор программы:</div><select class='input' id="program">
            <?php
                foreach ($data['programs'] as $id => $description){
                    printf("<option id='p%s'>%s</option>", $id, $description);
                }
            ?>
    </select></div>
    <div id="div_new" style="display: none"><span class='labelInputDirection'>Направление:</span><br><select class='input' id='direction' size='10'>
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
        <div class='label_input'> <div class='left_label'><input type="checkbox" onclick="switchByCheckbox(this.checked, 'profile')">Профиль:</div> <input class='input' type='text' id='profile' disabled></div>
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
        <div class='label_input'> <div class='left_label'>Файл программы:</div><input class='input' type='file' accept='application/pdf,.doc, .docx' id='fileNameProgram'></div>
        <div class='label_input'> <div class='left_label'><input type="checkbox" onclick="switchByCheckbox(this.checked, 'fileNamePlan')">Файл учебного плана:</div><input class='input' type='file' accept='application/pdf,.doc, .docx' id='fileNamePlan' disabled></div>
    </div>
    <button class='button add_student' onclick="cancel()">Отменить</button>
    <button class='button add_student' onclick="save()">Добавить</button>
    <script type="text/javascript" src="/js/ajax.js"></script>
    <script type="text/javascript" src="/js/addStudent.js"></script>
</div>