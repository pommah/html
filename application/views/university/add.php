<div class="AddHead">Добавление ВУЗа</div>
<div class="blockInput">
    <div>
        <div class="leftLabel">
            Регион:
        </div>
        <div class="dataUser">
            <select id="region" class="input addInput">
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
            <input type="text" id="fullName" class="input addInput" size="41" placeholder="Укажите полное наименование">
        </div>
    </div>
    <div>
        <div class="leftLabel">
            Краткое наименование:
        </div>
        <div class="dataUser">
            <input type="text" id="shortName" class="input addInput" size="41" placeholder="Укажите краткое наименование">
        </div>
    </div>
    <div>
        <div class="leftLabel">
            Статус:
        </div>
        <div class="dataUser">
            <select id="status" class="input addInput">
                <option>Государственный</option>
                <option>Частный</option>
            </select>
        </div>
    </div>
    <button style="margin-top: 20px" onclick="window.history.back();" class="button addInput">Отменить</button>
    <button style="margin-top: 20px" onclick="save()" class="button addInput">Добавить</button>
</div>
<link rel="stylesheet" type="text/css" href="/css/add_user.css">
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/addUniversity.js"></script>
