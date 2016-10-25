onload = function () {
    document.getElementById('login').focus();
}

function checkAuth() {
    var login = document.getElementById('login');
    var password = document.getElementById('password');
    var error = document.getElementById('error_line');
    var regularLogin = /^[a-zA-Z][a-zA-Z0-9-_\.]{3,25}$/;
    var regularPassword =/^[А-яA-z0-9-_\.]{5,30}$/;

    error.innerHTML = "";
    if(login.value.length < 3) {
        error.innerHTML = 'Логин не может быть короче 4 символов';
        login.focus();
        return false;
    }
    if(password.value.length < 5) {
        error.innerHTML = 'Пароль не может быть короче 6 символов';
        password.focus();
        return false;
    }
    if(!regularLogin.test(login.value)) {
        login.focus();
        error.innerHTML = "Некорректный логин";
        return false;
    }
    if(!regularPassword.test(password.value)) {
        error.innerHTML = "Некорректный пароль";
        password.focus();
        return false;
    }

   var send = new Ajax("POST","/modules/authorize.php");
    send.setData("login="+login.value+"&password="+password.value);
    send.send(function (data) {
        status = data;
        if(status=="OK") {
            document.location.reload();
        }
        else {
            error.innerHTML = status;
            login.focus();
        }
    });

}
