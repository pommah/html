function parseAndSendData() {
    var name = document.getElementById('name');
    var email = document.getElementById('email');

    var send = new Ajax("POST");
    send.setData("userdata="+name.value+";"+email.value);
    send.send("/user/edit");
    send.xhttp.onreadystatechange = function () {
        if(send.xhttp.readyState == 4 && send.xhttp.status == 200) {
            status = send.xhttp.responseText;
            if(status=="OK") {
                document.location.href = "/user/info";
            }
            else {
                alert(status);
            }
        }
    }
}
