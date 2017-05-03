<div class="title">Добавление ВУЗа</div>
<hr>
<div class="blockInput">
    <div>
        <div class="leftLabel">
            Регион:
        </div>
        <div class="dataUser">
            <select id="region" class="input">
                <?php
                $okrug = null;
                foreach ($data['regions'] as $region){
                    if ($region['okrugName'] != $okrug){
                        if ($okrug != null){
                            print("</optgroup>");
                        }
                        $okrug = $region['okrugName'];
                        printf("<optgroup label='%s федеральный округ'>", $okrug);
                    }
                    printf("<option id='%s'>%s</option>", $region['ID'], $region['regionName']);
                }
                print ("</optgroup>")
                ?>
            </select>
        </div>
    </div>
    <div>
        <div class="leftLabel">
            Полное наименование:
        </div>
        <div class="dataUser">
            <input type="text" id="fullName" class="input" size="41" placeholder="Укажите полное наименование">
        </div>
    </div>
    <div>
        <div class="leftLabel">
            Краткое наименование:
        </div>
        <div class="dataUser">
            <input type="text" id="shortName" class="input" size="41" placeholder="Укажите краткое наименование">
        </div>
    </div>
    <div>
        <div class="leftLabel">
            Статус:
        </div>
        <div class="dataUser">
            <select id="status" class="input">
                <option>Государственный</option>
                <option>Частный</option>
            </select>
        </div>
    </div>
    <div>
        <div class="leftLabel">

        </div>
        <div class="dataUser">
            <button onclick="window.history.back();" class="button control_button cancel_button">Отменить</button>
            <button onclick="save()" class="button control_button ok_button">Добавить</button>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/inputs.css">
<link rel="stylesheet" type="text/css" href="/css/buttons.css">
<link rel="stylesheet" type="text/css" href="/css/titles.css">
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/addUniversity.js"></script>
