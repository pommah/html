function save() {
    var id = document.getElementById('fio');
    var noz = document.getElementById('noz_group');
    var dateBegin = document.getElementById('begin');
    var dateEnd = document.getElementById('end');

    var dataId = id.value;
    var dataNoz = noz.selectedOptions[0].id.substr(1);
    var dataDateBegin = dateBegin.value.split("-").join(".");
    var dataDateEnd = dateEnd.value.split("-").join(".");
    var data;

    if (document.getElementById('radio_exist').checked){
        var program = document.getElementById('program');
        var dataProgram = program.selectedOptions[0].id.substr(1);
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

        data = "student_and_program="+dataId+";"+dataNoz+";"+dataDateBegin+";"+dataDateEnd+";"+dataDirection+";"+dataLevel+";"+dataPeriod+";"+dataForm+";"+dataFileName;
    }

    var send = new Ajax("POST");

    send.setData(data);
    send.send("/student/add");
    send.xhttp.onreadystatechange = function () {
        if(send.xhttp.readyState == 4 && send.xhttp.status == 200) {
            status = send.xhttp.responseText;
            if(status=="OK") {
                document.location.href = "/student";
            }
            else {
                alert(status);
            }
        }
    }
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