function Ajax(type, path) {
    this.type = type;
    // !!
    // this.path = path;
    this.path = "/cripple"+path;
    // !!
    this.data = "";
    this.sendData = "";
    this.xhttp = "";
    if (window.XMLHttpRequest){
        this.xhttp=new XMLHttpRequest();
    }
    else {
        this.xhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
}
Ajax.prototype = {
    setData: function (x) {
        this.sendData = x;
    },
    send: function (callback) {
        if(this.type == "POST") {
            this.xhttp.open("POST",this.path,true);
            this.xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            if(this.sendData.length) {
                this.xhttp.send(this.sendData);
            }
            else this.xhttp.send();
        }
        else if(this.type == "GET") {
            this.xhttp.open("GET",this.path,true);
            this.xhttp.send();
        }
        this.xhttp.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200) {
                callback(this.responseText);
            }
        }
    },
    setLocation: function(curLoc){
        try {
            history.pushState(null, null, curLoc);
            return;
        } catch(e) {}
        location.hash = '#' + curLoc;
    }
}
