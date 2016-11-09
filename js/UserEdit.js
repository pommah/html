function parseAndSendData() {
    var name = document.getElementById('name');
    var email = document.getElementById('email');
    var lPassword = document.getElementById('lastPassword');
    var nPassword = document.getElementById('newPassword');
    var error = document.getElementById('error');
    var login = document.getElementById('login').innerHTML;

    var passwords = '';

    var regularName = /^[А-яA-z ]{3,50}$/;
    var regularEmail = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    var regularPassword =/^[А-яA-z0-9-_\.]{5,30}$/;

    if (!regularName.test(name.value)){
        alert(name.value);
        return false;
    }

    if (!regularEmail.test(email.value)){
        alert(email.value);
        return false;
    }
    if(nPassword.value.length>0) {
        if(lPassword.value.length<1) {
            nPassword.value = '';
            lPassword.value = '';
            lPassword.focus();
            error.innerHTML = 'Укажите прошлый пароль';
            return false;
        }
        if(!regularPassword.test(nPassword.value)) {
            nPassword.value = '';
            nPassword.focus();
            error.innerHTML = 'Некорректный новый пароль';
            return false;
        }
        passwords = ";"+lPassword.value+";"+nPassword.value;
    }

    var send = new Ajax("POST","/user/edit");
    send.setData("userdata="+name.value+";"+email.value+";"+login+passwords);
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
