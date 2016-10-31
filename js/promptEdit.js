/**
 * Created by vladislav on 12.10.16.
 */
onload = function () {
    widthTable = document.getElementById('trackTable').offsetWidth;
    document.getElementById('promt').style.width = (widthTable-30)+"px";
    document.getElementById('current_info').click();
    document.getElementById('an_direction').options[0].selected = true;
}

function saveStudentChanges(){

    var name = document.getElementById('name');
    var nozology = document.getElementById('noz_group');
    var dateBegin = document.getElementById('dateBegin');
    var dateEnd = document.getElementById('dateEnd');
    var rehabilitation = document.getElementById('fileNameReability');

    var dataName = name.value;
    var dataNozology = nozology.selectedOptions[0].id.substr(1);
    var dataDateBegin = dateBegin.value.split("-").join(".");
    var dataDateEnd = dateEnd.value.split("-").join(".");
    var dataRehabilitation = 'c.pdf';

    var regularId = /^[А-яA-z ]{3,50}$/;
    var regularNoz = /^[0-9]$/;
    var regularDate = /^[0-9]{2,4}.[0-9]{1,2}.[0-9]{1,2}$/;

    if (!regularId.test(dataName)){
        alert("Недопустимый идентификатор");
        return false;
    }
    if (!regularNoz.test(dataNozology)){
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

    dataRehabilitation = document.getElementById('fileNameReability').disabled ? null : dataRehabilitation;

    var data = dataName+";"+dataNozology+";"+dataDateBegin+";"+dataDateEnd+";"+dataRehabilitation;


    var radioCurrentInfo = document.getElementById('current_info');
    var radioCurrentEdit = document.getElementById('current_edit');
    var radioCurrentChange = document.getElementById('current_change');
    var radioAddNew = document.getElementById('add_new');
    if (radioCurrentInfo.checked){
        data = "currInfo=" + data;
    } else if (radioCurrentEdit.checked){
        var result = saveCurrentEdit();
        if (!result) return;
        data = "currEdit=" + data +result;
    } else if (radioCurrentChange.checked){
        var result = saveCurrentChange();
        if (!result) return;
        data = "currChange=" + data +result;
    } else if (radioAddNew.checked){
        var result = saveAddNew();
        if (!result) return;
        data = "saveNew=" + data + result;
    }

    var send = new Ajax("POST",document.location.href);
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

function saveCurrentEdit() {
    var id = document.getElementById("programId").innerText;
    return parseProgramData('ce_')+";"+id;
}

function saveCurrentChange() {
    var program = document.getElementById("program").selectedOptions[0].id.substr(1);
    var reason = document.getElementById("cc_reason").value;

    var regularProgram = /^[0-9]{1,4}$/;
    var regularReason = /^[А-яA-z ]{3,50}$/;

    if (!regularProgram.test(program)){
        alert("Недопустимая программа");
        return false;
    }

    if (!regularReason.test(reason)){
        alert("Недопустимая причина изменения");
        return false;
    }

    return ";"+program+";"+reason;
}

function saveAddNew() {
    var reason = document.getElementById("an_reason").value;
    var regularReason = /^[А-яA-z ]{3,50}$/;
    if (!regularReason.test(reason)){
        alert("Недопустимая причина изменения");
        return false;
    }

    var result = parseProgramData('an_');
    if (!result) return false;
    return result+";"+reason;
}

function parseProgramData(prefix) {
    var direction = document.getElementById(prefix+'direction');
    var profile = document.getElementById(prefix+'profile');
    var level = document.getElementById(prefix+'level');
    var period = document.getElementById(prefix+'period');
    var form = document.getElementById(prefix+'form');
    var program = document.getElementById(prefix+'fileNameProgram');
    var plan = document.getElementById(prefix+'fileNamePlan');

    var dataDirection = direction.selectedOptions[0].id;
    var dataProfile = profile.value;
    var dataLevel = level.selectedOptions[0].value;
    var dataPeriod = period.value;
    var dataForm = form.selectedOptions[0].value;
    var dataProgram = 'a.pdf';
    var dataPlan = 'b.pdf';

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
    if (!document.getElementById(prefix+'profile').disabled){
        if (!regularProfile.test(dataProfile)){
            alert("Недопустимый профиль");
            return false;
        }
    }
    else {
        dataProfile = null;
    }
    dataPlan = document.getElementById(prefix+'fileNamePlan').disabled ? null : dataPlan;

    return ";"+dataDirection+";"+dataProfile+";"+dataLevel+";"+dataPeriod+";"+dataForm+";"+dataProgram+";"+dataPlan+";"+dataRehabilitation;
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

function switchByCheckbox(checked, switchingId) {
    document.getElementById(switchingId).disabled = !checked;
}

var numModule = null;
var nowInfo = null;
var nowAdapt = null;
var nowStatus = null;
var debtArr = new Array();
var adaptArr = new Array();
var idModule = null;
function prompEdit(id, num, status, text, file, adaptive) {
    idModule = id;
    debtArr = [];
    adaptArr = [];
    numModule = num;
    nowStatus = status;
    prom = document.getElementById('promt');
    //prom.style.backgroundColor = "#ffffff";
    //prom.style.border = "1px solid #8e8e8e";
    var info = '';
    parseDebt(text);
    parseAdaptive(adaptive);
    var nowFile = '';
    if(file) nowFile = "<a href='/orders/"+file+"'>Прикрепленный файл</a>";
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>" +
        "<div id='status_line'>"+getStatus(status)+" <button class='button' id='change_status_module' onclick='addDebt(true)'>Добавить долг</button></div>" +
        "<div id='addSubject'></div>" +
            "<div id='adaptiveDisc'></div>"+
            "<div class='fileTrack href'>" + nowFile +
        "<input type='file' id='fileTrack'></div>" +
        "<button class='button saveTrajectory' onclick='saveTrack()'>Сохранить</button> </div>";
    showDebt();
    showAdaptive();
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
function parseAdaptive(text) {
    text = text.split(";");
    var name = new Array();
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            adaptArr.push(text[i]);
        }
    }
}
function parseDebt(text) {
    text = text.split("&");
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
function showAdaptive() {
    info = '';
    if(adaptArr) info+= 'Адаптивные дисциплины:';
    for(var i=0; i<adaptArr.length; i++) {
        info += "<div class='adapt' id='adapt_"+i+"'>" +
            "<input type='text' id='adaptVal_"+i+"' class='input subject' placeholder='Укажите адаптивную дисциплину' value='"+adaptArr[i]+"'><span class='delDebt'  onclick='delAdaptive("+i+")'>Удалить</span><br></div>";
    }
    nowAdapt = info;
    document.getElementById('adaptiveDisc').innerHTML = info;
}
function showDebt() {
    info = '';
    for(var i=0; i<debtArr.length; i++) {
        info += "<div class='attr' id='attr_"+i+"'><input type='text' id='debt_"+i+"' class='input subject' placeholder='Укажите задолженность' value='"+debtArr[i]['name']+"'><span class='delDebt'  onclick='delDebt("+i+")'>Удалить</span><br><input type='date' id='date_"+i+"' placeholder='Укажите дату последней сдачи' class='input deadLine' value='"+debtArr[i]['date']+"'></div>";
    }
    nowInfo = info;
    document.getElementById('addSubject').innerHTML = info;
}

function setStatus(status) {
    nowStatus = status;
    button = "<button class='button' id='change_status_module' onclick='addDebt(true)'>Добавить долг</button>";
    statusLine = document.getElementById('status_line');
    if(status == 'Активен' || status=='Закончен') {
        document.getElementById('addSubject').innerHTML = '';
        statusLine.innerHTML = getStatus(status);

    }
    else {
        if(nowInfo)
            showDebt();
        else
            addDebt(true);
        statusLine.innerHTML = getStatus(status)+" "+button;
    }
}

function delDebt(i) {
    elem = document.getElementById('attr_'+i);
    elem.parentNode.removeChild(elem);
    debtArr.splice(i,1);
}

function addModule() {
    var ajax = new Ajax("POST","/student/add_debt");
    ajax.setData("id="+learnID);
    ajax.send(function (data) {
        if (data == "OK") {
            alert('Изменения применены');
            location.reload();
        }
        else {
            alert(data);
        }
    })
}

function cancel() {
    window.history.back();
}

function saveTrack() {
    var status = nowStatus;
    var module = numModule;
    var debts = '';
    if(status=='Задолженность') {
        elems = document.getElementsByClassName('attr');
        for(var i=0; i<elems.length; i++) {
            nameDebt = document.getElementById('debt_'+i).value;
            dateDebt = document.getElementById('date_'+i).value;
            debts+=nameDebt+':'+dateDebt+',';
        }
        debts=debts.substring(0, debts.length - 1);
    }
    getFile =document.getElementById('fileTrack').files[0];
    var ajax = new Ajax("POST","/student/change_debt");
    ajax.setData("id=" + idModule + "&status=" + nowStatus + "&debts=" + debts);
    if(getFile)
        ajax.appendFile('file',getFile);
    ajax.send(function (data) {
        if(data=="OK") {
            alert('Изменения применены');
            location.reload();
        }
        else
            alert(data);
    });
}