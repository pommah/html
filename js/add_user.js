/**
 * Created by vladislav on 02.11.16.
 */
var Universitys = new Array();
function changePermission(type) {
    type = type.value;
    addon = document.getElementById('addon');
    if(type==2) {
        if(Universitys.length==0)
            loadUniversity();
        else {
            showUniversity();
        }
    }
    else {
        addon.innerHTML = '';
    }
}

function loadUniversity() {
    var ajax = new Ajax("POST","/user/get_universities");
    ajax.send(function (data) {
        Universitys = JSON.parse(data);
        showUniversity();
    })
}

function showUniversity() {
    addon = document.getElementById('addon');
    text = "<div class='leftLabel'>Укажите ВУЗ:</div> <div class='dataUser'><select id='university' class='input addInput'>";
    for(i=0; i<Universitys.length; i++) {
        shortName = Universitys[i].ShortName;
        if(shortName==null) shortName='';
        else shortName+=". ";
        text += "<option value='"+Universitys[i].ID+"'>"+shortName+Universitys[i].FullName+"</option>";
    }
    text+="</select></div>";
    addon.innerHTML = text;
}

function addUser() {
    var name = document.getElementById('name');
    var login = document.getElementById('login');
    var password = document.getElementById('password');
    var confirmPassword = document.getElementById('confirmPassword');
    var email = document.getElementById('email');
    var permission = document.getElementById('permission');

    var regularName = /^[a-zA-Zа-яА-Я\s]+$/;
    var regularLogin = /^[a-zA-Z][a-zA-Z0-9-_\.]{3,25}$/;
    var regularPassword =/^[А-яA-z0-9-_\.]{5,30}$/;
    var regularEmail = /^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;
    var regularPerm = /^[1-9]{1,2}$/;

    error = document.getElementById('error');
    if(name.value.length < 2) {
        error.innerHTML = 'Имя не может быть короче 2 символов';
        name.focus();
        return false;
    }
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
    if(password.value != confirmPassword.value) {
        error.innerHTML = 'Пароли не совпадают';
        password.value='';
        confirmPassword.value='';
        password.focus();
        return false;
    }
    if(!regularLogin.test(login.value)) {
        login.focus();
        error.innerHTML = "Некорректный логин";
        return false;
    }
    if(!regularName.test(name.value)) {
        name.focus();
        error.innerHTML = "Некорректное имя";
        return false;
    }
    if(!regularPassword.test(password.value)) {
        error.innerHTML = "Некорректный пароль";
        password.focus();
        return false;
    }
    if(email.value.length < 6) {
        error.innerHTML = 'Слишком короткий email';
        email.focus();
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
    if(!regularEmail.test(email.value)) {
        email.focus();
        error.innerHTML = "Некорректный адрес электронной почты";
        return false;
    }
    if(!regularPerm.test(permission.value)) {
        permission.focus();
        error.innerHTML = "Неверный уровень доступа";
        return false;
    }

    var data = "name="+name.value+"&login="+login.value+"&password="+password.value+"&email="+email.value+"&permission="+permission.value;
    if(permission.value==2) {
        var university = document.getElementById('university');
        data+="&university="+university.value;
    }

    var ajax = new Ajax("POST", "/user/add_user");
    ajax.setData(data);
    ajax.send(function (data) {
        if(data=="OK") {
            location.href="/user";
        }
        else {
            alert(data);
        }
    })
}