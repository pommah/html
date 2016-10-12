function Ajax(type) {
    this.type = type;
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
    send: function (path) {
        if(this.type == "POST") {
            this.xhttp.open("POST",path,true);
            this.xhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            if(this.sendData.length) {
                this.xhttp.send(this.sendData);
            }
            else this.xhttp.send();
        }
        else if(this.type == "GET") {
            this.xhttp.open("GET",path,true);
            this.xhttp.send();
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