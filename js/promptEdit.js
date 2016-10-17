/**
 * Created by vladislav on 12.10.16.
 */
onload = function () {
    widthTable = document.getElementById('trackTable').offsetWidth;
    document.getElementById('promt').style.width = (widthTable-30)+"px";
}
var numModule = null;
var nowInfo = null;
var nowStatus = null;
function prompEdit(num, status, text) {
    numModule = num;
    nowStatus = status;
    prom = document.getElementById('promt');
    //prom.style.backgroundColor = "#ffffff";
    //prom.style.border = "1px solid #8e8e8e";
    var info = '';
    info = getDebt(text);
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>" +
        "<div>"+getStatus(status)+" <button class='button' onclick='addDebt()'>Добавить долг</button></div>" +
        "<div id='addSubject'>"+info+"</div>" +
        "<button class='button saveTrajectory'>Сохранить</button> </div>";
}

function getStatus(status) {
    var allStatus = ["Активен","Задолженность","Закончен"];
    select = "<select id='changeStatus' onchange='setStatus(this.value)' class='input'>";
    allStatus.forEach(function (item, i, arr) {
        if(item==status) selected="selected";
        else selected = null;
        select+= "<option "+selected+" value='"+item+"'>"+item+"</option>";
    });
    select+="</select>";
    return select;
}

function getDebt(text) {
    text = text.split(" ");
    var info = '';
    var name = new Array();
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            name = text[i].split("=");
            info += "<div class='attr'><input type='text' class='input subject' placeholder='Укажите задолженность' value='"+name[0]+"'><br><input type='date' placeholder='Укажите дату последней сдачи' class='input deadLine' value='"+name[1]+"'></div>";
        }
    }
    nowInfo = info;
    return info;
}

function addDebt() {
    if(nowStatus == 'Задолженность') {
        info = nowInfo;
        info += "<div class='attr'><input type='text' class='input subject' placeholder='Укажите задолженность'><br><input type='date' placeholder='Укажите дату последней сдачи' class='input deadLine'></div>"
        document.getElementById("addSubject").innerHTML = info;
        nowInfo = info;
    }
}

function setStatus(status) {
    nowStatus = status;
    if(status == 'Активен' || status=='Закончен') {
        document.getElementById('addSubject').innerHTML = '';
    }
    else {
        if(nowInfo)
            document.getElementById('addSubject').innerHTML = nowInfo;
        else
            addDebt();
    }
}