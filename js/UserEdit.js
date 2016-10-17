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

    var send = new Ajax("POST","/user/edit");
    send.setData("userdata="+name.value+";"+email.value);
    send.send(function (data) {
        status = data;
        if(status=="OK") {
            document.location.href = "/user/info";
        }
        else {
            alert(status);
        }
    });
}
