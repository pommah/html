<link rel="stylesheet" type="text/css" href="/css/student_list.css">
<table id="table" class='studentList'>
    <tr>
        <th>Округ</th>
        <th>Число регионов</th>
    </tr>
    <?php
    foreach ($data['districts'] as $district){
        printf("<tr id='%s' onclick='districtClick(this)'>", $district['ID']);
        printf("<td>%s</td>", $district['Name']);
        printf("<td>%s</td></tr>", $district['count']);
    }
    ?>
</table>
<script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/universitiesNavigation.js"></script>

