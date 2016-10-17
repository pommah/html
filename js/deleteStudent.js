/**
 * Created by vladislav on 16.10.16.
 */
function deleteStud(e, id) {
    e.stopPropagation();
    th = document.getElementById('student_'+id);
    conf = confirm("Вы уверены, что хотите удалить этого студента?");
    if(!conf) {
        return;
    }
    del = new Ajax("POST");
    del.setData("id="+id);
    del.send("/student/delete");
    del.xhttp.onreadystatechange = function () {
        if(del.xhttp.readyState == 4 && del.xhttp.status == 200) {
            if(del.xhttp.responseText == "OK") {
                th.parentNode.removeChild(th);
            }
            else {
                document.getElementById('error').innerHTML = del.xhttp.responseText;
            }
        }
    }
}