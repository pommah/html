<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table class="studentList">
    <tr>
        <th>Имя</th>
        <th>Уровень доступа</th>
        <th>Логин</th>
        <th>E-mail</th>
        <th>Университет</th>
    </tr>
    <?php
        foreach ($data['users'] as $user){
            printf("<tr onclick='document.location.href=\"/user/info/%s\"'><td>%s</td>", $user['ID'], $user['Name']);
            printf("<td>%s</td>", $user['Permission']);
            printf("<td>%s</td>", $user['Login']);
            printf("<td>%s</td>", $user['Email']);
            printf("<td>%s</td></tr>", $user['Univer']);
        }
    ?>
</table>