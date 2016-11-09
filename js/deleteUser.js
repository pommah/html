/**
 * Created by vladislav on 09.11.16.
 */
function deleteUser(id) {
    event.stopPropagation();
    conf = confirm("Вы уверены, что хотите удалить этого пользователя?");
    var ajax = new Ajax("POST","/user/delete");
    ajax.setData("id="+id);
    ajax.send(function (data) {
        if(data=='OK') {
            location.reload();
        }
        else {
            alert(data);
        }
    })
}
