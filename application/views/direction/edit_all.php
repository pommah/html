<div class="content">
    <div class="center">
        <table class="directionsEditor">
            <?php
            foreach ($data['all_directions'] as $ugsn){
                print ("<tr>");
                printf ("<td colspan='3'>%s</td>", $ugsn['ugsnName']);
                foreach ($ugsn['listDir'] as $dirId => $dirName){
                    printf ("<tr onclick='toogleCheckbox(event)'>");
                    $checked = in_array($dirId, $data['directions'])?"checked":"";
                    printf("<td><input id='%s' type='checkbox' %s></td>", $dirId, $checked);
                    printf("<td>%s.%s.%s</td>", substr($dirId, 0, 2),substr($dirId, 2, 2),substr($dirId, 4, 2));
                    printf("<td>%s</td>", $dirName);
                    print ("</tr>");
                }
                print ("</tr>");
            }
            ?>
        </table>
        <div class="buttonHolder">
            <button class="button directionsEditor" onclick="saveChanges()">Сохранить</button>
            <button class="button directionsEditor" onclick="cancelChanges()">Отменить</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/directionEditor.js"></script>
<script type="text/javascript" src="/js/ajax.js"></script>
<link rel="stylesheet" type="text/css" href="/css/directions_editor.css">