
function openDirectionEditor(){
    document.location.href = "/directions_editor";
}

function toogleCheckbox(event) {
    if (event.target["tagName"].toUpperCase() == "TD") {
        var checkbox = event.target.parentNode.getElementsByTagName("input")[0];
        checkbox.checked = !checkbox.checked;
    }
}

function saveChanges() {
    var inputs = document.getElementsByTagName("input");
    var selectedDirections = "";
    for (var i=0; i<inputs.length; i++){
        var input = inputs[i];
        if (input.type === "checkbox" && input.checked){
            selectedDirections += input["id"] + ";";
        }
    }
    var send = new Ajax("POST");
    send.setData("directions="+selectedDirections);
    send.send("/directions_editor/addDirections");
    send.xhttp.onreadystatechange = function () {
        if(send.xhttp.readyState == 4 && send.xhttp.status == 200) {
            status = send.xhttp.responseText;
            if(status=="OK") {
                document.location.href = "/control";
            }
            else {
                alert(status);
            }
        }
    }
}

function cancelChanges() {
    document.location.href = "/control";
}