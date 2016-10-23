/**
 * Created by vladislav on 12.10.16.
 */
onload = function () {
    widthTable = document.getElementById('trackTable').offsetWidth;
    document.getElementById('promt').style.width = (widthTable-30)+"px";
}
function prompShow(num, status, text, file) {
    prom = document.getElementById('promt');
    //prom.style.backgroundColor = "#ffffff";
    //prom.style.border = "1px solid #8e8e8e";
    var info = '';
    var name = Array();
    if(file) file = "<a class='href' href='/orders/"+file+"'>Прикрепленный файл</a>";
    text = text.split(" ");
    for(var i=0; i<text.length; i++) {
        if(text[i]) {
            name = text[i].split("=");
            info += name[0] + ': Сдать до ' + name[1]+"<br>";
        }
    }
    prom.innerHTML = "<div class='numbSemestr'>"+num+"-й семестр.</div>" +
        "<div class='statusSemestr'>"+status+"</div>" +
        "<div class='textSemestr'>"+info+"</div>" + file;
}