function districtClick(row) {
    data = "getRegions="+row.id;
    var send = new Ajax("POST","/university/index");
    send.setData(data);
    send.send(function (data) {
        if(status!="Error") {
            loadRegions(data);
        }
        else {
            alert(status);
        }
    });
}

function loadRegions(data) {
    var rows = JSON.parse(data);
    var table = document.getElementById('table');
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }

    var header = document.createElement('tr');
    var c1 = document.createElement('th');
    c1.innerText = 'Регион';
    header.appendChild(c1);
    var c2 = document.createElement('th');
    c2.innerText = 'Количество университетов';
    header.appendChild(c2);
    table.appendChild(header);

    rows.forEach(function (values) {
        var row =  document.createElement('tr');
        row.id = values.ID;
        row.onclick = function () {
            regionClick(row);
        };
        var col1 = document.createElement('td');
        col1.innerText = values.Name;
        row.appendChild(col1);
        var col2 = document.createElement('td');
        col2.innerText = values.count;
        row.appendChild(col2);
        table.appendChild(row);
    });
}

function regionClick(row) {
    data = "getUnivers="+row.id;
    var send = new Ajax("POST","/university/index");
    send.setData(data);
    send.send(function (data) {
        if(status!="Error") {
            loadUniversities(data);
        }
        else {
            alert(status);
        }
    });
}

function loadUniversities(data) {
    var rows = JSON.parse(data);
    var table = document.getElementById('table');
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }

    var header = document.createElement('tr');
    var c1 = document.createElement('th');
    c1.innerText = 'Название ВУЗа';
    header.appendChild(c1);
    var c2 = document.createElement('th');
    c2.innerText = 'Число студентов';
    header.appendChild(c2);
    table.appendChild(header);

    rows.forEach(function (values) {
        var row =  document.createElement('tr');
        row.id = values.ID;
        row.onclick = function () {
            universityClick(row);
        };
        var col1 = document.createElement('td');
        col1.innerText = values.FullName;
        row.appendChild(col1);
        var col2 = document.createElement('td');
        col2.innerText = values.count;
        row.appendChild(col2);
        table.appendChild(row);
    });
}

function universityClick(row) {
    data = "universityId="+row.id;
    var send = new Ajax("POST","/student/index");
    send.setData(data);
    send.send(function (data) {
        if(true) {
            document.location.href = "/student";
        }
        else {
            alert(status);
        }
    });
}
