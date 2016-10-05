<link rel="stylesheet" type="text/css" href="/css/add_student.css">
<div class="center">
<?php
print("<div class='label_input'> <div class='left_label'>ФИО:</div> <input class='input' type='text' name='FIO'></div>
        <div class='label_input'><div class='left_label'>Нозоологическая группа:</div> <select class='input' name='noz_group'>
            <option>Проблемы со зрением</option>
            <option>Проблемы со слухом</option>
        </select></div>
        <span class='labelInputDirection'>Направление:</span> <br><select class='input' name='direction' size='10'>
            <optgroup label=\"010000 МАТЕМАТИКА И МЕХАНИКА\">
                <option>010301 Математика</option>
                <option>010302 Прикладная математика и информатика</option>
                <option>010303 Механика и математическое моделирование</option>
                <option>010304 Прикладная математика</option>
            </optgroup>
            <optgroup label=\"020000 КОМПЬЮТЕРНЫЕ И ИНФОРМАЦИОННЫЕ НАУКИ\">
                <option>020301 Математика и компьютерные науки</option>
                <option>020302 Фундаментальная информатика и информационные технологии</option>
                <option>020303 Математическое обеспечение и администрирование информационных систем</option>
            </optgroup>
        </select><br>
        <div class='label_input'><div class='left_label'>Программа:</div> <input class='input' type='file' name='program'></div>
        <div class='label_input'><div class='left_label'>Дата поступления:</div> <input class='input' type='date' name='begin'></div>
        <div class='label_input'><div class='left_label'>Дата окончания:</div> <input class='input' type='date' name='end'></div>
        <button class='button add_student'>Добавить</button>");
?>
    </div>
