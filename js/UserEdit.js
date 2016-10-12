function parseAndSendData() {
    var name = document.getElementById('name');
    var email = document.getElementById('email');

    var regularName = /^[А-яA-z ]{3,50}$/;
    var regularEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (!regularName.test(name.value)){
        alert(name.value);
        return false;
    }

    if (!regularEmail.test(email.value)){
        alert(email.value);
        return false;
    }

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
