function save() {
    var fullName = document.getElementById("fullName");
    var shortName = document.getElementById("shortName");
    var status = document.getElementById("status");
    var region = document.getElementById("region");

    var dataFull = fullName.value;
    var dataShort = shortName.value;
    var dataRegion = region.selectedOptions[0].id;
    var dataStatus = status.value;

    var regularFull = /^[А-яA-z -]{3,60}$/;
    var regularRegion = /^[0-9]{2}$/;
    var regularShort = /^[А-я]{3,30}$/;
    var regularStatus = /^[А-я]{3,30}$/;

    if(!regularFull.test(dataFull)){
        alert("Недопустимое полное наименование");
        return false;
    }
    if(!regularRegion.test(dataRegion)){
        alert("Недопустимый регион");
        return false;
    }
    if(!regularShort.test(dataShort)){
        alert("Недопустимое краткое наименование");
        return false;
    }
    if(!regularStatus.test(dataStatus)){
        alert("Недопустимый статус");
        return false;
    }

    var data = "data="+dataFull+";"+dataShort+";"+dataStatus+";"+dataRegion;

    var send = new Ajax("POST","/university/add");
    send.setData(data);
    send.send(function (data) {
        status = data;
        if(status=="OK") {
            document.location.href = "/university";
        }
        else {
            alert(status);
        }
    });
}