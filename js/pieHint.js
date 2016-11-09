var hint;

function createHint() {
    var span = document.createElement("span");
    span.id = "hint";
    span.style["position"] = "absolute";
    span.style.padding = "5px";
    span.style.backgroundColor = "#3547C3";
    span.style.color = "fff";
    span.style.border = "1px solid white";
    span.style.borderRadius = "5px";
    span.style.line
    document.getElementsByClassName("data_content")[0].appendChild(span);
    hint = document.getElementById("hint");
    hideHint();
}

function displayHint(event ,text) {
    hint.style.visibility = "visible";
    hint.innerText = text;
    hint.style.left=(event.pageX+20)+"px";
    hint.style.top=event.pageY+"px";
}

function hideHint() {
    hint.style.visibility = "hidden";
}

onload = createHint();

function delUniver(e,id) {
    e.stopPropagation();
    var conf = confirm("Вы уверены, что хотите удалить этот университет? Все студенты и программы этого университета будут удалены");
    if(conf) {
        var ajax = new Ajax("POST","/university/delete");
        ajax.setData("id="+id);
        ajax.send(function (data) {
            if(data=='OK') {
                location.reload();
            }
            else {
                alert(data);
            }
        });
    }
}
