var optionNew = "Загрузить новый файл";
var optionExist = "Оставить текущий файл";
var optionDelete = "Удалить файл";
var optionNone = "Отсутствует";

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

    var dataName = name.value;
    var dataNozology = nozology.selectedOptions[0].id.substr(1);
    var dataDateBegin = dateBegin.value.split("-").join(".");
    var dataDateEnd = dateEnd.value.split("-").join(".");

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

    var data = dataName+";"+dataNozology+";"+dataDateBegin+";"+dataDateEnd;

    var send = new Ajax("POST",document.location.href);

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
        data = appendFile(data, 'select_plans', send, 'filePlan', 'ce_fileNamePlan');
        send.appendFile('fileProgram', document.getElementById('ce_fileNameProgram').files[0]);
    } else if (radioCurrentChange.checked){
        var result = saveCurrentChange();
        if (!result) return;
        data = "currChange=" + data +result;
    } else if (radioAddNew.checked){
        var result = saveAddNew();
        if (!result) return;
        data = "saveNew=" + data + result;
        data = appendFile(data, 'select_an_plans', send, 'filePlan', 'an_fileNamePlan');
        send.appendFile('fileProgram', document.getElementById('an_fileNameProgram').files[0]);
    }

    data = appendFile(data, 'select_rehabilitation', send, 'fileRehabilitation', 'fileNameReability');
    data = appendFile(data, 'select_psychology', send, 'filePsycho', 'fileNamePsycho');
    data = appendFile(data, 'select_career', send, 'fileCareer', 'fileNameCareer');
    data = appendFile(data, 'select_employment', send, 'fileEmployment', 'fileNameEmployment');
    data = appendFile(data, 'select_distance', send, 'fileDistance', 'fileNameDistance');
    data = appendFile(data, 'select_portfolio', send, 'filePortfolio', 'fileNamePortfolio');
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

function appendFile(data, selectId, ajax, fileId, elementId){
    var selectedOption = document.getElementById(selectId).selectedOptions[0];
    if  (selectedOption.value == optionNew){
        ajax.appendFile("new"+fileId, document.getElementById(elementId).files[0]);
    }
    else if (selectedOption.value == optionDelete){
        data+="&"+fileId+"=null";
    }
    else if(selectedOption.value == optionExist){
        data+="&"+fileId+"="+selectedOption.id;
    }
    else if (selectedOption.value == optionNone){
        data+="&"+fileId+"=null";
    }
    return data;
}

function saveCurrentEdit() {
    var id = document.getElementById("programId").innerText;
    return parseProgramData('ce_')+";"+id;
}

function saveCurrentChange() {
    var program = document.getElementById("program").selectedOptions[0].id.substr(1);

    var regularProgram = /^[0-9]{1,4}$/;

    if (!regularProgram.test(program)){
        alert("Недопустимая программа");
        return false;
    }

    return ";"+program;
}

function saveAddNew() {
    var result = parseProgramData('an_');
    if (!result) return false;
    return result;
}

function parseProgramData(prefix) {
    var direction = document.getElementById(prefix+'direction');
    var profile = document.getElementById(prefix+'profile');
    var level = document.getElementById(prefix+'level');
    var period = document.getElementById(prefix+'period');
    var form = document.getElementById(prefix+'form');
    var program = document.getElementById(prefix+'fileNameProgram');

    var dataDirection = direction.selectedOptions[0].id;
    var dataProfile = profile.value;
    var dataLevel = level.selectedOptions[0].value;
    var dataPeriod = period.value;
    var dataForm = form.selectedOptions[0].value;
    var dataProgram = program.files[0];

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
    if (dataProgram == null){
        alert("Необходим файл программы обучения");
        return false;
    }

    return ";"+dataDirection+";"+dataProfile+";"+dataLevel+";"+dataPeriod+";"+dataForm;
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

function processSelect(select, textId, fileId) {
    if (select.selectedOptions[0].value == optionExist){
        document.getElementById(fileId).style.display = "none";
        document.getElementById(textId).style.display = "inline";
    } else if (select.selectedOptions[0].value == optionDelete){
        document.getElementById(fileId).style.display = "none";
        document.getElementById(textId).style.display = "none";
    } else if (select.selectedOptions[0].value == optionNew){
        var text = document.getElementById(textId);
        if(text != null){
            text.style.display = "none";
        }
        document.getElementById(fileId).style.display = "inline";
    } else if(select.selectedOptions[0].value == optionNone){
        document.getElementById(fileId).style.display = "none";
    }
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
    if(file) nowFile = "<a href='/orders/"+file+"'><img width='40' src='"+image_file(file)+"'></a>";
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>" +
        "<div id='status_line'>"+getStatus(status)+" <button class='button' id='change_status_module' onclick='addDebt(true)'>Добавить долг</button></div>" +
        "<div id='addSubject'></div>" +
            "<div id='adaptiveDisc'></div>"+
            "<div class='fileTrack href'>" + nowFile +
        "<br><input type='file' id='fileTrack'></div>" +
        "<button class='button saveTrajectory' onclick='saveTrack()'>Сохранить</button> </div>";
    showDebt();
    showAdaptive();
}

function getStatus(status) {
    var allStatus = ["Активен","Задолженность","Закончен","Отчислен"];
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
function addAdaptive(show) {
    adaptArr.push('');
    if(show)
        showAdaptive();
}
function showAdaptive() {
    info = '';
    info+= '<b>Адаптивные дисциплины:</b> <button class="button" onclick="addAdaptive(true)">Добавить</button>';
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
function delAdaptive(i) {
    adaptArr.splice(i,1);
    showAdaptive();
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

function image_file(file) {
    file = file.split(".");
    var image = '';
    switch (file[1]) {
        case 'pdf': image='/images/pdf_file.png'; break;
        case 'doc':
        case 'docx': image='/images/doc_file.png'; break;
    }
    return image;
}

function saveTrack() {
    var status = nowStatus;
    var module = numModule;
    var debts = '';
    var adaptDisc = '';
    if(status=='Задолженность') {
        elems = document.getElementsByClassName('attr');
        for(var i=0; i<elems.length; i++) {
            nameDebt = document.getElementById('debt_'+i).value;
            dateDebt = document.getElementById('date_'+i).value;
            if(nameDebt.length && dateDebt.length)
                debts+=nameDebt+':'+dateDebt+',';
        }
        debts=debts.substring(0, debts.length - 1);
    }
    adapts = document.getElementsByClassName('adapt');
    for(i=0; i<adapts.length; i++) {
        adapt = document.getElementById("adaptVal_"+i).value;
        if(adapt.length)
            adaptDisc+=adapt+',';
    }
    adaptDisc=adaptDisc.substring(0, adaptDisc.length - 1);
    getFile =document.getElementById('fileTrack').files[0];
    var ajax = new Ajax("POST","/student/change_debt");
    ajax.setData("id=" + idModule + "&status=" + nowStatus + "&debts=" + debts + "&adapts=" + adaptDisc);
    if(getFile)
        ajax.appendFile('file',getFile);
    ajax.send(function (data) {
        if(data=="OK") {
            alert('Изменения применены');
            location.reload();
        }
        else
            console.log(data);
    });
}