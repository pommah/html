/**
 * Created by vladislav on 12.10.16.
 */
onload = function () {
    widthTable = document.getElementById('trackTable').offsetWidth;
    document.getElementById('promt').style.width = (widthTable-30)+"px";
    document.getElementById('current_info').click();
}

function radioClicks(radio) {
    hideAllDivs();
    if (radio.id == "current_info"){
        document.getElementById('div_current_info').style.display = "block";
    }else if (radio.id == "current_edit"){
        document.getElementById('div_current_edit').style.display = "block";
    } else if (radio.id == "current_change"){
        document.getElementById('div_current_change').style.display = "block";
    } else if (radio.id == "add_new"){
        document.getElementById('div_add_new').style.display = "block";
    }
}

function hideAllDivs() {
    document.getElementById('div_current_info').style.display = "none";
    document.getElementById('div_current_edit').style.display = "none";
    document.getElementById('div_current_change').style.display = "none";
    document.getElementById('div_add_new').style.display = "none";
}
var numModule = null;
var nowInfo = null;
var nowStatus = null;
var debtArr = new Array();
function prompEdit(num, status, text) {
    debtArr = [];
    numModule = num;
    nowStatus = status;
    prom = document.getElementById('promt');
    //prom.style.backgroundColor = "#ffffff";
    //prom.style.border = "1px solid #8e8e8e";
    var info = '';
    parseDebt(text);
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>" +
        "<div>"+getStatus(status)+" <button class='button' onclick='addDebt(true)'>Добавить долг</button></div>" +
        "<div id='addSubject'></div>" +
            "<div class='fileTrack'><input type='file' id='fileTrack'></div>" +
        "<button class='button saveTrajectory'>Сохранить</button> </div>";
    showDebt();
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

function parseDebt(text) {
    text = text.split(" ");
    var name = new Array();
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            name = text[i].split("=");
            debtArr.push({name: name[0], date: name[1]});
        }
    }
}

function addDebt(show) {
    if(nowStatus == 'Задолженность') {
        debtArr.push({name: '', date: ''});
    }
    if(show)
        showDebt();
}
function showDebt() {
    info = '';
    for(var i=0; i<debtArr.length; i++) {
        info += "<div class='attr' id='attr_"+i+"'><input type='text' class='input subject' placeholder='Укажите задолженность' value='"+debtArr[i]['name']+"'><span class='delDebt' onclick='delDebt("+i+")'>Удалить</span><br><input type='date' placeholder='Укажите дату последней сдачи' class='input deadLine' value='"+debtArr[i]['date']+"'></div>";
    }
    nowInfo = info;
    document.getElementById('addSubject').innerHTML = info;
}

function setStatus(status) {
    nowStatus = status;
    if(status == 'Активен' || status=='Закончен') {
        document.getElementById('addSubject').innerHTML = '';
    }
    else {
        if(nowInfo)
            showDebt();
        else
            addDebt();
            showDebt();
    }
}

function delDebt(i) {
    elem = document.getElementById('attr_'+i);
    elem.parentNode.removeChild(elem);
    debtArr.splice(i,1);
}

function saveTrack() {
    var status = nowStatus;
    var module = numModule;
    var debts = '';
    if(status=='Задолженность') {
        elems = document.getElementsByClassName('attr');
        for(var i=0; i<elems.length; i++) {

        }
    }
}