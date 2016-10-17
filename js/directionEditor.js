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
    var send = new Ajax("POST","/direction/edit_all");
    send.setData("directions="+selectedDirections);
    send.send(function (data) {
        status = data;
        if(status=="OK") {
            document.location.href = "/direction";
        }
        else {
            alert(status);
        }
    });
}

function cancelChanges() {
    window.history.back();
}