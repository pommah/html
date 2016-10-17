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
    del = new Ajax("POST","/student/delete");
    del.setData("id="+id);
    del.send(function (data) {
        if(data == "OK") {
            th.parentNode.removeChild(th);
        }
        else {
            document.getElementById('error').innerHTML = data;
        }
    });
}