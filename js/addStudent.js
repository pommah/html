function save() {
    var id = document.getElementById('fio');
    var noz = document.getElementById('noz_group');
    var dateBegin = document.getElementById('begin');
    var dateEnd = document.getElementById('end');
    var fileReability = document.getElementById('fileNameReability');

    var dataId = id.value;
    var dataNoz = noz.selectedOptions[0].id.substr(1);
    var dataDateBegin = dateBegin.value.split("-").join(".");
    var dataDateEnd = dateEnd.value.split("-").join(".");
    var dataFileReability = 'c.pdf';

    var regularId = /^[А-яA-z ]{3,50}$/;
    var regularNoz = /^[0-9]$/;
    var regularDate = /^[0-9]{2,4}.[0-9]{1,2}.[0-9]{1,2}$/;

    if (!regularId.test(dataId)){
        alert("Недопустимый идентификатор");
        return false;
    }
    if (!regularNoz.test(dataNoz)){
        alert("Недопустимая нозологическая группа");
        return false;
    }
    if (!regularDate.test(dataDateBegin)){
        alert("Недопустимая дата начала обучения");
        return false;
    }
    if (!regularDate.test(dataDateEnd)){
        alert("Недопустимая дата окончания обучения");
        return false;
    }

    dataFileReability = document.getElementById('fileNameReability').disabled ? null : dataFileReability;

    var data;

    if (document.getElementById('radio_exist').checked){
        var program = document.getElementById('program');
        var dataProgram = program.selectedOptions[0].id.substr(1);
        var regularProgram = /^[0-9]{1,4}$/;
        if (!regularProgram.test(dataProgram)){
            alert("Недопустимая программа");
            return false;
        }
        data = "student="+dataId+";"+dataNoz+";"+dataDateBegin+";"+dataDateEnd+";"+dataFileReability+";"+dataProgram;
    }
    else if (document.getElementById('radio_new').checked){
        var direction = document.getElementById('direction');
        var level = document.getElementById('level');
        var period = document.getElementById('period');
        var form = document.getElementById('form');
        var fileProgram = document.getElementById('fileNameProgram');
        var profile = document.getElementById('profile');
        var filePlan = document.getElementById('fileNamePlan');

        var dataDirection = direction.selectedOptions[0].id;
        var dataLevel = level.selectedOptions[0].value;
        var dataPeriod = period.value;
        var dataForm = form.selectedOptions[0].value;
        var dataFileProgram = 'a.pdf';
        var dataProfile = profile.value;
        var dataFilePlan = 'b.pdf';

        var regularDirection = /^[0-9]{6}$/;
        var regularLevel = /^[А-я]{6,40}$/;
        var regularPeriod = /^[0-9].*[0-9]$/;
        var regularForm = /^[А-я-]{5,60}$/;
        var regularProfile = /^[А-я ]{3,100}$/;

        if (!regularDirection.test(dataDirection)){
            alert("Недопустимое направление");
            return false;
        }
        if (!regularLevel.test(dataLevel)){
            alert("Недопустимый уровень образования");
            return false;
        }
        if (!regularPeriod.test(dataPeriod)){
            alert("Недопустимый период обучения");
            return false;
        }
        if (!regularForm.test(dataForm)){
            alert("Недопустимая форма обучения");
            return false;
        }
        if (!document.getElementById('profile').disabled){
            if (!regularProfile.test(dataProfile)){
                alert("Недопустимый профиль");
                return false;
            }
        }
        else {
            dataProfile = null;
        }

        dataFilePlan = document.getElementById('fileNamePlan').disabled ? null : dataFilePlan;

        data = "student_and_program="+dataId+";"+dataNoz+";"+dataDateBegin+";"+dataDateEnd+";"+dataFileReability+";"+dataDirection+";"+dataProfile+";"+dataLevel+";"+dataPeriod+";"+dataForm+";"+dataFileProgram+";"+dataFilePlan;
    }

    var send = new Ajax("POST","/student/add");
    send.setData(data);
    send.send(function (data) {
        status = data;
        if(status=="OK") {
            document.location.href = "/student";
        }
        else {
            alert(status);
        }
    });
}

function radioClicks($radio) {
    if ($radio.id === 'radio_exist'){
        document.getElementById('div_exist').style.display = "block";
        document.getElementById('div_new').style.display = "none";
    }else if($radio.id === 'radio_new') {
        document.getElementById('div_exist').style.display = "none";
        document.getElementById('div_new').style.display = "block";
    }
}

function switchProfile(checkbox) {
    document.getElementById('profile').disabled = !checkbox.checked;
}

function switchFilePlan(checkbox) {
    document.getElementById('fileNamePlan').disabled = !checkbox.checked;
}

function switchFileReability(checkbox) {
    document.getElementById('fileNameReability').disabled = !checkbox.checked;
}

function cancel() {
    window.history.back();
}

onload = function(){
    document.getElementById('radio_exist').checked = true;
    document.getElementById('direction').options[0].selected = true;
}