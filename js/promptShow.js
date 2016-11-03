/**
 * Created by vladislav on 12.10.16.
 */
var adaptArr = new Array();
onload = function () {
    widthTable = document.getElementById('trackTable').offsetWidth;
    document.getElementById('promt').style.width = (widthTable-30)+"px";
}
function prompShow(num, status, text, file, adapt) {
    adaptArr = [];
    prom = document.getElementById('promt');
    //prom.style.backgroundColor = "#ffffff";
    //prom.style.border = "1px solid #8e8e8e";
    var info = '';
    var name = Array();
    parseAdaptive(adapt);
    if(file) file = "<a href='/orders/"+file+"'><img width='40' src='"+image_file(file)+"'></a>";    text = text.split(";");
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            name = text[i].split("=");
            info += "<div class='strDebt'><div class='leftLabel'>"+name[0] + ":</div> <div class='dataDebt'>Сдать до <b>" + name[1]+"</b></div></div>";
        }
    }
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>"+info+"</div>"
        + "<div id='adaptiveDisc'></div>" + file;
    showAdaptive();
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

function parseAdaptive(text) {
    text = text.split(";");
    var name = new Array();
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            adaptArr.push(text[i]);
        }
    }
}

function showAdaptive() {
    info = '';
    if(adaptArr.length) {
        info += '<b>Адаптивные дисциплины:</b>';
        for (var i = 0; i < adaptArr.length; i++) {
            info += "<div class='adapt'>" +
                adaptArr[i] + "</div>";
        }
        nowAdapt = info;
        document.getElementById('adaptiveDisc').innerHTML = info;
    }
}