<link rel="stylesheet" type="text/css" href="/css/tables.css">
<table class="studentList">
    <tr>
        <th>Имя</th>
        <th>Уровень доступа</th>
        <th>Логин</th>
        <th>E-mail</th>
        <th>Университет</th>
        <th width="70"></th>
    </tr>
    <?php
        foreach ($data['users'] as $user){
            printf("<tr onclick='document.location.href=\"/user/info/%s\"'><td>%s</td>", $user['ID'], $user['Name']);
            printf("<td>%s</td>", UserTypes::ARRAY[$user['Permission']]);
            printf("<td>%s</td>", $user['Login']);
            printf("<td>%s</td>", $user['Email']);
            printf("<td>%s</td>", $user['Univer']);
            printf("<td><img src='/images/delete_file.png'  width='20' onclick='deleteUser(%s,event)'>
                    <img src='/images/edit_file.png' width='20' onclick='event.stopPropagation(); window.location.href=\"/user/edit/%s\"'>
                    </td>", $user['ID'], $user['ID']);
            print ("</tr>");
        }
    ?>
</table>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/deleteUser.js"></script>
