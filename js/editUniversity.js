function saveChanges() {
    var short = document.getElementById('short');
    var full = document.getElementById('full');
    var region = document.getElementById('region');
    var status = document.getElementById('status');

    var dataShort = short.value;
    var dataFull = full.value;
    var dataRegion = region.selectedOptions[0].id;
    var dataStatus = status.selectedOptions[0].value;

    var regularShort = /^[А-яA-z ]{3,30}$/;
    var regularFull = /^[А-яA-z ]{3,60}$/;
    var regularRegion = /^[0-9]{1,2}$/;
    var regularStatus = /^(Государственный)|(Частный)$/;

    if(!regularShort.test(dataShort)){
        alert("Недопустимое краткое наименование");
        return false;
    }
    if(!regularFull.test(dataFull)){
        alert("Недопустимое полное наименование");
        return false;
    }
    if(!regularRegion.test(dataRegion)){
        alert("Недопустимый регион");
        return false;
    }
    if(!regularStatus.test(dataStatus)){
        alert("Недопустимый статус");
        return false;
    }

    var send = new Ajax("POST","/university/edit");
    send.setData("universityData="+dataShort+";"+dataFull+";"+dataStatus+";"+dataRegion);
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

function cancel() {
    window.history.back();
}
