function save() {
    var id = document.getElementById('fio');
    var noz = document.getElementById('noz_group');
    var dateBegin = document.getElementById('begin');
    var dateEnd = document.getElementById('end');

    var dataId = id.value;
    var dataNoz = noz.selectedOptions[0].id.substr(1);
    var dataDateBegin = dateBegin.value.split("-").join(".");
    var dataDateEnd = dateEnd.value.split("-").join(".");

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

    var data;

    if (document.getElementById('radio_exist').checked){
        var program = document.getElementById('program');
        var dataProgram = program.selectedOptions[0].id.substr(1);
        var regularProgram = /^[0-9]{1,4}$/;
        if (!regularProgram.test(dataProgram)){
            alert("Недопустимая программа");
            return false;
        }
        data = "student="+dataId+";"+dataNoz+";"+dataDateBegin+";"+dataDateEnd+";"+dataProgram;
    }
    else if (document.getElementById('radio_new').checked){
        var direction = document.getElementById('direction');
        var level = document.getElementById('level');
        var period = document.getElementById('period');
        var form = document.getElementById('form');
        var fileName = document.getElementById('fileName');

        var dataDirection = direction.selectedOptions[0].id;
        var dataLevel = level.value;
        var dataPeriod = period.value;
        var dataForm = form.value;
        var dataFileName = 'a.pdf';

        var regularDirection = /^[0-9]{6}$/;
        var regularLevel = /^[А-я]{6,40}$/;
        var regularPeriod = /^[0-9].*[0-9]$/;
        var regularForm = /^[А-я]{6,60}$/;

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

        data = "student_and_program="+dataId+";"+dataNoz+";"+dataDateBegin+";"+dataDateEnd+";"+dataDirection+";"+dataLevel+";"+dataPeriod+";"+dataForm+";"+dataFileName;
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

onload = function(){
    document.getElementById('radio_exist').checked = true;
    document.getElementById('direction').options[0].selected = true;
}